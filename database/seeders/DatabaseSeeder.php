<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        $statuses = ['pending', 'rejected', 'enable', 'disable', 'booked', 'available', 'blocked', 'activated', 'deactivated'];
        foreach ($statuses as $status) {
            \App\Models\Status::create([
                'title' => $status,
            ]);
        }

        $types = ['Item', 'Experience'];
        foreach ($types as $type) {
            \App\Models\Type::create([
                'title' => $type,
            ]);
        }

        $start_times = ['00:00:00', '01:00:00', '02:00:00', '03:00:00', '04:00:00', '05:00:00', '06:00:00', '07:00:00', '08:00:00', '09:00:00', '10:00:00', '11:00:00', '12:00:00', '13:00:00', '14:00:00', '15:00:00', '16:00:00', '17:00:00', '18:00:00', '19:00:00', '20:00:00', '21:00:00', '22:00:00', '23:00:00', '24:00:00'];
        $end_times   = ['00:59:59', '01:59:59', '02:59:59', '03:59:59', '04:59:59', '05:59:59', '06:59:59', '07:59:59', '08:59:59', '09:59:59', '10:59:59', '11:59:59', '12:59:59', '13:59:59', '14:59:59', '15:59:59', '16:59:59', '17:59:59', '18:59:59', '19:59:59', '20:59:59', '21:59:59', '22:59:59', '23:59:59', '24:59:59'];

        foreach ($start_times as $key => $st) {
            \App\Models\Time::create([
                'start_time' => $st,
                'end_time' => $end_times[$key],
            ]);
        }

        $days = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
        foreach ($days as $day) {
            \App\Models\Day::create([
                'title' => $day,
            ]);
        }

        \App\Models\Country::create([
            'name' => 'England',
            'country_code' => 'En',
        ]);

        \App\Models\ServiceFee::create([
            's_fee' => 1.0
        ]);

        \App\Models\State::create([
            'country_id' => '1',
            'title' => 'London',
        ]);

        \App\Models\Role::create([
            'name' => 'admin',
            'display_name' => 'Admin',
            'description' => 'this role is for Admin',
        ]);
        \App\Models\Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'this role is for app user',
        ]);
        $user =  \App\Models\User::create([
            'status_id' => 3,
            'country_id' => 1,
            'username' => 'admin',
            'full_name' => 'admin admin',
            'first_name' => 'admin',
            'last_name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '+413484225257',
            'bio' => 'admin',
            'email_verification' => 1,
            'phone_verification' => 1,
            'password' => Hash::make('12345678'),
        ]);
        $address =  \App\Models\Address::create([
            'user_id' => 1,
            'state_id' => 1,
            'address_name' => 'Home address',
            'first_name' => 'Bilal',
            'last_name' => 'khan',
            'email' => 'admin@admin.com',
            'phone' => '+413484225257',
            'address1' => 'office no 2 akhtar mall rawalpindi',
            'city' => 'rawalpindi',
            'zipcode' => '44000',
            'is_primary' => 1,
        ]);

        $days = ["Textbox", "Radio Button", "Select Option", "Checkbox", "Textarea", "Number"];
        foreach ($days as $day) {
            \App\Models\AttributeType::create([
                'title' => $day,
            ]);
        }

        $user->attachRole(1);

        $time_zones = [
            0 => [
                "title"=>"Pacific/Midway",
                "description"=>"(GMT-11:00) Midway Island"
            ],
            1 => [
                "title"=>"US/Samoa",
                "description"=>"(GMT-11:00) Samoa"
            ],
            2 => [
                "title"=>"US/Hawaii",
                "description"=>"(GMT-10:00) Hawaii"
            ],
            3 => [
                  "title"=>"US/Alaska",
                  "description"=>"(GMT-09:00) Alaska"
            ],
            4 => [
                  "title"=>"US/Pacific",
                  "description"=>"(GMT-08:00) Pacific Time (US &amp; Canada)"
            ],
            5 => [
                  "title"=>"America/Tijuana",
                  "description"=>"(GMT-08:00) Tijuana"
            ],
            6 => [
                  "title"=>"US/Arizona",
                  "description"=>"(GMT-07:00) Arizona"
            ],
            7 => [
                  "title"=>"US/Mountain",
                  "description"=>"(GMT-07:00) Mountain Time (US &amp; Canada)"
            ],
            8 => [
                  "title"=>"America/Chihuahua",
                  "description"=>"(GMT-07:00) Chihuahua"
            ],
            9 => [
                  "title"=>"America/Mazatlan",
                  "description"=>"(GMT-07:00) Mazatlan"
            ],
            10 => [
                  "title"=>"America/Mexico_City",
                  "description"=>"(GMT-06:00) Mexico City"
            ],
            11 => [
                  "title"=>"America/Monterrey",
                  "description"=>"(GMT-06:00) Monterrey"
            ],
            12 => [
                  "title"=>"Canada/Saskatchewan",
                  "description"=>"(GMT-06:00) Saskatchewan"
            ],
            13 => [
                  "title"=>"US/Central",
                  "description"=>"(GMT-06:00) Central Time (US &amp; Canada)"
            ],
            14 => [
                  "title"=>"US/Eastern",
                  "description"=>"(GMT-05:00) Eastern Time (US &amp; Canada)"
            ],
            15 => [
                  "title"=>"US/East-Indiana",
                  "description"=>"(GMT-05:00) Indiana (East)"
            ],
            16 => [
                  "title"=>"America/Bogota",
                  "description"=>"(GMT-05:00) Bogota"
            ],
            17 => [
                  "title"=>"America/Lima",
                  "description"=>"(GMT-05:00) Lima"
            ],
            18 => [
                  "title"=>"America/Caracas",
                  "description"=>"(GMT-04:30) Caracas"
            ],
            19 => [
                  "title"=>"Canada/Atlantic",
                  "description"=>"(GMT-04:00) Atlantic Time (Canada)"
            ],
            20 => [
                  "title"=>"America/La_Paz",
                  "description"=>"(GMT-04:00) La Paz"
            ],
            21 => [
                  "title"=>"America/Santiago",
                  "description"=>"(GMT-04:00) Santiago"
            ],
            22 => [
                  "title"=>"Canada/Newfoundland",
                  "description"=>"(GMT-03:30) Newfoundland"
            ],
            23 => [
                  "title"=>"America/Buenos_Aires",
                  "description"=>"(GMT-03:00) Buenos Aires"
            ],
            24 => [
                  "title"=>"Greenland",
                  "description"=>"(GMT-03:00) Greenland"
            ],
            25 => [
                  "title"=>"Atlantic/Stanley",
                  "description"=>"(GMT-02:00) Stanley"
            ],
            26 => [
                  "title"=>"Atlantic/Azores",
                  "description"=>"(GMT-01:00) Azores"
            ],
            27 => [
                  "title"=>"Atlantic/Cape_Verde",
                  "description"=>"(GMT-01:00) Cape Verde Is."
            ],
            28 => [
                  "title"=>"Africa/Casablanca",
                  "description"=>"(GMT) Casablanca"
            ],
            29 => [
                  "title"=>"Europe/Dublin",
                  "description"=>"(GMT) Dublin"
            ],
            30 => [
                  "title"=>"Europe/Lisbon",
                  "description"=>"(GMT) Lisbon"
            ],
            31 => [
                  "title"=>"Europe/London",
                  "description"=>"(GMT) London"
            ],
            32 => [
                  "title"=>"Africa/Monrovia",
                  "description"=>"(GMT) Monrovia"
            ],
            33 => [
                  "title"=>"Europe/Amsterdam",
                  "description"=>"(GMT+01:00) Amsterdam"
            ],
            34 => [
                  "title"=>"Europe/Belgrade",
                  "description"=>"(GMT+01:00) Belgrade"
            ],
            35 => [
                  "title"=>"Europe/Berlin",
                  "description"=>"(GMT+01:00) Berlin"
            ],
            36 => [
                  "title"=>"Europe/Bratislava",
                  "description"=>"(GMT+01:00) Bratislava"
            ],
            37 => [
                  "title"=>"Europe/Brussels",
                  "description"=>"(GMT+01:00) Brussels"
            ],
            38 => [
                  "title"=>"Europe/Budapest",
                  "description"=>"(GMT+01:00) Budapest"
            ],
            39 => [
                  "title"=>"Europe/Copenhagen",
                  "description"=>"(GMT+01:00) Copenhagen"
            ],
            40 => [
                  "title"=>"Europe/Ljubljana",
                  "description"=>"(GMT+01:00) Ljubljana"
            ],
            41 => [
                  "title"=>"Europe/Madrid",
                  "description"=>"(GMT+01:00) Madrid"
            ],
            42 => [
                  "title"=>"Europe/Paris",
                  "description"=>"(GMT+01:00) Paris"
            ],
            43 => [
                  "title"=>"Europe/Prague",
                  "description"=>"(GMT+01:00) Prague"
            ],
            44 => [
                  "title"=>"Europe/Rome",
                  "description"=>"(GMT+01:00) Rome"
            ],
            45 => [
                  "title"=>"Europe/Sarajevo",
                  "description"=>"(GMT+01:00) Sarajevo"
            ],
            46 => [
                  "title"=>"Europe/Skopje",
                  "description"=>"(GMT+01:00) Skopje"
            ],
            47 => [
                  "title"=>"Europe/Stockholm",
                  "description"=>"(GMT+01:00) Stockholm"
            ],
            48 => [
                  "title"=>"Europe/Vienna",
                  "description"=>"(GMT+01:00) Vienna"
            ],
            49 => [
                  "title"=>"Europe/Warsaw",
                  "description"=>"(GMT+01:00) Warsaw"
            ],
            50 => [
                  "title"=>"Europe/Zagreb",
                  "description"=>"(GMT+01:00) Zagreb"
            ],
            51 => [
                  "title"=>"Europe/Athens",
                  "description"=>"(GMT+02:00) Athens"
            ],
            52 => [
                  "title"=>"Europe/Bucharest",
                  "description"=>"(GMT+02:00) Bucharest"
            ],
            53 => [
                  "title"=>"Africa/Cairo",
                  "description"=>"(GMT+02:00) Cairo"
            ],
            54 => [
                  "title"=>"Africa/Harare",
                  "description"=>"(GMT+02:00) Harare"
            ],
            55 => [
                  "title"=>"Europe/Helsinki",
                  "description"=>"(GMT+02:00) Helsinki"
            ],
            56 => [
                  "title"=>"Europe/Istanbul",
                  "description"=>"(GMT+02:00) Istanbul"
            ],
            57 => [
                  "title"=>"Asia/Jerusalem",
                  "description"=>"(GMT+02:00) Jerusalem"
            ],
            58 => [
                  "title"=>"Europe/Kiev",
                  "description"=>"(GMT+02:00) Kyiv"
            ],
            59 => [
                  "title"=>"Europe/Minsk",
                  "description"=>"(GMT+02:00) Minsk"
            ],
            60 => [
                  "title"=>"Europe/Riga",
                  "description"=>"(GMT+02:00) Riga"
            ],
            61 => [
                  "title"=>"Europe/Sofia",
                  "description"=>"(GMT+02:00) Sofia"
            ],
            62 => [
                  "title"=>"Europe/Tallinn",
                  "description"=>"(GMT+02:00) Tallinn"
            ],
            63 => [
                  "title"=>"Europe/Vilnius",
                  "description"=>"(GMT+02:00) Vilnius"
            ],
            64 => [
                  "title"=>"Asia/Baghdad",
                  "description"=>"(GMT+03:00) Baghdad"
            ],
            65 => [
                  "title"=>"Asia/Kuwait",
                  "description"=>"(GMT+03:00) Kuwait"
            ],
            66 => [
                  "title"=>"Africa/Nairobi",
                  "description"=>"(GMT+03:00) Nairobi"
            ],
            67 => [
                  "title"=>"Asia/Riyadh",
                  "description"=>"(GMT+03:00) Riyadh"
            ],
            68 => [
                  "title"=>"Europe/Moscow",
                  "description"=>"(GMT+03:00) Moscow"
            ],
            69 => [
                  "title"=>"Asia/Tehran",
                  "description"=>"(GMT+03:30) Tehran"
            ],
            70 => [
                  "title"=>"Asia/Baku",
                  "description"=>"(GMT+04:00) Baku"
            ],
            71 => [
                  "title"=>"Europe/Volgograd",
                  "description"=>"(GMT+04:00) Volgograd"
            ],
            72 => [
                  "title"=>"Asia/Muscat",
                  "description"=>"(GMT+04:00) Muscat"
            ],
            73 => [
                  "title"=>"Asia/Tbilisi",
                  "description"=>"(GMT+04:00) Tbilisi"
            ],
            74 => [
                  "title"=>"Asia/Yerevan",
                  "description"=>"(GMT+04:00) Yerevan"
            ],
            75 => [
                  "title"=>"Asia/Kabul",
                  "description"=>"(GMT+04:30) Kabul"
            ],
            76 => [
                  "title"=>"Asia/Karachi",
                  "description"=>"(GMT+05:00) Karachi"
            ],
            77 => [
                  "title"=>"Asia/Tashkent",
                  "description"=>"(GMT+05:00) Tashkent"
            ],
            78 => [
                  "title"=>"Asia/Kolkata",
                  "description"=>"(GMT+05:30) Kolkata"
            ],
            79 => [
                  "title"=>"Asia/Kathmandu",
                  "description"=>"(GMT+05:45) Kathmandu"
            ],
            80 => [
                  "title"=>"Asia/Yekaterinburg",
                  "description"=>"(GMT+06:00) Ekaterinburg"
            ],
            81 => [
                  "title"=>"Asia/Almaty",
                  "description"=>"(GMT+06:00) Almaty"
            ],
            82 => [
                  "title"=>"Asia/Dhaka",
                  "description"=>"(GMT+06:00) Dhaka"
            ],
            83 => [
                  "title"=>"Asia/Novosibirsk",
                  "description"=>"(GMT+07:00) Novosibirsk"
            ],
            84 => [
                  "title"=>"Asia/Bangkok",
                  "description"=>"(GMT+07:00) Bangkok"
            ],
            85 => [
                  "title"=>"Asia/Jakarta",
                  "description"=>"(GMT+07:00) Jakarta"
            ],
            86 => [
                  "title"=>"Asia/Krasnoyarsk",
                  "description"=>"(GMT+08:00) Krasnoyarsk"
            ],
            87 => [
                  "title"=>"Asia/Chongqing",
                  "description"=>"(GMT+08:00) Chongqing"
            ],
            88 => [
                  "title"=>"Asia/Hong_Kong",
                  "description"=>"(GMT+08:00) Hong Kong"
            ],
            89 => [
                  "title"=>"Asia/Kuala_Lumpur",
                  "description"=>"(GMT+08:00) Kuala Lumpur"
            ],
            90 => [
                  "title"=>"Australia/Perth",
                  "description"=>"(GMT+08:00) Perth"
            ],
            100 => [
                  "title"=>"Asia/Singapore",
                  "description"=>"(GMT+08:00) Singapore"
            ],
            101 => [
                  "title"=>"Asia/Taipei",
                  "description"=>"(GMT+08:00) Taipei"
            ],
            102 => [
                  "title"=>"Asia/Ulaanbaatar",
                  "description"=>"(GMT+08:00) Ulaan Bataar"
            ],
            103 => [
                  "title"=>"Asia/Urumqi",
                  "description"=>"(GMT+08:00) Urumqi"
            ],
            104 => [
                  "title"=>"Asia/Irkutsk",
                  "description"=>"(GMT+09:00) Irkutsk"
            ],
            105 => [
                  "title"=>"Asia/Seoul",
                  "description"=>"(GMT+09:00) Seoul"
            ],
            106 => [
                  "title"=>"Asia/Tokyo",
                  "description"=>"(GMT+09:00) Tokyo"
            ],
            107 => [
                  "title"=>"Australia/Adelaide",
                  "description"=>"(GMT+09:1000) Adelaide"
            ],
            108 => [
                  "title"=>"Australia/Darwin",
                  "description"=>"(GMT+09:1000) Darwin"
            ],
            109 => [
                  "title"=>"Asia/Yakutsk",
                  "description"=>"(GMT+10:00) Yakutsk"
            ],
            110 => [
                  "title"=>"Australia/Brisbane",
                  "description"=>"(GMT+10:00) Brisbane"
            ],
            111 => [
                  "title"=>"Australia/Canberra",
                  "description"=>"(GMT+10:00) Canberra"
            ],
            112 => [
                  "title"=>"Pacific/Guam",
                  "description"=>"(GMT+10:00) Guam"
            ],
            113 => [
                  "title"=>"Australia/Hobart",
                  "description"=>"(GMT+10:00) Hobart"
            ],
            114 => [
                  "title"=>"Australia/Melbourne",
                  "description"=>"(GMT+10:00) Melbourne"
            ],
            115 => [
                  "title"=>"Pacific/Port_Moresby",
                  "description"=>"(GMT+10:00) Port Moresby"
            ],
            116 => [
                  "title"=>"Australia/Sydney",
                  "description"=>"(GMT+10:00) Sydney"
            ],
            117 => [
                  "title"=>"Asia/Vladivostok",
                  "description"=>"(GMT+11:00) Vladivostok"
            ],
            118 => [
                  "title"=>"Asia/Magadan",
                  "description"=>"(GMT+12:00) Magadan"
            ],
            119 => [
                  "title"=>"Pacific/Auckland",
                  "description"=>"(GMT+12:00) Auckland"
            ],
            120 => [
                  "title"=>"Pacific/Fiji",
                  "description"=>"(GMT+12:00) Fiji"
            ]
        ];
        foreach($time_zones as $time_zone){
            \App\Models\Timezone::create([
                "title"=>$time_zone['title'],
                "description"=>$time_zone['description']
            ]);
        }
        \App\Models\Setting::create([
            'site_title' => "Rent and Offer",
            'site_logo_large' => "logo",
            'site_logo_small' => "logo",
            'copy_right_text' => "© 2022 All Rights Reserved",
            'site_email' => "info@rentandoffer.com",
            'address' => "i-8 markaz",
            'facebook_url' => "www.facebook.com",
            'twitter_url' => "www.twitter.com",
            'linkedin_url' => "www.linkedin.com",
            'instagram_url' => "www.instagram.com",
            'timezone_id' => "1",
            'contact_us_email' => "support@rentandoffer.com",
            'order_payment_process_days' => "3",
            'distance' => "100",
        ]);
    }
}
