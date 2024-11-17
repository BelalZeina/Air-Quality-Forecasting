<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cities = [
            ['ar' => 'القاهرة', 'en' => 'Cairo'],
            ['ar' => 'الإسكندرية', 'en' => 'Alexandria'],
            ['ar' => 'الجيزة', 'en' => 'Giza'],
            ['ar' => 'الأقصر', 'en' => 'Luxor'],
            ['ar' => 'أسوان', 'en' => 'Aswan'],
            ['ar' => 'بورسعيد', 'en' => 'Port Said'],
            ['ar' => 'السويس', 'en' => 'Suez'],
            ['ar' => 'المنصورة', 'en' => 'Mansoura'],
            ['ar' => 'طنطا', 'en' => 'Tanta'],
            ['ar' => 'الزقازيق', 'en' => 'Zagazig'],
            ['ar' => 'أسيوط', 'en' => 'Assiut'],
            ['ar' => 'المنيا', 'en' => 'Minya'],
            ['ar' => 'دمياط', 'en' => 'Damietta'],
            ['ar' => 'قنا', 'en' => 'Qena'],
            ['ar' => 'سوهاج', 'en' => 'Sohag'],
            ['ar' => 'بني سويف', 'en' => 'Beni Suef'],
            ['ar' => 'كفر الشيخ', 'en' => 'Kafr El Sheikh'],
            ['ar' => 'مطروح', 'en' => 'Matrouh'],
            ['ar' => 'البحيرة', 'en' => 'Beheira'],
            ['ar' => 'الغربية', 'en' => 'Gharbia'],
            ['ar' => 'الدقهلية', 'en' => 'Dakahlia'],
            ['ar' => 'الشرقية', 'en' => 'Sharqia'],
            ['ar' => 'الفيوم', 'en' => 'Faiyum'],
            ['ar' => 'البحر الأحمر', 'en' => 'Red Sea'],
            ['ar' => 'الوادي الجديد', 'en' => 'New Valley'],
            ['ar' => 'شمال سيناء', 'en' => 'North Sinai'],
            ['ar' => 'جنوب سيناء', 'en' => 'South Sinai'],
            ['ar' => 'الإسماعيلية', 'en' => 'Ismailia'],
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name_ar' => $city['ar'],
                'name_en' => $city['en'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
