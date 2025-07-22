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
                'name' => 'Cannabis',
                'description' => 'Produits dérivés du cannabis pour la relaxation et le bien-être',
                'image' => null
            ],
            [
                'name' => 'Stimulants',
                'description' => 'Substances stimulantes pour l\'énergie et la concentration',
                'image' => null
            ],
            [
                'name' => 'Hallucinogènes',
                'description' => 'Substances psychédéliques pour l\'exploration de la conscience',
                'image' => null
            ],
            [
                'name' => 'Opiacés',
                'description' => 'Produits dérivés de l\'opium pour la gestion de la douleur',
                'image' => null
            ],
            [
                'name' => 'Accessoires',
                'description' => 'Tout le matériel nécessaire pour la consommation',
                'image' => null
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
