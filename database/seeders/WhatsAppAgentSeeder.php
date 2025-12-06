<?php

namespace Database\Seeders;

use App\Models\WhatsAppAgent;
use Illuminate\Database\Seeder;

class WhatsAppAgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $agents = [
            [
                'name' => 'Customer Support',
                'phone_number' => '+628123456789',
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Sales Team',
                'phone_number' => '+628987654321',
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'Technical Support',
                'phone_number' => '+628555666777',
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($agents as $agent) {
            WhatsAppAgent::create($agent);
        }
    }
}
