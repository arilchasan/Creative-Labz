<?php

namespace Database\Seeders;

use App\Models\Nic;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nic::truncate();

        Nic::create(['nic' => '3 MG']);
        Nic::create(['nic' => '6 MG']);
        Nic::create(['nic' => '9 MG']);
    }
}
