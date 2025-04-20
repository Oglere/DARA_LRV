<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DocumentRepository;
use App\Models\User;

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

            return redirect()->back()->with('success', 'Document status updated successfully.');
        }

        return redirect()->back()->with('error', 'Document not found.');
    }
}
