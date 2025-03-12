<?php

namespace Database\Seeders;

namespace Database\Seeders;

use App\Models\job_offer;
use App\Models\JobOffer;
use Illuminate\Database\Seeder;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 20 job offers
        job_offer::factory()->count(20)->create();
    }
}
