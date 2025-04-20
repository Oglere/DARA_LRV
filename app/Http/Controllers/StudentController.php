<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\DocumentRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class StudentController extends Controller
{
    //

    public function dashboard() {
        $id = Auth::id();
        $submit_count = DocumentRepository::where('student_id', '=', $id)->count();
        $approved_count = DocumentRepository::query()
                            ->where('student_id', '=', $id)
                            ->where('status', '=', 'Approved')
                            ->count();
        $pending_count = DocumentRepository::query()
                            ->where('student_id', '=', $id)
                            ->where('status', '=', 'Pending')
                            ->count();
        $revisions_count = DocumentRepository::query()
                            ->where('student_id', '=',  $id)
                            ->where('status', '=', 'Needs Revision')
                            ->count();
        $rejected_count = DocumentRepository::query()
                            ->where('student_id', '=', $id)
                            ->where('status', '=', 'Rejected')
                            ->count();


        return view('student.dashboard', [
            'total_submit' => $submit_count,
            'total_approved' => $approved_count,
            'total_pending' => $pending_count,
            'total_revisions' => $revisions_count,
            'total_rejected' => $rejected_count,
        ]);
    }

    public function submission() {
        $teacher = User::where('role', 'Teacher')->get(); // Fetch all teachers
    
        return view('student.document-submission', ['teacher' => $teacher]);
    }

    public function status(){
        $auth = Auth::id();

        $documents = DocumentRepository::where('student_id', '=',$auth)->get();
        
        $reviewed = $documents->filter(function ($doc) {
            return !empty($doc->date_reviewed);
        })->pluck('document_id');

        return view('student.document-status', [
            'documents' => $documents,
            'auth' => $auth,
            'reviewed' => $reviewed
        ]);
    }


    public function edit() {
        return view('student.edit');
    }

    public function submit(Request $request) {
        $request->validate([
            'title' => 'required|min:3',
            'abstract' => 'required',
            'co_authors' => 'nullable|string',
            'keywords' => 'nullable|string',
            'teacher_id' => 'required|exists:users,user_id',
            'publication_date' => 'nullable|date',
            'citations' => 'nullable|string',
            'file' => 'required|mimes:pdf|max:512000',
            'document_types' => 'required',
            'document_types.*' => 'string'
        ], [
            'title.required' => 'The title is required.',
            'title.min' => 'The title must be at least 3 characters.',
            'abstract.required' => 'The abstract is required.',
            'teacher_id.required' => 'Please select a teacher.',
            'teacher_id.exists' => 'The selected teacher does not exist.',
            'publication_date.date' => 'The publication date must be a valid date.',
            'file.required' => 'A PDF file is required.',
            'file.mimes' => 'The file must be a PDF.',
            'file.max' => 'The file size should not exceed 500MB.',
            'document_types.required' => 'Please select at least one document type.',
            'document_types.*.in' => 'Invalid document type selected.'
        ]);
    
        $coAuthors = $request->co_authors ? explode(',', $request->co_authors) : [];
        $keywords = $request->keywords ? explode(',', $request->keywords) : [];
        $citations = $request->citations ? explode(',', $request->citations) : [];
        $documentTypes = $request->document_types;
    
        $metadata = [
            'keywords' => $request->keywords,
            'abstract' => $request->abstract,
            'publication_date' => $request->publication_date,
        ];
    
        $fileData = file_get_contents($request->file('file')->getRealPath());
    
        $document = new DocumentRepository();
        $document->title = $request->title;
        $document->student_id = Auth::id();
        $document->teacher_id = $request->teacher_id;
        $document->authors = $coAuthors;
        $document->citations = $citations;
        $document->metadata = $metadata;
        $document->file = $fileData;
        $document->status = 'Pending';
        $document->date_submitted = now();
        $document->study_type = $documentTypes;
        $document->save(); // ✅ This saves the model
    
        return redirect()->back()->with('success', 'Document submitted successfully!');
    }
    

    public function pdf_reader($id) {
        $documentdata = DocumentRepository::findOrFail($id);
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return abort(400, "Invalid document ID.");
        }

        $document = DocumentRepository::where('document_id', $id)
                            ->where('student_id', Auth::id())
                            ->first();

        if (!$document) {
            return DocumentRepository::where('document_id', $id)->exists()
                ? back()->with('error', 'Document not yours.')
                : abort(404, 'Document not found.');
        }

        $study_type = is_string($document->study_type)
            ? json_decode($document->study_type, true)
            : $document->study_type;

        $metadata = is_array($document->metadata) ? $document->metadata : json_decode($document->metadata, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $metadata = [];
        }

        return view('student.pdf-reader', [
            'pdf_data' => base64_encode($document->file),
            'abstract' => $metadata['abstract'] ?? '',
            'study_type' => $study_type,
            'publication_date' => $metadata['publication_date'] ?? '',
            'keywords' => $metadata['keywords'] ?? [],
            'document' => $document
        ]);
    }

    public function request(Request $request) {
        $document = DocumentRepository::where('document_id', '=', $request->document_id)->first();

        if ($document) {
            $document->status = $request->input('action');
            $document->abandoned_date = now();
            $document->save();

            return redirect()->back()->with('success', 'Document status updated successfully.');
        }

        return redirect()->back()->with('error', 'Document not found.');
    }
}
