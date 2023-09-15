<?php

namespace Database\Seeders;

use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
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
                'category_id' => 1,
                'name' => 'Tradicionais',
                'image' => 'subcategory.63c00f67524f25.67760206.png',
            ],
            [
                'user_id' => 1,
                'category_id' => 1,
                'name' => 'Especiais',
                'image' => 'subcategory.63c0100507aad7.95712809.png',
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'name' => 'Refrigerantes',
                'image' => 'subcategory.63c010a220af40.64241758.png',
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'name' => 'Destilados',
                'image' => 'subcategory.63c015b6c669a7.87947820.png',
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'name' => 'Cervejas',
                'image' => 'subcategory.63c010617db003.87004148.png',
            ],
            [
                'user_id' => 1,
                'category_id' => 2,
                'name' => 'Chopp\'s',
                'image' => 'subcategory.63c016965a4b81.07413418.png',
            ]
        ];
        
        foreach ($datas as $data) {
            Subcategory::factory()->create($data);
        }
    }
}
