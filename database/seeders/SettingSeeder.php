<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\dashboard\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ####### لحل مشكلة لو فية علاقات بين الجداول
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Setting::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        // Create a default setting for the restaurant with ID 0
        $setting = new Setting();
        $setting->create([
            'resturant_id' => null,
            'name' => 'Menu Smart',
            'email' => 'mr319242@gmil.com',
            'phone' => '+201011642731',
            'address' => ' العراق - بغداد ',
            'logo' => 'default-logo.png',
            'banner' => 'default-banner.png',
            'description' => 'Default Description',
            'facebook' => 'https://facebook.com',
            'twitter' => 'https://twitter.com',
            'instagram' => 'https://instagram.com',
            'youtube' => 'https://youtube.com',
            'whatsapp' => 'https://wa.me/01000000000',
            'snapchat' => 'https://snapchat.com',
            'tiktok' => 'https://tiktok.com/',
            'main_color' => '#000000',
            'secondary_color' => '#FFFFFF',
        ]);
    }
}
