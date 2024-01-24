<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('skills')->insert([
            ['skill_name' => 'Laravel',  'skill_level' => 1, 'profiles_id' => 1,],
            ['skill_name' => 'Javascript',  'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'HTML', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'CSS', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'PHP', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'GIT', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'Flutter', 'skill_level' => 1, 'profiles_id' => 1],
            ['skill_name' => 'Python', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'Spring Boot', 'skill_level' => 1, 'profiles_id' => 1],
            ['skill_name' => 'Java', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'Ajax', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'MySQL', 'skill_level' => 0, 'profiles_id' => 1],
            ['skill_name' => 'Angular', 'skill_level' => 1, 'profiles_id' => 1],
            ['skill_name' => 'Frontend', 'skill_level' => 2, 'profiles_id' => 1],
            ['skill_name' => 'Backend', 'skill_level' => 2, 'profiles_id' => 1],
            ['skill_name' => 'Full-stack', 'skill_level' => 2, 'profiles_id' => 1],
        ]);
    }
}
