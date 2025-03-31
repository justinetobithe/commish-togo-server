<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            ['name' => 'Academic Consultation', 'description' => 'Personalized academic advice and guidance.'],
            ['name' => 'Tutoring', 'description' => 'One-on-one or group tutoring for various subjects.'],
            ['name' => 'Project-based Activity', 'description' => 'Hands-on projects and practical learning experiences.'],
            ['name' => 'Exam Preparation', 'description' => 'Comprehensive test review sessions.'],
            ['name' => 'Essay Writing Assistance', 'description' => 'Help with structuring and improving academic papers.'],
            ['name' => 'Career Counseling', 'description' => 'Guidance on career paths and job applications.'],

            ['name' => 'Freelance Work Assistance', 'description' => 'Guidance on using freelancing platforms like Upwork and Fiverr.'],
            ['name' => 'Graphic Design Services', 'description' => 'Assistance with creating graphics, posters, and branding materials.'],
            ['name' => 'Video Editing Services', 'description' => 'Editing videos for school projects, vlogs, or marketing.'],
            ['name' => 'Web Development Support', 'description' => 'Helping students create and troubleshoot websites.'],
            ['name' => 'Programming Tutoring', 'description' => 'Helping students with coding assignments, debugging, and concepts.'],
        ];

        foreach ($services as $service) {
            Service::updateOrCreate(['name' => $service['name']], $service);
        }
    }
}
