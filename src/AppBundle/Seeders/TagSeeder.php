<?php


namespace AppBundle\Seeders;


use AppBundle\Model\Repository\Tag\TagRepositoryInterface;
use Faker;

class TagSeeder
{
    private $tagRepository;

    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param int $count
     * @return void
     */
    public function seed(int $count) : void
    {
        $faker_en = Faker\Factory::create('en_EN');
        $faker_hr = Faker\Factory::create('hr_HR');
        $faker_ja = Faker\Factory::create('ja_JP');

        for ($i = 0; $i < $count; $i++) {
            $this->tagRepository->create([
                'title' => [
                    'en' => $faker_en->word(),
                    'hr' => $faker_hr->word(),
                    'ja' => $faker_ja->word(),
                ]
            ]);
        }
    }
}
