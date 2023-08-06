<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingSeeder extends Seeder
{

    protected array $settings = [
        [
            'key' => 'hash_version',
            'value' => '$2y$10$lJnpt62Aoo4sU161Yql06.cWiU0PDl0Ev2k.IxMUKBPSzbgpgych2',
        ],
        [
            'key'   => 'site_name',
            'value' => 'Al Kitab'
        ],
        [
            'key'   => 'logo',
            'value' => ''
        ],
        [
            'key'   => 'favicon',
            'value' => ''
        ],
        [
            'key'   => 'contact_email',
            'value' => 'contact@app.com'
        ],
        [
            'key'   => 'address',
            'value' => ''
        ],
        [
            'key'   => 'phone',
            'value' => ''
        ],
        [
            'key'   => 'fax',
            'value' => ''
        ],
        [
            'key'   =>  'image_size',
            'value' =>  10240,
        ],
        [
            'key' => 'currency_code',
            'value' => 'SAR',
        ],
        [
            'key' => 'site_tax',
            'value' => 5,
        ],
        [
            'key' => 'min_withdrawal_amount',
            'value' => 10,
        ],
        [
            'key' => 'min_order_amount',
            'value' => 150,
        ],
        [
            'key' => 'privacy_policy',
            'value' => '',
        ],
        [
            'key' => 'user_terms_of_use',
            'value' => '',
        ],
        [
            'key' => 'about_us',
            'value' => '',
        ],
        [
            'key' => 'help',
            'value' => '',
        ],

    ];


    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \JsonException
     */
    public function run(): void
    {
        $this->command->info('*************************** Start inserting admin Settings ***********************');

        foreach ($this->settings as $setting) {
            $this->command->info("inserting : ${setting['key']}");
            $sett = Setting::firstOrCreate(
                ['key' => $setting['key']],
                $setting
            );

            $this->command->info($sett->key.' inserted');
        }

        Setting::firstOrCreate([
            'key' => 'lang', 'value' => json_encode([

                'ar' => [
                    'active' => true,
                    'dir' => 'rtl'
                ],

            ], JSON_THROW_ON_ERROR)
        ]);

        $this->command->info('########################## Settings was inserted successfully ##########################');
    }
}
