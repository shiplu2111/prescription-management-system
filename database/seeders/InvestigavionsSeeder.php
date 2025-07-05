<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Investigavion;

class InvestigavionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'X-ray',
                'description' => 'X-ray description'
            ],
            [
                'name' => 'CT Scan',
                'description' => 'CT Scan description'
            ],
            [
                'name' => 'MRI',
                'description' => 'MRI description'
            ],
            [
                'name' => 'Blood Test',
                'description' => 'Blood Test description'
            ],
            [
                'name' => 'Stool Test',
                'description' => 'Stool Test description'
            ],
            [
                'name' => 'Urine Test',
                'description' => 'Urine Test description'
            ],
            [
                'name' => 'Blood Pressure',
                'description' => 'Blood Pressure description'
            ],
            [
                'name' => 'Temperature',
                'description' => 'Temperature description'
            ],
            [
                'name' => 'Weight',
                'description' => 'Weight description'
            ],
            [
                'name' => 'Height',
                'description' => 'Height description'
            ],
            [
                'name' => 'Pulse Rate',
                'description' => 'Pulse Rate description'
            ],
            [
                'name' => 'Respiration Rate',
                'description' => 'Respiration Rate description'
            ],
            [
                'name' => 'Oxygen Saturation',
                'description' => 'Oxygen Saturation description'
            ]
        ]
        ;
        foreach ($data as $key => $value) {
            Investigavion::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
    }
}
