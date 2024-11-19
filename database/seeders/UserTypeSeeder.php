<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Мастер',
            ],
            [
                'name' => 'Риэлтор',
            ],
            [
                'name' => 'Заказчик',
            ],
        ];
        foreach ($data as $item) {
            UserType::firstOrCreate($item);
        }
    }
}
