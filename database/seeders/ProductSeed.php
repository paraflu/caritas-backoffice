<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class ProductSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['Pasta di semola formati assotiti gr.500', 0.7],
            ['Riso', 1.7],
            ['Carne in scatola minilattina', 2.5],
            ['Latte UHT parzialmente scremato Lt.1', 1],
            ['Tonno gr.240', 2.5],
            ['Crackers sacco gr. 750', 1.5],
            ['Piselli reidratati gr. 400', 1],
            ['Fagioli borlotti gr. 400', 0.7],
            ['Biscotti kg. 1', 2.5],
            ['The ft 25', 1.6],
            ['Zucchero', 1.5],
            ['Sale grosso', 0.3],
            ['Sale fino', 0.3],
            ['Dadi star 10 cubetti', 0.9]
        ];

        Product::query()->delete();
        foreach ($data as $p) {
            Product::create([
                'description'=> $p[0],
                'price' => $p[1]
            ]);
        }
    }
}
