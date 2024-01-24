<?php

namespace Database\Seeders;

use App\Models\profiles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilesFactory extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        factory(ProfilesFactory::class,20)->create();
    }
}
