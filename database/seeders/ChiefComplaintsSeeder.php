<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ChiefComplaint;

class ChiefComplaintsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Headache',
                'description' => 'Headache description'
            ],
            [
                'name' => 'Cough',
                'description' => 'Cough description'
            ],
            [
                'name' => 'Fever',
                'description' => 'Fever description'
            ],
            [
                'name' => 'Sore throat',
                'description' => 'Sore throat description'
            ],
            [
                'name' => 'Runny nose',
                'description' => 'Runny nose description'
            ],
            [
                'name' => 'Vomiting',
                'description' => 'Vomiting description'
            ],
            [
                'name' => 'Diarrhea',
                'description' => 'Diarrhea description'
            ],
            [
                'name' => 'Nausea',
                'description' => 'Nausea description'
            ],
            [
                'name' => 'Fatigue',
                'description' => 'Fatigue description'
            ],
            [
                'name' => 'Loss of taste or smell',
                'description' => 'Loss of taste or smell description'
            ],
            [
                'name' => 'Shortness of breath',
                'description' => 'Shortness of breath description'
            ],
            [
                'name' => 'Muscle pain',
                'description' => 'Muscle pain description'
            ],
            [
                'name' => 'Joint pain',
                'description' => 'Joint pain description'
            ],
            [
                'name' => 'Nausea',
                'description' => 'Nausea description'
            ],
            [
                'name' => 'Vomiting',
                'description' => 'Vomiting description'
            ],
            [
                'name' => 'Diarrhea',
                'description' => 'Diarrhea description'
            ],
            [
                'name' => 'Fatigue',
                'description' => 'Fatigue description'
            ],
            [
                'name' => 'Loss of taste or smell',
                'description' => 'Loss of taste or smell description'
            ],
            [
                'name' => 'Shortness of breath',
                'description' => 'Shortness of breath description'
            ],
            [
                'name' => 'Muscle pain',
                'description' => 'Muscle pain description'
            ],
            [
                'name' => 'Joint pain',
                'description' => 'Joint pain description'
            ],


        ];
        foreach ($data as $key => $value) {
            ChiefComplaint::create([
                'name' => $value['name'],
                'description' => $value['description'],
            ]);
        }
        }

}
