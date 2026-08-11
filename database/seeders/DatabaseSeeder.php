<?php

namespace Database\Seeders;

use App\Models\LearningModule;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::factory()->create([
            'name' => 'JomKid Admin',
            'email' => 'admin@jomkid.com',
            'role' => User::ROLE_ADMIN,
        ]);

        User::factory()->create([
            'name' => 'Demo Parent',
            'email' => 'parent@jomkid.com',
            'role' => User::ROLE_PARENT,
        ]);

        User::factory()->create([
            'name' => 'Demo Affiliate',
            'email' => 'affiliate@jomkid.com',
            'role' => User::ROLE_AFFILIATE,
            'affiliate_code' => 'JOMDEMO',
            'affiliate_active' => true,
            'package_code' => 'premium',
            'child_profile_limit' => null,
        ]);

        $reading = LearningModule::create([
            'slug' => 'jomabc-bacaan-bm',
            'title' => 'JomABC Bacaan BM',
            'subject' => 'Bahasa Melayu',
            'description' => 'Bunyi huruf, suku kata dan bacaan awal melalui aktiviti suara dan sentuhan.',
            'status' => 'published',
            'sort_order' => 1,
        ]);

        $reading->lessons()->createMany([
            ['slug' => 'kenal-bunyi-huruf', 'title' => 'Kenal Bunyi Huruf', 'description' => 'Dengar dan pilih bunyi huruf yang betul.', 'is_published' => true, 'sort_order' => 1],
            ['slug' => 'cantum-suku-kata', 'title' => 'Cantum Suku Kata', 'description' => 'Susun suku kata menjadi perkataan.', 'is_published' => true, 'sort_order' => 2],
        ]);

        $counting = LearningModule::create([
            'slug' => 'jommengira-matematik-asas',
            'title' => 'JomMengira',
            'subject' => 'Matematik',
            'description' => 'Nombor, tambah dan tolak melalui permainan visual ringkas.',
            'status' => 'draft',
            'sort_order' => 2,
        ]);

        $counting->lessons()->create([
            'slug' => 'kira-1-hingga-10',
            'title' => 'Kira 1 hingga 10',
            'description' => 'Kira objek dan pilih jawapan yang tepat.',
            'is_published' => true,
            'sort_order' => 1,
        ]);

        LearningModule::create([
            'slug' => 'jommengaji-asas-iqra',
            'title' => 'JomMengaji',
            'subject' => 'Pendidikan Islam',
            'description' => 'Pengenalan huruf hijaiyah dan bacaan asas secara interaktif.',
            'status' => 'draft',
            'sort_order' => 3,
        ]);
    }
}
