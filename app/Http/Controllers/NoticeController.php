<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use App\Exports\NoticesExport;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $notices = Notice::when($search, function ($query, $search) {
                return $query->where('title', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")->orWhere('author', 'LIKE', "%{$search}%")->orWhere('category', 'LIKE', "%{$search}%");
            })->get();
        if ($notices->isEmpty()) {
            return response()->json([
                'message' => 'No matching notice found.',
                'status' => false
            ], 200);
        }
        // Return users as JSON (for API) or view (for web routes)
        return response()->json($notices);
    }

//     public function store(Request $request)
// {
//     // Validate the request
//     $request->validate([
//         'title' => 'required|string',
//         'description' => 'required|string',
//         'category' => 'required|string',
//         'author' => 'required|string',
//         'notice_date' => 'required|date',
//         'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,svg,zip,rar,txt,csv|max:20480', // 20MB max
//     ]);

//     // Check if file is present
//     if ($request->hasFile('file')) {
//         $file = $request->file('file');
//         $fileName = time() . '_' . $file->getClientOriginalName();
//         $filePath = $file->storeAs('notices', $fileName, 'public'); // Save in storage/app/public/notices

//         // Save the file path in the database
//         $notice = new Notice();
//         $notice->title = $request->title;
//         $notice->description = $request->description;
//         $notice->category = $request->category;
//         $notice->author = $request->author;
//         $notice->notice_date = $request->notice_date;
//         $notice->file = $filePath; // Save path in database
//         $notice->save();

//         return response()->json(['message' => 'Notice created successfully', 'data' => $notice], 201);
//     }

//     return response()->json(['message' => 'File upload failed'], 400);
// }
public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'title' => 'string',
        'description' => 'string',
        'category' => 'string',
        'author' => 'string',
        'notice_date' => 'date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,svg,zip,rar,txt,csv|max:20480', // 20MB max
    ]);

    // Create a new Notice instance
    $notice = new Notice();
    $notice->title = $request->title;
    $notice->description = $request->description;
    $notice->category = $request->category;
    $notice->author = $request->author;
    $notice->notice_date = $request->notice_date;

    // Check if file is present and save it
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('notices', $fileName, 'public'); // Save in storage/app/public/notices
        $notice->file = $filePath; // Save file path in database
    } else {
        $notice->file = null; // Set file to null if no file is uploaded
    }

    // Save the notice
    $notice->save();

    return response()->json(['message' => 'Notice created successfully', 'data' => $notice], 201);
}

public function update(Request $request, Notice $notice)
{
    // Validate the request
    $data = $request->validate([
        'title' => 'nullable|string',
        'description' => 'nullable|string',
        'category' => 'nullable|string',
        'author' => 'nullable|string',
        'notice_date' => 'nullable|date',
        'file' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,jpg,jpeg,png,gif,svg,zip,rar,txt,csv|max:20480',
    ]);

    // Check if file is present and save it like in store()
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('notices', $fileName, 'public'); // Save in storage/app/public/notices
        $data['file'] = $filePath; // Save full path in DB
    }

    // Update the notice
    $notice->update($data);

    return response()->json([
        'message' => 'Notice updated successfully',
        'notice' => $notice
    ]);
}



    public function show($id)
    {
        return response()->json(Notice::findOrFail($id));
    }

    public function download($id)
    {
        $notice = Notice::findOrFail($id);

        $pdf = Pdf::loadView('notices.pdf', compact('notice'));

        return $pdf->download('notice_' . $id . '.pdf');
    }

    public function deleteNotice($id)
{
    // Find the notice by ID
    $notice = Notice::find($id);

    if (!$notice) {
        return response()->json(['message' => 'Notice not found'], 404);
    }

    // Delete the file if it exists
    if ($notice->file) {
        $filePath = "public/" . $notice->file; // Adjust if stored differently
        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
        }
    }

    // Delete the notice record from the database
    $notice->delete();

    return response()->json(['message' => 'Notice deleted successfully']);
}
public function exportNotices()
{
    return Excel::download(new NoticesExport, 'notices.xlsx');
}
}
