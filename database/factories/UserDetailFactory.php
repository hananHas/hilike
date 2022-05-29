<?php

namespace Database\Factories;

use App\Models\UserDetail;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserDetailFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = UserDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nickname' => $this->faker->name(),
            'about' => $this->faker->text,
            'dob' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'origin_country_id' => $this->faker->numberBetween($min = 1, $max = 252),
            'residence_country_id' => $this->faker->numberBetween($min = 1, $max = 252),
            'gender' => 'female',
            'state' => $this->faker->state,
            'religion_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'social_type_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'marriage_type_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'education_id' => $this->faker->numberBetween($min = 1, $max = 11),
            'job_id' => $this->faker->numberBetween($min = 1, $max = 5),
            'children' => $this->faker->numberBetween($min = 0, $max = 5),
            'smoking' => $this->faker->numberBetween($min = 0, $max = 1),
            'language' => 'en',
            'height' => $this->faker->numberBetween($min = 150, $max = 180),
            'skin_color_id' => $this->faker->numberBetween($min = 1, $max = 6),
            'job' => $this->faker->numberBetween($min = 1, $max = 6),
            'body_id' => $this->faker->numberBetween($min = 1, $max = 8),
            'plan_id' => $this->faker->numberBetween($min = 1, $max = 3),
            'latitude' => $this->faker->latitude($min = 20, $max = 50),
            'longitude' => $this->faker->longitude($min = 30, $max = 50),
            'online' => $this->faker->numberBetween($min = 0, $max = 1),
            'profile_progress' => 90,
            'last_visit' => '2021-08-05',
            'profile_image' => NULL,
        ];
    }
}
