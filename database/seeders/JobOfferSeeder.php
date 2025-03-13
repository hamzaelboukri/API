<?php

namespace Database\Seeders;

use App\Models\job_offer;
use Illuminate\Database\Seeder;
use App\Models\JobOffer;

class JobOfferSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Truncate the job_offers table
        \Illuminate\Support\Facades\DB::table('job_offers')->truncate();

        // Create 50 job offers using the factory
        job_offer::factory()->count(50)->create();
    }
}