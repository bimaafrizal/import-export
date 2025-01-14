<?php

namespace Database\Seeders;

use App\Models\Contact;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contacts = [
            [
                "title"=> "Alamat",
                "value" => "A108 Adam Street, New York, NY 535022",
                "type" => "alamat",
                "landing_page_id" => 1,
                "icon" => "bi bi-geo-alt",
            ],
            [
                "title"=> "Telepon",
                "value" => "+1 5589 55488 55",
                "type" => "telepon",
                "landing_page_id" => 1,
                "icon" => "bi bi-telephone",
            ],
            [
                "title"=> "Map",
                "value" => "map",
                "type" => "map",
                "landing_page_id" => 1,
                "icon" => "bx bx-envelope",
                "link" => "https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d48389.78314118045!2d-74.006138!3d40.710059!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c25a22a3bda30d%3A0xb89d1fe6bc499443!2sDowntown%20Conference%20Center!5e0!3m2!1sen!2sus!4v1676961268712!5m2!1sen!2sus"
            ],
            [
                "title"=> "Email",
                "value" => "info@example.com",
                "type" => "email",
                "landing_page_id" => 1,
                "icon" => "bi bi-envelope",
            ]
        ];

        foreach ($contacts as $contact) {
            Contact::create($contact);
        }
    }
}
