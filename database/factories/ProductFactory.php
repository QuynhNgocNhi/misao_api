<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'                     => $this->faker->numberBetween(90, 100),
            'name'                        => $this->faker->word(),
            'price'                       => $this->faker->randomElement(['1518000', '3618000', '4527000', '2511000', '1618000']),
            'category_id'                => $this->faker->numberBetween(1, 5),
            'is_available'                      => 1,
            'discount'                      => $this->faker->numberBetween(10, 20),
            'unit'                      => $this->faker->randomElement(['kg', 'chuc', 'cai']),
            'inventory_number'                     => $this->faker->numberBetween(90, 100),
            'description'                     => $this->faker->paragraph(),
            'is_active'                     => 1

        ];
    }
}
