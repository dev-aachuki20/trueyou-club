<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pages = [
            [
                'id'             => 1,
                'page_key'       => 'Home',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'trueyou-realize-your-potential',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 2,
                'page_key'       => 'Health',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'trueyou-realize-your-potential',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 3,
                'page_key'       => 'Seminar',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'trueyou-realize-your-potential',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 4,
                'page_key'       => 'News',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'trueyou-realize-your-potential',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 5,
                'page_key'       => 'Contact Us',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'trueyou-realize-your-potential',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],
        ];
        Page::insert($pages);
    }
}
