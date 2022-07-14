<?php

namespace Ophim\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Category;
use Ophim\Core\Models\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $regions = [
            [
                "name" =>  "Trung Quốc",
                "slug" =>  "trung-quoc",
            ],
            [
                "name" =>  "Hàn Quốc",
                "slug" =>  "han-quoc",
            ],
            [
                "name" =>  "Nhật Bản",
                "slug" =>  "nhat-ban",
            ],
            [
                "name" =>  "Thái Lan",
                "slug" =>  "thai-lan",
            ],
            [
                "name" =>  "Âu Mỹ",
                "slug" =>  "au-my",
            ],
            [
                "name" =>  "Đài Loan",
                "slug" =>  "dai-loan",
            ],
            [
                "name" =>  "Hồng Kông",
                "slug" =>  "hong-kong",
            ],
            [
                "name" =>  "Ấn Độ",
                "slug" =>  "an-do",
            ],
            [
                "name" =>  "Anh",
                "slug" =>  "anh",
            ],
            [
                "name" =>  "Pháp",
                "slug" =>  "phap",
            ],
            [
                "name" =>  "Canada",
                "slug" =>  "canada",
            ],
            [
                "name" =>  "Quốc Gia Khác",
                "slug" =>  "quoc-gia-khac",
            ],
            [
                "name" =>  "Đức",
                "slug" =>  "duc",
            ],
            [
                "name" =>  "Tây Ban Nha",
                "slug" =>  "tay-ban-nha",
            ],
            [
                "name" =>  "Thổ Nhĩ Kỳ",
                "slug" =>  "tho-nhi-ky",
            ],
            [
                "name" =>  "Hà Lan",
                "slug" =>  "ha-lan",
            ],
            [
                "name" =>  "Indonesia",
                "slug" =>  "indonesia",
            ],
            [
                "name" =>  "Nga",
                "slug" =>  "nga",
            ],
            [
                "name" =>  "Mexico",
                "slug" =>  "mexico",
            ],
            [
                "name" =>  "Ba lan",
                "slug" =>  "ba-lan",
            ],
            [
                "name" =>  "Úc",
                "slug" =>  "uc",
            ],
            [
                "name" =>  "Thụy Điển",
                "slug" =>  "thuy-dien",
            ],
            [
                "name" =>  "Malaysia",
                "slug" =>  "malaysia",
            ],
            [
                "name" =>  "Brazil",
                "slug" =>  "brazil",
            ],
            [
                "name" =>  "Philippines",
                "slug" =>  "philippines",
            ],
            [
                "name" =>  "Bồ Đào Nha",
                "slug" =>  "bo-dao-nha",
            ],
            [
                "name" =>  "Ý",
                "slug" =>  "y",
            ],
            [
                "name" =>  "Đan Mạch",
                "slug" =>  "dan-mach",
            ],
            [
                "name" =>  "UAE",
                "slug" =>  "uae",
            ],
            [
                "name" =>  "Na Uy",
                "slug" =>  "na-uy",
            ],
            [
                "name" =>  "Thụy Sĩ",
                "slug" =>  "thuy-si",
            ],
            [
                "name" =>  "Châu Phi",
                "slug" =>  "chau-phi",
            ],
            [
                "name" =>  "Nam Phi",
                "slug" =>  "nam-phi",
            ],
            [
                "name" =>  "Ukraina",
                "slug" =>  "ukraina",
            ],
            [
                "name" =>  "Ả Rập Xê Út",
                "slug" =>  "a-rap-xe-ut",
            ],
        ];

        foreach ($regions as $index => $region) {
            $result = Region::updateOrCreate($region);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($regions) . ' regions.');
    }
}
