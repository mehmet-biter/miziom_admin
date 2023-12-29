<?php

namespace Database\Seeders;

use App\Models\Coin;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CoinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Coin::firstOrCreate(['coin_type' => 'BTC'],['name' => 'Bitcoin', 'network' => 2]);
        Coin::firstOrCreate(['coin_type' => 'USDT'],['name' => 'Tether USD', 'network' => 2]);

        $users = User::select('*')->get();
        if (isset($users[0])) {
            foreach ($users as $user) {
                $coins = Coin::select('*')->get();
                $count = $coins->count();
                for($i=0; $count > $i; $i++) {
                    Wallet::firstOrCreate(['user_id' => $user->id, 'coin_id' => $coins[$i]->id],
                        ['name' =>  $coins[$i]->coin_type.' Wallet', 'coin_type' => $coins[$i]->coin_type]);
                }
            }
        }
    }
}
