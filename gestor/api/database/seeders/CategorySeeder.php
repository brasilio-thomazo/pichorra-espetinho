<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                'user_id' => 1,
                'name' => 'Espetinhos',
                'image' => 'category63c00e92bafce7.26055983.png',
            ],
            [
                'user_id' => 1,
                'name' => 'Bebidas',
                'image' => 'category63c00ed0dfa3b1.85914598.png',
            ]
        ];
        foreach ($datas as $data) {
            Category::factory()->create($data);
        }
    }
}
