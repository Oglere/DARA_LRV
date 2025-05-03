<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Routing\Controller;
use App\Models\DocumentRepository;
use App\Models\Notification_logs;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{ 
    public function dashboard()
    {
        $totalUsers = User::count();

        $totalMsgs = User::where('status', '=', 'Deleted')->count();

        $totalStudies = DocumentRepository::count();

        $previousMonthStudies = DocumentRepository::whereBetween('date_submitted', [
            now()->subMonth()->startOfMonth(),
            now()->subMonth()->endOfMonth()
        ])->count();

        $currentMonthStudies = DocumentRepository::whereBetween('date_submitted', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])->count();
        
        $numberChange = $currentMonthStudies - $previousMonthStudies;
        $numberChange = $numberChange > 0 ? $numberChange : 0;

        $recentUsersOnline = User::whereNotNull('last_login')
            ->orderBy('last_login', 'desc')
            ->take(5)
            ->get();

        $studyDistribution = DocumentRepository::query()
            ->select('status', DB::raw('count(*) as count'))
            ->where('status', '!=', '0')
            ->groupBy('status')
            ->get();

        $studiesPerMonth = DocumentRepository::select(
            DB::raw('MONTH(date_submitted) as month'),
            DB::raw('COUNT(*) as total')
        )
        ->where('date_submitted', '>=', now()->subMonths(8))
        ->groupBy('month')
        ->orderBy('month', 'asc')
        ->get();

        $months = [];
        for ($i = 6; $i >= 0; $i--) {
            $months[] = Carbon::now()->subMonths($i)->format('F'); 
        }

        $studiesData = DocumentRepository::select(
            DB::raw('MONTH(date_submitted) as month'),
            DB::raw('YEAR(date_submitted) as year'),
            DB::raw('SUM(CASE WHEN status = "Approved" THEN 1 ELSE 0 END) as published'),
            DB::raw('SUM(CASE WHEN status != "Approved" THEN 1 ELSE 0 END) as unpublished')
        )
        ->where('date_submitted', '>=', Carbon::now()->subMonths(6)->startOfMonth()) 
        ->groupBy('year', 'month')
        ->orderBy('year', 'asc')
        ->orderBy('month', 'asc')
        ->get();

        $published = array_fill(0, 7, 0);  
        $unpublished = array_fill(0, 7, 0);

        // Fill in actual data
        foreach ($studiesData as $data) {
            $monthName = Carbon::createFromDate($data->year, $data->month, 1)->format('F');
            $index = array_search($monthName, $months); // Find correct index for this month

            if ($index !== false) {
                $published[$index] = $data->published;
                $unpublished[$index] = $data->unpublished;
            }
        }

        $totalSpaceUsed = DocumentRepository::selectRaw('SUM(OCTET_LENGTH(file)) as total_space')->value('total_space');

        $totalSpaceFormatted = $this->formatSizeUnits($totalSpaceUsed);

        return view("admin.dashboard", compact(
            'totalUsers', 'totalMsgs', 'totalStudies',
            'previousMonthStudies', 'numberChange', 'recentUsersOnline',
            'studyDistribution', 'studiesPerMonth', 'months', 'published', 'unpublished', 'totalSpaceFormatted',
        ));
    }

    private function formatSizeUnits($bytes) {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            return $bytes . ' bytes';
        } else {
            return '0 bytes';
        }
    }

    public function userControl(Request $request) {
        $adminId = Auth::id();
        $search = $request->input('search');
        $role = $request->input('role');
    
        $query = User::where('user_id', '!=', $adminId)
                     ->where('status', '!=', 'Deleted');
    
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }
    
        if ($role && $role !== 'all') {
            $query->where('role', $role);
        }
    
        $org = $query->paginate(10)->withQueryString();
    
        return view('admin.user-control', [
            'org' => $org,
            'roles' => User::select('role')->distinct()->pluck('role'),
            'statuses' => User::select('status')->distinct()->pluck('status'),
            'totalMsgs' => Notification_logs::where('is_checked', 1)->count(),
        ]);
    }

    public function edit() {

        return view("admin.edit");
    }
    
    public function messages(Request $request) {
        $search = $request->input('search');
        $status = $request->input('status');
    
        $query = DocumentRepository::query()->where('status', '!=', '0');
    
        if ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        }
    
        if ($status && $status !== 'all') {
            $query->where('status', $status);
        }
    
        $documents = $query->paginate(10)->withQueryString(); 
    
        foreach ($documents as $doc) {
            $doc->formatted_size = $this->formatSizeUnits(strlen($doc->file));
        }
    
        return view('admin.messages', ['docu' => $documents]);
    }
    

    public function markAsDone(Request $request){
        $notificationId = $request->input('notification_id');
        DB::table('account_requests')->where('notification_id', $notificationId)->delete(); // Mark as done by deleting

        return redirect()->route('account.requests')->with('success', 'Request marked as done.');
    }

    public function recovery() {
        $totalMsgs = Notification_logs::where('is_checked', '=', '1')->count();

        $org = User::where('status', '=', 'Deleted')
                    ->get();

        $roles = User::select('role')->distinct()->pluck('role');
        $statuses = User::select('status')->distinct()->pluck('status');

        return view("admin.recovery", [
            "org"=> $org, 
            "roles" => $roles, 
            "statuses" => $statuses,
            "totalMsgs" => $totalMsgs
        ]);

    }

    public function pdf($id) {
        $document = DocumentRepository::findOrFail($id);

        $metadata = is_array($document->metadata) ? $document->metadata : json_decode($document->metadata, true);
        $category = is_string($document->study_type)
            ? json_decode($document->study_type, true)
            : $document->study_type;

        return view('admin.pdf-reader', [
            'title' => $document->title,
            'abstract' => $metadata['abstract'],
            'publication_date' => $metadata['publication_date'] ?? 'No Date',
            'keywords' => $metadata['keywords'] ?? [],
            'studytype' => $category,
            'pdf_data' => $document->file,  
        ]);
    }

    public function getDashboardStats() {
        $studyDistribution = DocumentRepository::select('status', DB::raw('count(*) as count'))
            ->where('status', '!=', '0')
            ->groupBy('status')
            ->get();

        $studiesPerMonth = DocumentRepository::select(
            DB::raw('MONTH(date_submitted) as month'),
            DB::raw('COUNT(*) as total')
        )
            ->where('date_submitted', '>=', now()->subMonths(8))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'studyDistribution' => $studyDistribution,
            'studiesPerMonth' => $studiesPerMonth
        ]);
    }

    public function getRecentUsersOnline() {
        $recentUsersOnline = User::whereNotNull('last_login')
            ->orderBy('last_login', 'desc')
            ->take(5)
            ->get(['first_name', 'last_name', 'last_login']);

        return response()->json($recentUsersOnline);
    }

}
