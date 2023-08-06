<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\SectionKeyword;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SectionKeywordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for($i = 28;$i<36;$i++){
           if($i != 32){
               $str = 'qwertyuopasdfghjklzxcvvbnm';
               for ($j = 0;$j<10;$j++){
                   $shuffled = str_shuffle($str);
                   DB::table('section_keywords')->insert(
                       [
                           'section_id'=>$i,
                           'keyword'=>substr($shuffled,8)
                       ]
                );
            }
           }
        }


    }

}
