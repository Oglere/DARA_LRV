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

        $documents = DocumentRepository::with('student')  // Assuming relation is defined
            ->where('status', 'Pending')
            ->where('teacher_id', $teacher_id)
            ->get();

        return view('teacher.review-studies', [
            'documents' => $documents,
        ]);
    }

    public function edit(){
        return view('teacher.edit');
    }
}
