<?php


namespace AppBundle\Seeders;

use AppBundle\Model\Repository\Ingredient\IngredientRepositoryInterface;
use Faker;

class IngredientSeeder
{
    private $ingredientRepository;

    public function __construct(IngredientRepositoryInterface $ingredientRepository)
    {
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * @param int $count
     */
    public function seed(int $count) : void
    {
        $faker_en = Faker\Factory::create('en_EN');
        $faker_hr = Faker\Factory::create('hr_HR');
        $faker_ja = Faker\Factory::create('ja_JP');

        for ($i = 0; $i < $count; $i++) {
            $this->ingredientRepository->create([
                'title' => [
                    'en' => $faker_en->word(),
                    'hr' => $faker_hr->word(),
                    'ja' => $faker_ja->word(),
                ]
            ]);
        }
    }
}
