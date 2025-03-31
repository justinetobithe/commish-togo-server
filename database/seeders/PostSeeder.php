<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Sample post data
        $posts = [
            [
                'uuid' => Str::uuid(),
                'user_id' => 7,
                'title' => 'Freelance Graphic Designer Needed',
                'content' => '<p>We are looking for a freelance graphic designer to help with various projects.</p>',
                'location' => 'Remote',
                'salary' => '500',
                'type' => 'freelance',
                'posted_date' => Carbon::now(),
                'application_deadline' => Carbon::now()->addDays(7),
                'is_hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 7,
                'title' => 'Academic Tutoring for High School Students',
                'content' => '<p>Looking for a tutor to help with mathematics and science subjects.</p>',
                'location' => 'New York',
                'salary' => '300',
                'type' => 'contract',
                'posted_date' => Carbon::now(),
                'application_deadline' => Carbon::now()->addDays(5),
                'is_hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 7,
                'title' => 'Project-Based Activity for Students',
                'content' => '<p>Looking for someone to manage a project-based learning experience.</p>',
                'location' => 'California',
                'salary' => '700',
                'type' => 'freelance',
                'posted_date' => Carbon::now(),
                'application_deadline' => Carbon::now()->addDays(10),
                'is_hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 7,
                'title' => 'Essay Writing Assistance for College Students',
                'content' => '<p>Assistance needed in writing essays for college students.</p>',
                'location' => 'Online',
                'salary' => '250',
                'type' => 'freelance',
                'posted_date' => Carbon::now(),
                'application_deadline' => Carbon::now()->addDays(3),
                'is_hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'uuid' => Str::uuid(),
                'user_id' => 7,
                'title' => 'Career Counseling for Graduates',
                'content' => '<p>We are offering career counseling services for recent graduates.</p>',
                'location' => 'Chicago',
                'salary' => '400',
                'type' => 'contract',
                'posted_date' => Carbon::now(),
                'application_deadline' => Carbon::now()->addDays(15),
                'is_hidden' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ];

        DB::table('posts')->insert($posts);

        $tags = [
            ['post_id' => 1, 'service_id' => 7],
            ['post_id' => 1, 'service_id' => 8],
            ['post_id' => 2, 'service_id' => 2],
            ['post_id' => 3, 'service_id' => 3],
            ['post_id' => 4, 'service_id' => 5],
            ['post_id' => 5, 'service_id' => 6],
        ];

        DB::table('post_tags')->insert($tags);
    }
}
