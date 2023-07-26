<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::truncate();
        Setting::insert([
            [
                'name' => 'company_start_time',
                'value' => '{"start_time":"09:00","duration":"8"}'
            ],
            [
                'name' => 'timezone',
                'value' => 'Asia/Dhaka'
            ],
            [
                'name' => 'ip_restrict',
                'value' => "off"
            ],
            [
                'name' => 'company_logo',
                'value' => "storage/logo/logo.png"
            ],
            [
                'name' => 'company_favicon',
                'value' => "storage/logo/favicon.png"
            ],
            [
                'name' => 'company_title',
                'value' => "HRMplus"
            ],
            [
                'name' => 'website_title',
                'value' => "HRMplus"
            ],
            [
                'name' => 'footer_text',
                'value' => "HRMplus"
            ],
            [
                'name' => 'weekends',
                'value' => '["saturday","sunday"]'
            ],
            [
                'name' => 'screenshot_duration',
                'value' => 10
            ]
        ]);
    }
}
