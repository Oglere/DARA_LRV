<?php

namespace App\Http\Controllers;

use Hamcrest\Core\IsNot;
use Illuminate\Http\Request;
use App\Models\DocumentRepository;
use Illuminate\Support\Facades\Auth;

class QueryController extends Controller
{
    public function index() {
        return view('index'); 
    }
    
    public function results(Request $request)
    {
        $query = DocumentRepository::query()
            ->select(
                'document_id',
                'student_id',
                'title',
                'authors',
                'study_type'
            )
            ->selectRaw("YEAR(JSON_UNQUOTE(JSON_EXTRACT(metadata, '$.publication_date'))) as publication_year")
            ->selectRaw("JSON_UNQUOTE(JSON_EXTRACT(metadata, '$.keywords')) as keywords")
            ->join('users', 'document_repository.student_id', '=', 'users.user_id')
            ->addSelect('users.last_name')
            ->where('document_repository.status', '=', 'Approved');

        if ($request->filled('search')) {
            $search = strtolower($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->whereRaw('LOWER(title) LIKE ?', ["%{$search}%"])
                ->orWhereRaw('LOWER(metadata) LIKE ?', ["%{$search}%"]);
            });
        }

        if ($request->filled('from-year') && $request->filled('to-year')) {
            $from = $request->input('from-year');
            $to = $request->input('to-year');
            $query->whereRaw("YEAR(JSON_UNQUOTE(JSON_EXTRACT(metadata, '$.publication_date'))) BETWEEN ? AND ?", [$from, $to]);
        }

        $selectedTypes = $request->input('document_types', []);
        if (!empty($selectedTypes) && count($selectedTypes) < 5) {
            $query->where(function($q) use ($selectedTypes) {
                foreach ($selectedTypes as $type) {
                    $q->orWhereJsonContains('document_repository.study_type', $type);
                }
            });
        }

        $results = $query->get();

        $results->transform(function ($item) {
            $keywords = json_decode($item->keywords, true);
            if (!is_array($keywords)) {
                $keywords = explode(',', $item->keywords);
            }
            $item->keywords = array_map('trim', $keywords);

            if (is_string($item->study_type)) {
                $type = json_decode($item->study_type, true);
                if (!is_array($type)) {
                    $type = explode(',', $item->study_type);
                }
                $item->study_type = array_map('trim', $type);
            }

            return $item;
        });

        return view('go.results', compact('results'));
    }


    public function pdf_reader($id) {
        $document = DocumentRepository::findOrFail($id);

        $metadata = is_array($document->metadata) ? $document->metadata : json_decode($document->metadata, true);
        $category = is_string($document->study_type)
            ? json_decode($document->study_type, true)
            : $document->study_type;

        return view('go.pdf-reader', [
            'title' => $document->title,
            'abstract' => $metadata['abstract'],
            'publication_date' => $metadata['publication_date'] ?? 'No Date',
            'keywords' => $metadata['keywords'] ?? [],
            'studytype' => $category,
            'pdf_data' => $document->file,  // base64 data or raw pdf file content
        ]);
    }

    public function pdf_reader_teacher($id) {
        $documentdata = DocumentRepository::findOrFail($id);
        if (!filter_var($id, FILTER_VALIDATE_INT)) {
            return abort(400, "Invalid document ID.");
        }

        $document = DocumentRepository::where('document_id', $id)
                            ->where('teacher_id', Auth::id())
                            ->first();

        if (empty($document->date_reviewed)) {
            $document->date_reviewed = now();
            $document->save();
        }

        if (!$document) {
            return DocumentRepository::where('document_id', $id)->exists()
                ? back()->with('error', 'Document not yours.')
                : abort(404, 'Document not found.');
        }

        $metadata = is_array($document->metadata) ? $document->metadata : json_decode($document->metadata, true);
        $study_type = is_string($document->study_type)
            ? json_decode($document->study_type, true)
            : $document->study_type;

        return view('teacher.pdf-reader', [
            'title' => $document->title,
            'publication_date' => $metadata['publication_date'] ?? 'No Date',
            'keywords' => $metadata['keywords'] ?? [],
            'document' => $document,
            'pdf_data' => base64_encode($document->file),
            'abstract' => $metadata['abstract'],
            'study_type' => $study_type,
        ]);
    }
}
