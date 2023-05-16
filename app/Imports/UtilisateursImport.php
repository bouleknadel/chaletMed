<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UtilisateursImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
         return new User([
            'name' => $row['PRENOM'],
            'lastname' => $row['NOM'],
            'numero_devilla' => $row['NUMERO CHALET'],
            'numero_de_telephone' => $row['CONTACT'],
            'email' => $row['CONTACT'] . '@gmail.com',
            'password' => bcrypt($row['CONTACT'])
        ]);
    }
}
