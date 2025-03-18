<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            // Paramètres du site
            [
                'group' => 'site',
                'name' => 'name',
                'value' => 'MokiliEvent',
                'type' => 'string'
            ],
            [
                'group' => 'site',
                'name' => 'description',
                'value' => 'Plateforme de gestion d\'événements',
                'type' => 'string'
            ],
            [
                'group' => 'site',
                'name' => 'logo',
                'value' => '/images/logo.png',
                'type' => 'string'
            ],
            [
                'group' => 'site',
                'name' => 'favicon',
                'value' => '/images/favicon.ico',
                'type' => 'string'
            ],
            
            // Paramètres email
            [
                'group' => 'mail',
                'name' => 'from_name',
                'value' => 'MokiliEvent',
                'type' => 'string'
            ],
            [
                'group' => 'mail',
                'name' => 'from_address',
                'value' => 'noreply@mokilievent.com',
                'type' => 'string'
            ],
            
            // Paramètres de commission
            [
                'group' => 'commission',
                'name' => 'percentage',
                'value' => '5',
                'type' => 'float'
            ],
            [
                'group' => 'commission',
                'name' => 'fixed_amount',
                'value' => '0',
                'type' => 'float'
            ],
            
            // Paramètres sociaux
            [
                'group' => 'social',
                'name' => 'facebook',
                'value' => 'https://facebook.com/mokilievent',
                'type' => 'string'
            ],
            [
                'group' => 'social',
                'name' => 'twitter',
                'value' => 'https://twitter.com/mokilievent',
                'type' => 'string'
            ],
            [
                'group' => 'social',
                'name' => 'instagram',
                'value' => 'https://instagram.com/mokilievent',
                'type' => 'string'
            ],
            
            // Paramètres de contact
            [
                'group' => 'contact',
                'name' => 'email',
                'value' => 'contact@mokilievent.com',
                'type' => 'string'
            ],
            [
                'group' => 'contact',
                'name' => 'phone',
                'value' => '+243 000 000 000',
                'type' => 'string'
            ],
            [
                'group' => 'contact',
                'name' => 'address',
                'value' => 'Kinshasa, RDC',
                'type' => 'string'
            ],
            
            // Paramètres de paiement
            [
                'group' => 'payment',
                'name' => 'currency',
                'value' => 'USD',
                'type' => 'string'
            ],
            [
                'group' => 'payment',
                'name' => 'methods',
                'value' => json_encode(['card', 'mobile_money', 'bank_transfer']),
                'type' => 'array'
            ]
        ];

        foreach ($settings as $setting) {
            Setting::create($setting);
        }
    }
}
