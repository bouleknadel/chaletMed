<?php

namespace App\Http\Controllers;

use App\Models\DocumentDiver;
use Illuminate\Http\Request;



class DocumentDiverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $items = DocumentDiver::all();
        return view('document_divers.index', [
            'items' => $items
        ]);
    }


    //--------------------------------------------------------------------------------------------------------------------------------------

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('document_divers.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'designation' => 'required',
            'fichier' => 'required|file',
        ]);




        $item = new DocumentDiver;
        $item->designation = $request->designation;


        $file = $request->file('fichier');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        // Enregistrer le fichier dans le stockage public
        $file->move('uploads/document_diver/', $fileName);
        // Enregistrer le chemin d'accès au fichier dans la base de données
        $item->fichier = $fileName;
        $item->save();

        return back()->with('success', '   DocumentDiver ajoutée avec succès.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentDiver  $document_diver
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentDiver $document_diver)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentDiver  $document_diver
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentDiver $document_diver)
    {

        return view('document_divers.edit', [
            'item' => $document_diver
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentDiver  $document_diver
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'designation' => 'required',
            'fichier' => 'file|nullable',
        ]);
        $document_diver = DocumentDiver::findOrFail($id);

        $document_diver->designation = $request->get('designation');


        if ($request->hasFile('fichier')) {
            $file = $request->file('fichier');
            $fileName = time() . '.' . $file->getClientOriginalName();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/document_diver/', $fileName);
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $document_diver->fichier = $fileName;
        }

        $document_diver->save();

        return redirect()->route('document_divers.index')->with('successedit', '   DocumentDiver modifiée avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentDiver  $document_diver
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document_diver = DocumentDiver::findOrFail($id);
        $document_diver->delete();

        return redirect()->route('document_divers.index')->with('successdelete', '   DocumentDiver supprimée avec succès.');
    }
}
