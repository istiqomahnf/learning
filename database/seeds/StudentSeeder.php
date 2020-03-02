<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i=0; $i <20 ; $i++) { 
        	DB::table('students')->insert([
        		'name' 		=> $faker->name,
        		'address'	=> $faker->address,
        		'age' 		=> $faker->unique()->numberBetween($min = 10, $max = 50),
                'grade_id'  => $i+1
        	]);
        }
    }
}
