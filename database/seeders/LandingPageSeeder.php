<?php

namespace Database\Seeders;

use App\Models\LandingPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LandingPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LandingPage::create([
            'title' => 'Welcome to Our Website',
            'sub_title' => 'We are a team of talented designers making websites',
            'logo' => null,
            'image_id' => null,
        ]);
    }
}
