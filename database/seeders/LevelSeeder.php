<?php

namespace Database\Seeders;

use App\Models\Level;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            'ND 1',
            'ND 2',
            'HND 1',
            'HND 2',
        ];

        foreach ($levels as $level) {
            Level::firstOrCreate(['name' => $level]);
        }
    }
}