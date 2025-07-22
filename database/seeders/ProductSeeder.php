<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            // Cannabis (category_id = 16)
            [
                'name' => 'Herbe de Qualité',
                'description' => 'Cannabis premium pour une expérience relaxante optimale',
                'price' => 15.99,
                'stock' => 50,
                'category_id' => 16,
                'image' => null
            ],
            [
                'name' => 'Hash Marocain',
                'description' => 'Hashish traditionnel du Maroc, goût authentique',
                'price' => 12.99,
                'stock' => 30,
                'category_id' => 16,
                'image' => null
            ],
            [
                'name' => 'Huile de CBD',
                'description' => 'Huile de CBD pure pour le bien-être sans effet psychoactif',
                'price' => 25.50,
                'stock' => 100,
                'category_id' => 16,
                'image' => null
            ],
            [
                'name' => 'Space Cake',
                'description' => 'Gâteau au cannabis fait maison, effet progressif',
                'price' => 8.99,
                'stock' => 20,
                'category_id' => 16,
                'image' => null
            ],

            // Stimulants (category_id = 17)
            [
                'name' => 'Cocaïne Pure',
                'description' => 'Cocaïne de qualité premium pour l\'énergie et la concentration',
                'price' => 80.00,
                'stock' => 25,
                'category_id' => 17,
                'image' => null
            ],
            [
                'name' => 'Crack Premium',
                'description' => 'Crack de haute qualité pour un effet immédiat',
                'price' => 45.00,
                'stock' => 15,
                'category_id' => 17,
                'image' => null
            ],
            [
                'name' => 'Méthamphétamine',
                'description' => 'Crystal meth pour une énergie extrême et durable',
                'price' => 120.00,
                'stock' => 10,
                'category_id' => 17,
                'image' => null
            ],
            [
                'name' => 'Ecstasy MDMA',
                'description' => 'Pilules d\'ecstasy pour l\'euphorie et l\'empathie',
                'price' => 15.00,
                'stock' => 40,
                'category_id' => 17,
                'image' => null
            ],

            // Hallucinogènes (category_id = 18)
            [
                'name' => 'LSD Blotters',
                'description' => 'Acide lysergique diéthylamide sur papier, voyages psychédéliques',
                'price' => 10.00,
                'stock' => 60,
                'category_id' => 18,
                'image' => null
            ],
            [
                'name' => 'Champignons Magiques',
                'description' => 'Psilocybine naturelle pour l\'exploration de la conscience',
                'price' => 20.00,
                'stock' => 35,
                'category_id' => 18,
                'image' => null
            ],
            [
                'name' => 'DMT Cristal',
                'description' => 'Diméthyltryptamine pure pour des voyages brefs mais intenses',
                'price' => 50.00,
                'stock' => 20,
                'category_id' => 18,
                'image' => null
            ],
            [
                'name' => 'Kétamine',
                'description' => 'Dissociatif pour l\'exploration des états de conscience',
                'price' => 35.00,
                'stock' => 30,
                'category_id' => 18,
                'image' => null
            ],

            // Opiacés (category_id = 19)
            [
                'name' => 'Héroïne Blanche',
                'description' => 'Héroïne pure pour la gestion de la douleur et la relaxation',
                'price' => 100.00,
                'stock' => 15,
                'category_id' => 19,
                'image' => null
            ],
            [
                'name' => 'Morphine',
                'description' => 'Morphine pharmaceutique pour le soulagement de la douleur',
                'price' => 75.00,
                'stock' => 25,
                'category_id' => 19,
                'image' => null
            ],
            [
                'name' => 'Oxycodone',
                'description' => 'Analgésique opioïde pour la douleur chronique',
                'price' => 60.00,
                'stock' => 20,
                'category_id' => 19,
                'image' => null
            ],
            [
                'name' => 'Fentanyl',
                'description' => 'Opioïde synthétique très puissant, usage médical',
                'price' => 150.00,
                'stock' => 8,
                'category_id' => 19,
                'image' => null
            ],

            // Accessoires (category_id = 20)
            [
                'name' => 'Bong en Verre',
                'description' => 'Bong de qualité pour une consommation optimale',
                'price' => 45.99,
                'stock' => 12,
                'category_id' => 20,
                'image' => null
            ],
            [
                'name' => 'Pipe à Crack',
                'description' => 'Pipe spécialisée pour la consommation de crack',
                'price' => 15.00,
                'stock' => 25,
                'category_id' => 20,
                'image' => null
            ],
            [
                'name' => 'Seringues Stériles',
                'description' => 'Seringues à usage unique pour injection sécurisée',
                'price' => 5.00,
                'stock' => 100,
                'category_id' => 20,
                'image' => null
            ],
            [
                'name' => 'Balance de Précision',
                'description' => 'Balance digitale pour peser vos substances avec précision',
                'price' => 25.00,
                'stock' => 15,
                'category_id' => 20,
                'image' => null
            ],
            [
                'name' => 'Test Kit',
                'description' => 'Kit de test pour vérifier la pureté de vos substances',
                'price' => 30.00,
                'stock' => 20,
                'category_id' => 20,
                'image' => null
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
