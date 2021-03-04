<?php


namespace AppBundle\Seeders;

use AppBundle\Model\DataObject\Category;
use AppBundle\Model\DataObject\Ingredient;
use AppBundle\Model\DataObject\Tag;
use AppBundle\Model\Repository\Category\CategoryRepositoryInterface;
use AppBundle\Model\Repository\Ingredient\IngredientRepositoryInterface;
use AppBundle\Model\Repository\Meal\MealRepositoryInterface;
use AppBundle\Model\Repository\Tag\TagRepositoryInterface;
use Faker;

class MealSeeder
{
    private $mealRepository;
    private $tagRepository;
    private $categoryRepository;
    private $ingredientRepository;

    public function __construct(
        MealRepositoryInterface $mealRepository,
        TagRepositoryInterface $tagRepository,
        CategoryRepositoryInterface $categoryRepository,
        IngredientRepositoryInterface $ingredientRepository
    ) {
        $this->mealRepository = $mealRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    public function seed(int $count) : void
    {
        $faker_en = Faker\Factory::create('en_EN');
        $faker_hr = Faker\Factory::create('hr_HR');
        $faker_ja = Faker\Factory::create('ja_JP');

        $categoryIds = $this->categoryRepository->getIds();
        $ingredientIds = $this->ingredientRepository->getIds();
        $tagIds = $this->tagRepository->getIds();

        for ($i = 0; $i < $count; $i++) {
            $category = Category::getById($faker_en->randomElement($categoryIds));

            $ingredients = [];
            $rand = rand(1, count($ingredientIds));
            for ($j = 0; $j < $rand; $j++) {
                $ingredients[] = Ingredient::getById($faker_en->randomElement($ingredientIds));
            }
            $ingredients = array_unique($ingredients);

            $tags = [];
            $rand = rand(1, count($tagIds));
            for ($j = 0; $j < $rand; $j++) {
                $tags[] = Tag::getById($faker_en->randomElement($tagIds));
            }
            $tags = array_unique($tags);

            $createdAt = $faker_en->dateTimeBetween('-2 years', 'now');
            $updatedAt = $faker_en->optional('0.4')->dateTimeBetween($createdAt, 'now');
            $deletedAt = $faker_en->optional('0.2')->dateTimeBetween($createdAt, 'now');


            $status = 'created';
            if ($updatedAt) {
                $status = 'modified';
            }
            if ($deletedAt) {
                $status = 'deleted';
            }

            $this->mealRepository->create([
                'title' => [
                    'en' => $faker_en->word(),
                    'hr' => $faker_hr->word(),
                    'ja' => $faker_ja->word(),
                ],
                'category' => $category,
                'ingredients' => $ingredients,
                'tags' => $tags,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'deleted_at' => $deletedAt,
                'status' => $status
            ]);
        }

    }


}
