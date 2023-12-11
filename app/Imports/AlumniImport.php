<?php

namespace App\Imports;

use App\Models\AlumniStudent;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;

class AlumniImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // dd($rows);
        //  Validator::make($rows->toArray(), [
        //      '*.name' => 'required',
        //      '*.registration_no' => 'required',
        //  ])->validate();
  
        foreach ($rows as $row) {
            if(!empty($row['registration_no']) && !empty($row['name'])) {
                AlumniStudent::firstOrCreate([
                    'name' => $row['name'],
                    'registration_no' => $row['registration_no'],
                ],[
                    'mobile' => $row['phone'] ? $row['phone'] : null,
                    'tshirt_size' => $row['tshirt_size'] ? $row['tshirt_size'] : null,
                    'ssc_batch' => $row['ssc_batch'] ? $row['ssc_batch'] : null,
                    'father' => $row['father'] ? $row['father'] : null,
                    'permanent_address' => $row['permanent_address'] ? $row['permanent_address'] : null,
                    'form_no' => $row['registration_no'],
                    'unique_code' => makeUniqueId(),
                    'added_by' => Auth::id(),
                    'registration_fees' => $row['fees'] ? $row['fees'] : 500 
                ]);
            }  
        }
    }
}
