<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UtilisateursImport;
use Maatwebsite\Excel\Facades\Excel;

class ImporterExel extends Controller
{
    public function import(Request $request)
    {
        $validatedData = $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        Excel::import(new UtilisateursImport, $request->file('file'));

        return redirect()->back()->with('success', 'Les utilisateurs ont été importés avec succès.');
    }
}
