<?php

namespace Ophim\Core\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ophim\Core\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                "name" => "Hành Động",
                "slug" => "hanh-dong",
            ],
            [
                "name" => "Tình Cảm",
                "slug" => "tinh-cam",
            ],
            [
                "name" => "Hài Hước",
                "slug" => "hai-huoc",
            ],
            [
                "name" => "Cổ Trang",
                "slug" => "co-trang",
            ],
            [
                "name" => "Tâm Lý",
                "slug" => "tam-ly",
            ],
            [
                "name" => "Hình Sự",
                "slug" => "hinh-su",
            ],
            [
                "name" => "Chiến Tranh",
                "slug" => "chien-tranh",
            ],
            [
                "name" => "Thể Thao",
                "slug" => "the-thao",
            ],
            [
                "name" => "Võ Thuật",
                "slug" => "vo-thuat",
            ],
            [
                "name" => "Viễn Tưởng",
                "slug" => "vien-tuong",
            ],
            [
                "name" => "Phiêu Lưu",
                "slug" => "phieu-luu",
            ],
            [
                "name" => "Khoa Học",
                "slug" => "khoa-hoc",
            ],
            [
                "name" => "Kinh Dị",
                "slug" => "kinh-di",
            ],
            [
                "name" => "Âm Nhạc",
                "slug" => "am-nhac",
            ],
            [
                "name" => "Thần Thoại",
                "slug" => "than-thoai",
            ],
            [
                "name" => "Tài Liệu",
                "slug" => "tai-lieu",
            ],
            [
                "name" => "Gia Đình",
                "slug" => "gia-dinh",
            ],
            [
                "name" => "Chính kịch",
                "slug" => "chinh-kich",
            ],
            [
                "name" => "Bí ẩn",
                "slug" => "bi-an",
            ],
            [
                "name" => "Học Đường",
                "slug" => "hoc-duong",
            ],
            [
                "name" => "Kinh Điển",
                "slug" => "kinh-dien",
            ],
            [
                "name" => "Phim 18+",
                "slug" => "phim-18",
            ],
        ];

        foreach ($categories as $index => $category) {
            $result = Category::updateOrCreate($category);

            if (!$result) {
                $this->command->info("Insert failed at record $index.");

                return;
            }
        }

        $this->command->info('Inserted ' . count($categories) . ' categories.');
    }
}
