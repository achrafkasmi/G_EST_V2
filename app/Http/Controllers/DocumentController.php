<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use Illuminate\Support\Facades\Auth;

class DocumentController extends Controller
{
    /**
     * Show the "managedocuments" view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function managedocuments()
    {
        return view('managedocuments');
    }

    /**
     * Store a newly created document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function showStudentDocuments()
    {
        // Retrieve documents where user_role is 3 (student)
        $documents = Document::where('user_role', 3)->get();
    
        // Pass the retrieved documents and the user's role to the Blade view
        return view('edocument', ['documents' => $documents, 'userRole' => 'student']);
    }
    
    public function showStaffDocuments()
    {
        // Retrieve documents where user_role is 2 (staff)
        $documents = Document::where('user_role', 2)->get();
    
        // Pass the retrieved documents and the user's role to the Blade view
        return view('edocument', ['documents' => $documents, 'userRole' => 'teacher']);
    }

    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'fileType' => 'required',
            'stageFile' => 'required|file|max:30720', // Max file size in KB (30MB)
            'textInput' => 'required|string|max:100',
        ]);

        // Get the file path and store it in the 'e-documents' folder within the 'public' disk
        $filePath = $request->file('stageFile')->storeAs('public/e-documents', $request->file('stageFile')->getClientOriginalName());

        // Create a new document instance
        $document = new Document();
        $document->intitule_document = $request->input('textInput');
        $document->type_document = $request->input('fileType');
        $document->document = $filePath;

        // Set user_role based on document type
        if ($request->input('fileType') === 'student') {
            $document->user_role = 3; // Student
        } elseif ($request->input('fileType') === 'teacher') {
            $document->user_role = 2; // Teacher
        }

        // Save the document
        $document->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }
}
