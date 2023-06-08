<?php

namespace App\Http\Controllers;

use App\Models\Annee;
use App\Models\Balance;
use Illuminate\Http\Request;



class BalanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function index(Request $request)
    {

        $items = Balance::all();
        $annees = Annee::orderBy('annee')->get();
        return view('balances.index', [
            'items' => $items,
            'annees' => $annees,
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
        return view('balances.create');
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
            'montant' => 'required',
            'annee' => 'required',
            'type' => 'required|in:1,0',
        ]);




        $item = new Balance;
        $item->montant = $request->montant;
        $item->annee = $request->annee;
        $item->debit = $request->type;
        $item->commentaire = $request->get('commentaire', null);
        $item->save();
        return back()->with('success', '   Balance ajoutée avec succès.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function show(Balance $balance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function edit(Balance $balance)
    {

        return view('balances.edit', [
            'item' => $balance
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'montant' => 'required',
            'annee' => 'required',
            'type' => 'required|in:1,0',
        ]);

        $balance = Balance::findOrFail($id);


        $balance->montant = $request->montant;
        $balance->annee = $request->annee;
        $balance->debit = $request->type;
        $balance->commentaire = $request->get('commentaire', null);


        $balance->save();

        return redirect()->route('balances.index')->with('successedit', '   Balance modifiée avec succès.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Balance  $balance
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $balance = Balance::findOrFail($id);
        $balance->delete();

        return redirect()->route('balances.index')->with('successdelete', '   Balance supprimée avec succès.');
    }
}
