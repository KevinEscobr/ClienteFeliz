<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Offer;

class OfferSeeder extends Seeder
{
    public function run(): void
    {
        Offer::create([
            'title' => 'Call Center Agent',
            'description' => 'Customer support role',
            'status' => 'active',
            'created_by' => 1
        ]);

        Offer::create([
            'title' => 'Backend Developer',
            'description' => 'Laravel developer position',
            'status' => 'active',
            'created_by' => 1
        ]);
    }
}
