<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class NoticeController extends Controller
{
    public function index()
    {
        return response()->json(Notice::all());
    }

    public function store(Request $request)
{
    // Validate the request
    $request->validate([
        'title' => 'required|string',
        'description' => 'required|string',
        'category' => 'required|string',
        'author' => 'required|string',
        'notice_date' => 'required|date',
        'file' => 'file|mimes:pdf|max:20480', // 20MB max
    ]);

    // Check if file is present
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('notices', $fileName, 'public'); // Save in storage/app/public/notices

        // Save the file path in the database
        $notice = new Notice();
        $notice->title = $request->title;
        $notice->description = $request->description;
        $notice->category = $request->category;
        $notice->author = $request->author;
        $notice->notice_date = $request->notice_date;
        $notice->file = $filePath; // Save path in database
        $notice->save();

        return response()->json(['message' => 'Notice created successfully', 'data' => $notice], 201);
    }

    return response()->json(['message' => 'File upload failed'], 400);
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
}
