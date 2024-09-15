<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class DocumentController extends Controller
{
    public function index()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'addedoc';
        return view('documentmanagement', compact('active_tab'));
    }

    public function documentsettingsindex()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'addedoc';
        return view('documentsettings', compact('active_tab'));
    }

    /**
     * Show the "managedocuments" view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function managedocuments()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        return view('managedocuments')->with(['active_tab' => 'addedoc']);
    }


    public function showDocuments()
    {
        $documents = Document::where('is_archived', 0)->get();
        //dd($documents);
        if (auth()->user()->hasRole('student')) {
            $documents = $documents->where('type_document', 'student');
        } elseif (auth()->user()->hasRole('teacher')) {
            $documents = $documents->where('type_document', 'teacher');
        }

        return view('edocument', ['documents' => $documents, 'active_tab' => 'documents']);
    }

    /**
     * Store a newly created document in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'fileType' => 'required',
            'stageFile' => 'required|file|mimes:pdf|max:30720',
            'textInput' => 'required|string|max:10000', // Allow more characters to accommodate HTML
        ]);

        $filePath = $request->file('stageFile')->storeAs('public/e-documents', $request->file('stageFile')->getClientOriginalName());

        $document = new Document();
        $document->intitule_document = $request->input('textInput');
        $document->type_document = $request->input('fileType');
        $document->document = $filePath;

        $document->save();

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function griddocindex()
    {
        if (!auth()->user()->hasRole('admin')) {
            abort(403);
        }
        $active_tab = 'addedoc';
        $documents = Document::all(); // Fetch all documents from the t_documents table
        return view('documentsettings', compact('documents', 'active_tab'));
    }

    public function toggleArchive(Document $document)
    {
        // Toggle the 'is_archived' status
        $document->is_archived = !$document->is_archived;
        $document->save();

        return response()->json(['success' => true, 'is_archived' => $document->is_archived]);
    }


    public function deleteDocument(Document $document)
    {
        // Remove the 'public/' prefix from the path if it exists, as Storage::delete expects relative paths
        $path = str_replace('public/', '', $document->document);

        if (Storage::exists($path)) {
            Storage::delete($path);
        } else {
            return response()->json(['success' => false, 'message' => 'File not found in storage.']);
        }

        $document->delete();

        return response()->json(['success' => true]);
    }
}
