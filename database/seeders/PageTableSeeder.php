<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('pages')->truncate();
        $pages = [
            [
                'id'             => 1,
                'page_name'       => 'Home',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'home',
                'type'           => 'header',
                'subtitle'       => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 2,
                'page_name'       => 'Health',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'health',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 3,
                'page_name'       => 'Seminar',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'seminar',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 4,
                'page_name'       => 'News',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'news',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 5,
                'page_name'       => 'Contact Us',
                'title'          => 'Trueyou realize your potential',
                'slug'           => 'contact-us',
                'type'           => 'header',
                'subtitle'    => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry',
                'button'         =>  null,
                'status'         =>  1,
                'created_at'     => date('Y-m-d H:i:s'),
                'updated_at'     => date('Y-m-d H:i:s'),
            ],

            [
                'id'             => 6,
                'page_name'       => 'Login',
                'title'          => 'Login Now',
                'slug'           => 'login',
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
