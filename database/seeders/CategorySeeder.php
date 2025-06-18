<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Énergisants',
                'description' => 'Des boosters d\'énergie pour survivre aux réunions ennuyeuses',
                'image' => null
            ],
            [
                'name' => 'Relaxants',
                'description' => 'Pour se détendre après une journée de code qui ne marche pas',
                'image' => null
            ],
            [
                'name' => 'Stimulants',
                'description' => 'Pour rester éveillé pendant les nuits de debug',
                'image' => null
            ],
            [
                'name' => 'Confort',
                'description' => 'Produits pour améliorer votre confort de développeur',
                'image' => null
            ],
            [
                'name' => 'Accessoires',
                'description' => 'Tout ce qu\'il faut pour un setup de dev parfait',
                'image' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
