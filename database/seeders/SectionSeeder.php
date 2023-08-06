<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
            Section::factory(3)->create()->each(function ($section){
                Category::factory(5)->create(['section_id' => $section->id])->each(function ($category) use ($section)
                {
                    Category::factory(7)->create(
                        [
                            'section_id' => $section->id,
                            'parent_id'=>$category->id
                        ]
                    );
                });
            });
    }
}
