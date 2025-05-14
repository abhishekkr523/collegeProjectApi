<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Admin\IssueBook;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class GetDashboardDataController extends Controller
{
    public function getMonthlyPieChartPresentData(Request $request)
    {
        $year = $request->input('year');
        //    $getAllYearForIssueBooks = $request->input('getIssueBookYear');

        if (!$year || !is_numeric($year)) {
            return response()->json(['error' => 'Valid year is required'], 400);
        }
        $getYears = DB::table('attendances')
            ->select(DB::raw('YEAR(date) as year'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();
        $issueBookYears = DB::table('issue_books')
            ->select(DB::raw('YEAR(issue_date) as year'))
            ->groupBy(DB::raw('YEAR(issue_date)'))
            ->orderBy('year', 'asc')
            ->pluck('year')
            ->toArray();
        $allYears = array_unique(array_merge($getYears, $issueBookYears));
        sort($allYears);

        $monthlyData = DB::table('attendances')
            ->select(
                DB::raw("YEAR(date) as year"),
                DB::raw("MONTH(date) as month_number"),
                DB::raw("MONTHNAME(date) as month_name"),
                DB::raw("COUNT(*) as present_count")
            )
            ->whereYear('date', $year)
            ->where('attendance_status', 'present')
            ->groupBy(DB::raw("YEAR(date), MONTH(date), MONTHNAME(date)"))
            ->orderBy(DB::raw("MONTH(date)"))
            ->get();

        // Total attendance count
        $totalAttendance = DB::table('attendances')
            ->count();

        $totalPresent = DB::table('attendances')
            ->where('attendance_status', 'present', 'late')
            ->count();

        $remainingAttendance = $totalAttendance - $totalPresent;

        // Total books available (sum of all quantities in the books table)
        $totalBooks = DB::table('books')->count();
        $issuedBooks = DB::table('issue_books')
            ->where('status', 'pending')
            ->count();
        $issuedBooksForYear = IssueBook::whereYear('issue_date', $year)->count();

        // Remaining books
        $remainingBooks = $totalBooks - $issuedBooks;

        return response()->json([
            'year' => $allYears,
            'monthly' => $monthlyData,
            'total_present' => $totalAttendance,
            'remaining_attendance' => $remainingAttendance,
            'total_books' => $totalBooks,
            'year_wise_book_issue' => $issuedBooksForYear,
            'remaining_books' => $remainingBooks,
        ]);
    }
    public function getBarChartData()
    {
        $attendanceData = DB::table('attendances')
            ->select(DB::raw('YEAR(date) as year'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('YEAR(date)'))
            ->orderBy('year', 'asc')
            ->get();
        $issueBookData = DB::table('issue_books')
            ->select(DB::raw('YEAR(issue_date) as year'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('YEAR(issue_date)'))
            ->orderBy('year', 'asc')
            ->get();
        return response()->json([
            'attendanceData' => $attendanceData,
            'issueBookData' => $issueBookData
        ]);
    }
}
