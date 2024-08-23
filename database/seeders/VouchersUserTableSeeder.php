<?php

namespace Database\Seeders;

use App\Models\VouchersUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VouchersUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        VouchersUser::factory()->count(5)->create();
    }
}
