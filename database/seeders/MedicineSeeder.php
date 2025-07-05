<?php

namespace Database\Seeders;

use App\Models\Medicine;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $genericNames = [
            'Paracetamol', 'Ciprofloxacin', 'Metronidazole', 'Omeprazole', 'Azithromycin',
            'Amoxicillin', 'Ibuprofen', 'Cetirizine', 'Ranitidine', 'Losartan',
            'Amlodipine', 'Atorvastatin', 'Clindamycin', 'Diclofenac', 'Metformin',
            'Gliclazide', 'Hydrochlorothiazide', 'Salbutamol', 'Doxycycline', 'Flucloxacillin',
            // ... add more generics as needed
        ];

        $brands = [
            'Square', 'Beximco', 'Incepta', 'Renata', 'ACME', 'Eskayef', 'Opsonin',
            'Healthcare', 'Aristopharma', 'Radiant', 'ACI', 'General Pharma',
        ];

        $forms = [
            'Tablet', 'Capsule', 'Syrup', 'Suspension', 'Injection', 'Cream', 'Gel',
        ];

        for ($i = 1; $i <= 20; $i++) {
            $generic = $genericNames[array_rand($genericNames)];
            $brand = $brands[array_rand($brands)];
            $form = $forms[array_rand($forms)];
            $strength = rand(5, 500) . 'mg';

            $name = $generic . ' ' . $strength . ' - ' . $brand . ' (' . $form . ')';

            Medicine::create([
                'name' => $name,
                'description' => 'Used for general treatment in Bangladesh. Generic: ' . $generic . ', Brand: ' . $brand . ', Form: ' . $form . ', Strength: ' . $strength,
            ]);
        }
    }
}
