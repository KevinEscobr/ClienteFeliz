<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Application;
use App\Models\StatusHistory;

class ApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $application = Application::create([
            'user_id' => 2,
            'offer_id' => 1,
            'status' => 'applied'
        ]);

        StatusHistory::create([
            'application_id' => $application->id,
            'status' => 'applied',
            'comment' => 'Initial application',
            'changed_by' => 2
        ]);
    }
}
