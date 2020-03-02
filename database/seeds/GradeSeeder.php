<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i < 10; $i++) { 
     		DB::table('grade')->insert([
        		'grade'  => $faker->unique()->numberBetween($min = 2, $max = 12)
        	]);
        }
    }
}
