<?php

namespace App\Http\Controllers;

use App\Models\ReleveBnk;
use Illuminate\Http\Request;



class ReleveBnkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {
        $items = ReleveBnk::all();
        return view('releve_bnks.index', [
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
        return view('releve_bnks.create');
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
            'fichier.*' => 'required|file',
        ]);




        $item = new ReleveBnk;
        $item->designation = $request->designation;


        $files = $request->file('fichier');
        $recus = [];
        foreach ($files as $file) {
            $fileName = uniqid() . '_' . $file->getClientOriginalExtension();
            // Enregistrer le fichier dans le stockage public
            $file->move('uploads/releve_bnk/', $fileName);
            // Enregistrer le chemin d'accès au fichier dans la base de données
            $recus[] = $fileName;
        }

        $item->fichier = implode('###', $recus);
        $item->save();

        return back()->with('success', '   ReleveBnk ajoutée avec succès.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ReleveBnk  $releve_bnk
     * @return \Illuminate\Http\Response
     */
    public function show(ReleveBnk $releve_bnk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ReleveBnk  $releve_bnk
     * @return \Illuminate\Http\Response
     */
    public function edit(ReleveBnk $releve_bnk)
    {

        return view('releve_bnks.edit', [
            'item' => $releve_bnk
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ReleveBnk  $releve_bnk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'designation' => 'required',
            'fichier.*' => 'file|nullable',
        ]);
        $releve_bnk = ReleveBnk::findOrFail($id);

        $releve_bnk->designation = $request->get('designation');


        if ($request->has('fichier')) {
            $files = $request->file('fichier');
            $recus = [];
            foreach ($files as $file) {
                $fileName = uniqid() . '_' . $file->getClientOriginalExtension();
                // Enregistrer le fichier dans le stockage public
                $file->move('uploads/releve_bnk/', $fileName);
                // Enregistrer le chemin d'accès au fichier dans la base de données
                $recus[] = $fileName;
            }

            $releve_bnk->fichier = implode('###', $recus);
        }

        $releve_bnk->save();

        return redirect()->route('releve_bnks.index')->with('successedit', '   ReleveBnk modifiée avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ReleveBnk  $releve_bnk
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $releve_bnk = ReleveBnk::findOrFail($id);
        $releve_bnk->delete();

        return redirect()->route('releve_bnks.index')->with('successdelete', '   ReleveBnk supprimée avec succès.');
    }
}
