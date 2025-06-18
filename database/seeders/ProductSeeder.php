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
            // Énergisants (category_id = 1)
            [
                'name' => 'Red Bull de la Rue',
                'description' => 'Énergie pure pour survivre aux réunions de 3h qui auraient pu être un email',
                'price' => 4.99,
                'stock' => 50,
                'category_id' => 1,
                'image' => null
            ],
            [
                'name' => 'Monster du Coin',
                'description' => 'Pour quand tu dois coder jusqu\'à 3h du mat\' et que tu as un meeting à 9h',
                'price' => 3.99,
                'stock' => 30,
                'category_id' => 1,
                'image' => null
            ],
            [
                'name' => 'Café Triple Expresso',
                'description' => 'Le café qui te fait trembler les mains mais au moins tu codes vite',
                'price' => 2.50,
                'stock' => 100,
                'category_id' => 1,
                'image' => null
            ],

            // Relaxants (category_id = 2)
            [
                'name' => 'Thé du Dimanche',
                'description' => 'Pour se détendre après avoir cassé la prod un vendredi soir',
                'price' => 1.99,
                'stock' => 75,
                'category_id' => 2,
                'image' => null
            ],
            [
                'name' => 'Café Décaféiné',
                'description' => 'Pour faire semblant de boire du café sans l\'effet secondaire',
                'price' => 2.99,
                'stock' => 40,
                'category_id' => 2,
                'image' => null
            ],
            [
                'name' => 'Infusion Debug',
                'description' => 'Calme tes nerfs après 6h à chercher pourquoi ça marche pas',
                'price' => 3.50,
                'stock' => 60,
                'category_id' => 2,
                'image' => null
            ],

            // Stimulants (category_id = 3)
            [
                'name' => 'Vitamine C en Cachet',
                'description' => 'Pour booster ton système immunitaire contre les bugs',
                'price' => 8.99,
                'stock' => 25,
                'category_id' => 3,
                'image' => null
            ],
            [
                'name' => 'Complément Alimentaire Dev',
                'description' => 'Toutes les vitamines dont un développeur a besoin',
                'price' => 15.99,
                'stock' => 20,
                'category_id' => 3,
                'image' => null
            ],

            // Confort (category_id = 4)
            [
                'name' => 'Coussin de Bureau',
                'description' => 'Pour ton dos qui souffre de 8h assis devant l\'écran',
                'price' => 29.99,
                'stock' => 15,
                'category_id' => 4,
                'image' => null
            ],
            [
                'name' => 'Lunettes Anti-Fatigue',
                'description' => 'Protège tes yeux des écrans qui te rendent aveugle',
                'price' => 45.99,
                'stock' => 10,
                'category_id' => 4,
                'image' => null
            ],

            // Accessoires (category_id = 5)
            [
                'name' => 'Clavier Mécanique',
                'description' => 'Le clic-clac qui agace tes collègues mais te rend heureux',
                'price' => 89.99,
                'stock' => 8,
                'category_id' => 5,
                'image' => null
            ],
            [
                'name' => 'Souris Gaming',
                'description' => 'Pour naviguer dans ton code comme un pro gamer',
                'price' => 59.99,
                'stock' => 12,
                'category_id' => 5,
                'image' => null
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
