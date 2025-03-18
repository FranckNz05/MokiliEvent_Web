<?php

namespace Database\Seeders;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BlogsTableSeeder extends Seeder
{
    public function run()
    {
        $authors = User::role('admin')->get();

        // Liste des images disponibles
        $images = [
            'img/vegetable-item-1.jpg',
            'img/vegetable-item-2.jpg',
            'img/vegetable-item-3.png',
            'img/vegetable-item-4.jpg',
            'img/vegetable-item-5.jpg',
            'img/vegetable-item-6.jpg',
            'img/fruite-item-1.jpg',
            'img/fruite-item-2.jpg',
            'img/fruite-item-3.jpg',
            'img/fruite-item-4.jpg',
            'img/fruite-item-5.jpg',
            'img/fruite-item-6.jpg',
        ];

        $blogs = [
            [
                'title' => 'Les tendances des événements en 2024',
                'content' => 'Découvrez les dernières tendances en matière d\'organisation d\'événements pour l\'année 2024. Des innovations technologiques aux concepts écologiques.',
                'is_featured' => true,
            ],
            [
                'title' => 'Comment organiser un événement virtuel réussi',
                'content' => 'Guide complet pour organiser des événements virtuels engageants et mémorables. Astuces et meilleures pratiques.',
                'is_featured' => true,
            ],
            [
                'title' => 'Les secrets d\'une billetterie efficace',
                'content' => 'Optimisez votre système de billetterie pour maximiser les ventes et améliorer l\'expérience client.',
                'is_featured' => false,
            ],
            [
                'title' => 'Marketing événementiel : les stratégies gagnantes',
                'content' => 'Découvrez les stratégies de marketing les plus efficaces pour promouvoir vos événements et attirer plus de participants.',
                'is_featured' => true,
            ],
            [
                'title' => 'Gérer la sécurité lors des grands événements',
                'content' => 'Les meilleures pratiques pour assurer la sécurité de vos participants lors de grands rassemblements.',
                'is_featured' => false,
            ],
        ];

        foreach ($blogs as $blogData) {
            $blog = new Blog($blogData);
            $blog->slug = Str::slug($blogData['title']);
            $blog->image = $images[array_rand($images)];
            $blog->author()->associate($authors->random());
            $blog->status = 'published';
            $blog->save();
        }
    }
}
