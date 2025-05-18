<?php

namespace App\Http\Controllers\Teacher;

use GrahamCampbell\ResultType\Success;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentRepository;
use App\Models\User;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class TeacherController extends Controller
{
    public function dashboard(){
        $id = Auth::id();

        $review = DocumentRepository::query()
                    ->where('teacher_id', '=', $id)
                    ->where('status', '=', 'Pending')
                    ->count();

        $approved = DocumentRepository::query()
                    ->where('teacher_id', '=', $id)
                    ->where('status', '=', 'Approved')
                    ->count();

        $rejected = DocumentRepository::query()
                    ->where('teacher_id', '=', $id)
                    ->where('status', '=', 'Rejected')
                    ->count();

        return view('teacher.dashboard', [
            'review' => $review,
            'approved' => $approved,
            'rejected' => $rejected,
        ]);
    }

    public function review(){
        $teacher_id = Auth::id(); // Get currently logged-in teacher ID

        $documents = DocumentRepository::with('student')
            ->where('teacher_id', $teacher_id)
            ->where('status', '!=', '0')
            ->get();

        $reviewed = $documents->filter(function ($doc) {
            return !empty($doc->date_reviewed);
        });
    
        return view('teacher.review-studies', [
            'documents' => $documents,
            'reviewed' => $reviewed,
        ]);
    }

    public function edit(){
        return view('teacher.edit');
    }

    public function request(Request $request, $id) {
        $document = DocumentRepository::where('document_id', '=', $id)->first();

        if ($document) {
            $document->status = $request->input('action');
            $document->date_reviewed = now();
            $document->save();

            if ($document->status == 'Approved') {
                $user = User::where('user_id', '=', $document->student_id)->first();
                $mail = new PHPMailer(true);
                
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = env('MAIL_USERNAME');
                    $mail->Password = env('MAIL_PASSWORD');
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;
        
                    $mail->setFrom(env('MAIL_USERNAME'), 'OTP Verification');
                    $mail->addAddress($user->email);
                    $mail->Subject = 'Your Study Has Been Approved';
                    $mail->isHTML(true);
                    $mail->Body = "<p>Your Study <strong>$document->title</strong> has been approved!</p>";
                    
                    $mail->send();

                    return redirect()->back()->with('success', 'Document status updated successfully.');
                } catch (Exception $e) {
                    return back()->withErrors(['email' => 'Could not send email. Error: ' . $mail->ErrorInfo]);
                }
            } else {
                return redirect()->back()->with('success', 'Document status updated successfully.');
            }
        } else { 
            return redirect()->back()->with('error', 'Document not found.');
        }
    }
}
