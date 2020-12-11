<?php

namespace Database\Factories;

use App\Models\UserFiles;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFilesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserFiles::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name .'.csv',
            'format' => 'csv',
            'size' => '2000'
        ];
    }
}
