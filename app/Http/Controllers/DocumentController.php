<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Show the "managedocuments" view.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function managedocuments()
    {
        return view('managedocuments')->with(['active_tab' => 'addedoc']);
    }

    /**
     * Show documents for students.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showDocuments()
    {   
        $documents = Document::get();
        if(auth()->user()->role == 1){ //
        return view('edocument', ['documents' => $documents,'active_tab' => 'addedoc']);
        }else
        return view('edocument', ['documents' => $documents,'active_tab' => 'documents']);
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
            'stageFile' => 'required|file|max:30720',
            'textInput' => 'required|string|max:100',
        ]);

        $filePath = $request->file('stageFile')->storeAs('public/e-documents', $request->file('stageFile')->getClientOriginalName());

        $document = new Document();
        $document->intitule_document = $request->input('textInput');
        $document->type_document = $request->input('fileType');
        $document->document = $filePath;

        $document->save();

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }
}
