<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Sacredplace;

class SacredplaceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sacredplace::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sacredPlaces = [
            [
                'name' => 'วัดพระศรีรัตนศาสดาราม (วัดพระแก้ว)',
                'description' => 'วัดประจำรัชกาลที่ 1 และเป็นที่ประดิษฐานพระแก้วมรกต',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/8/8e/Wat_Phra_Kaew_-_1.jpg',
                'latitude' => 13.7515,
                'longitude' => 100.4928,
            ],
            [
                'name' => 'วัดพระเชตุพนวิมลมังคลาราม (วัดโพธิ์)',
                'description' => 'วัดที่มีพระพุทธไสยาสน์ขนาดใหญ่ และเป็นศูนย์กลางการเรียนรู้นวดแผนไทย',
                'image' => 'https://www.matichon.co.th/wp-content/uploads/2018/09/mSQWlZdCq5b6ZLkvNCs8OEAJB29pZXeR-1024x576.jpg',
                'latitude' => 13.7465,
                'longitude' => 100.4923,
            ],
            [
                'name' => 'วัดอรุณราชวราราม (วัดอรุณ)',
                'description' => 'วัดที่มีพระปรางค์สวยงามริมแม่น้ำเจ้าพระยา',
                'image' => 'https://d2e5ushqwiltxm.cloudfront.net/wp-content/uploads/sites/62/2024/09/24083816/temple-in-bangkok.jpg',
                'latitude' => 13.7437,
                'longitude' => 100.4888,
            ],
            [
                'name' => 'ศาลหลักเมืองกรุงเทพฯ',
                'description' => 'ศาลเจ้าที่สำคัญแห่งหนึ่งของไทย เชื่อว่าเป็นที่สถิตของเทพารักษ์ผู้ปกป้องเมือง',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/d/d3/Bangkok_City_Pillar_Shrine.jpg/798px-Bangkok_City_Pillar_Shrine.jpg',
                'latitude' => 13.7525,
                'longitude' => 100.4920,
            ],
            [
                'name' => 'วัดไตรมิตรวิทยารามวรวิหาร',
                'description' => 'วัดที่ประดิษฐานพระพุทธรูปทองคำที่ใหญ่ที่สุดในโลก',
                'image' => 'https://lh4.googleusercontent.com/proxy/24CBvrm2-yRK6DN-IBFWQlIJgBF1jGr4j0pNiVfw3HGZ5EAYkLND2tKHHGsBXonkvcVWxP9vmielG49bktNg8GUIv5_-5oceGjgG29Ha0qI2VV10wtMzjanBcFhq9C3GLqqbPxUI5bc6Prc',
                'latitude' => 13.7367,
                'longitude' => 100.5130,
            ],
            [
                'name' => 'วัดพระศรีมหาอุมาเทวี (วัดแขก)',
                'description' => 'วัดฮินดูที่ประดิษฐานพระแม่อุมาเทวี เหมาะสำหรับผู้ที่ต้องการขอพรด้านความรักและความสำเร็จ',
                'image' => 'https://static.thairath.co.th/media/dFQROr7oWzulq5Fa4MEaYQBi0Cl43v3rWLFmgB17PYRV1kOOiwc3Vk3PoJaN8QqJiMb.jpg',
                'latitude' => 13.7235,
                'longitude' => 100.5215,
            ],
            [
                'name' => 'เทวาลัยพระพิฆเนศ ห้วยขวาง',
                'description' => 'สถานที่ประดิษฐานพระพิฆเนศปางยืนประทานพร เชื่อกันว่าศักดิ์สิทธิ์ในการขอพรด้านการงานและการเรียน',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/2/26/Ganesh_Shrine_at_Huai_Khwang%2C_Bangkok_%E0%B8%A8%E0%B8%B2%E0%B8%A5%E0%B8%9E%E0%B8%A3%E0%B8%B0%E0%B8%9E%E0%B8%B4%E0%B8%86%E0%B9%80%E0%B8%99%E0%B8%A8_%E0%B8%AA%E0%B8%B5%E0%B9%88%E0%B9%81%E0%B8%A2%E0%B8%81%E0%B8%AB%E0%B9%89%E0%B8%A7%E0%B8%A2%E0%B8%82%E0%B8%A7%E0%B8%B2%E0%B8%87_%28April2021%29_02.jpg',
                'latitude' => 13.7766,
                'longitude' => 100.5748,
            ],
            [
                'name' => 'ศาลท้าวมหาพรหมเอราวัณ',
                'description' => 'ศาลพระพรหมที่มีชื่อเสียง ตั้งอยู่บริเวณสี่แยกราชประสงค์ เชื่อกันว่าศักดิ์สิทธิ์ในการขอพรด้านการงานและความสำเร็จ',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/d/d1/Phra_Phrom_at_Erawan_Shrine.jpg',
                'latitude' => 13.7459,
                'longitude' => 100.5400,
            ],
            [
                'name' => 'ศาลเจ้าพ่อเสือ เสาชิงช้า',
                'description' => 'ศาลเจ้าจีนที่มีชื่อเสียงในการขอพรด้านการงาน การเงิน และโชคลาภ',
                'image' => 'https://s359.kapook.com/pagebuilder/fe5ffe61-18c8-4798-b5d0-cf53945f9189.jpg',
                'latitude' => 13.7523,
                'longitude' => 100.5014,
            ],
            [
                'name' => 'พระตรีมูรติ หน้าตึกเอ็มไพร์ทาวเวอร์',
                'description' => 'สถานที่ประดิษฐานพระตรีมูรติ เชื่อกันว่าศักดิ์สิทธิ์ในการขอพรด้านความรัก',
                'image' => 'https://d2d3n9ufwugv3m.cloudfront.net/w800-h600-cfill-q80/topics/K6WOS-IMG_1913.jpg',
                'latitude' => 13.7230,
                'longitude' => 100.5296,
            ],
            [
                'name' => 'วัดกัลยาณมิตรวรมหาวิหาร',
                'description' => 'วัดที่ประดิษฐานหลวงพ่อโต หรือซำปอกง เชื่อกันว่าการมากราบไหว้จะนำมาซึ่งมิตรภาพและความโชคดี',
                'image' => 'https://upload.wikimedia.org/wikipedia/commons/a/a0/%E0%B8%A7%E0%B8%B1%E0%B8%94%E0%B8%81%E0%B8%B1%E0%B8%A5%E0%B8%A2%E0%B8%B2%E0%B8%93%E0%B8%A1%E0%B8%B4%E0%B8%95%E0%B8%A3%E0%B8%A7%E0%B8%A3%E0%B8%A1%E0%B8%AB%E0%B8%B2%E0%B8%A7%E0%B8%B4%E0%B8%AB%E0%B8%B2%E0%B8%A3.jpg',
                'latitude' => 13.7400,
                'longitude' => 100.4889,
            ],
        ];

        $place = $this->faker->randomElement($sacredPlaces);


        return [
            'name' => $place['name'],
            'description' => $place['description'],
            'image' => $place['image'],
            'latitude' => $place['latitude'],
            'longitude' => $place['longitude'],
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
