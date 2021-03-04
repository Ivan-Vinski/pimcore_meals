<?php


namespace AppBundle\Seeders;

use AppBundle\Model\Repository\Category\CategoryRepositoryInterface;
use Faker;


class CategorySeeder
{
    private $categoryRepository;

    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param int $count
     * @retun void
     */
    public function seed(int $count) : void
    {
        $faker_en = Faker\Factory::create('en_EN');
        $faker_hr = Faker\Factory::create('hr_HR');
        $faker_ja = Faker\Factory::create('ja_JP');

        for ($i = 0; $i < $count; $i++) {
            $this->categoryRepository->create([
                'title' => [
                    'en' => $faker_en->word(),
                    'hr' => $faker_hr->word(),
                    'ja' => $faker_ja->word(),
                ]
            ]);
        }

    }
}
