<?php

namespace Ophim\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Catalog;

class CatalogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds_
     *
     * @return void
     */
    public function run()
    {
        $catalogs = [
            [
                'name'          => 'Phim mới',
                'slug'          => 'phim-moi',
                'paginate'      => 20,
                'value'         => '|is_copyright|0|updated_at|desc',
                'seo_title'     => 'Title Phim mới',
                'seo_des'       => 'Des Phim mới',
                'seo_key'       => 'Key Phim mới',
            ],
            [
                'name'          => 'Phim bộ',
                'slug'          => 'phim-bo',
                'paginate'      => 20,
                'value'         => '|type|series|updated_at|desc',
                'seo_title'     => 'Title Phim bộ',
                'seo_des'       => 'Des Phim bộ',
                'seo_key'       => 'Key Phim bộ',
            ],
            [
                'name'          => 'Phim lẻ',
                'slug'          => 'phim-le',
                'paginate'      => 20,
                'value'         => '|type|single|updated_at|desc',
                'seo_title'     => 'Title Phim lẻ',
                'seo_des'       => 'Des Phim lẻ',
                'seo_key'       => 'Key Phim lẻ',
            ]
        ];

        foreach ($catalogs as $index => $catalog) {
            $result = Catalog::firstOrCreate(collect($catalog)->only('slug')->toArray(), collect($catalog)->except('slug')->toArray());

            if (!$result) {
                $this->command->info("Insert failed at record $index");

                return;
            }
        }

    }
}
