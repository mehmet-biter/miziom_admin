<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdminSetting;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AdminSetting::firstOrCreate(['slug'=>'app_title'],['value'=>'App Title']);
        AdminSetting::firstOrCreate(['slug'=>'tag_title'],['value'=>'Tag title']);
        AdminSetting::firstOrCreate(['slug'=>'company_email'],['value'=>'tech@gmail.com']);
        AdminSetting::firstOrCreate(['slug'=>'company_address'],['value'=>'Bissingzeile 43, Anderlingen, Niedersachsen, Germany']);
        AdminSetting::firstOrCreate(['slug'=>'helpline'],['value'=>'04764 67 12 86']);

        AdminSetting::firstOrCreate(['slug' => 'logo'],['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'login_logo'],['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'landing_logo'],['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'favicon'], ['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'copyright_text'], ['value' => 'Copyright@2023']);
        AdminSetting::firstOrCreate(['slug' => 'pagination_count'], ['value' => '10']);

        //General Settings
        AdminSetting::firstOrCreate(['slug' => 'currency'],[ 'value' => 'USD']);
        AdminSetting::firstOrCreate(['slug' => 'lang'], ['value' => 'en']);

        AdminSetting::firstOrCreate(['slug' => 'mail_driver'], ['value' => 'SMTP']);
        AdminSetting::firstOrCreate(['slug' => 'mail_host'], ['value' => 'smtp.mailtrap.io']);
        AdminSetting::firstOrCreate(['slug' => 'mail_port'], ['value' => 2525]);
        AdminSetting::firstOrCreate(['slug' => 'mail_username'], ['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'mail_password'], ['value' => '']);
        AdminSetting::firstOrCreate(['slug' => 'mail_encryption'], ['value' => 'null']);
        AdminSetting::firstOrCreate(['slug' => 'mail_from_address'], ['value' => '']);

        AdminSetting::firstOrCreate(['slug' => 'default_coin'], ['value' => 'USDC']);
        AdminSetting::firstOrCreate(['slug' => 'default_currency'], ['value' => 'NGN']);
        
    }
}
