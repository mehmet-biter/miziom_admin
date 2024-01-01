<?php

namespace Database\Seeders;

use App\Models\CurrencyList;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CurrencyList::firstOrCreate(['code' => 'NGN'],['name' => 'Nigerian Naira', 'symbol' => "NGN"]);
    }
}
