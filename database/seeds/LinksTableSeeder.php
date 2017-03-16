<?php

use Illuminate\Database\Seeder;

class LinksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data= [
            [
                'link_name' => '重师大',
                'link_title' => '位于重庆的美丽大学',
                'link_url' => 'http://www.cqnu.edu.cn',
                'link_order' => 1,
            ],
            [
                'link_name' => '重师大计算机学院',
                'link_title' => '师大创新型学院',
                'link_url' => 'http://www.cqnu.edu.cn',
                'link_order' => 2,
            ]
        ];
        DB::table('links')->insert($data);
    }
}
