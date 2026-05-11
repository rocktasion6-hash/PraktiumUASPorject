<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        TaskStatus::create([
            'name' => 'Belum Dikerjakan'
        ]);

        TaskStatus::create([
            'name' => 'Sedang Dikerjakan'
        ]);

        TaskStatus::create([
            'name' => 'Selesai'
        ]);

        TaskStatus::create([
            'name' => 'Ditunda'
        ]);
    }
}