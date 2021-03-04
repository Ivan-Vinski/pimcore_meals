<?php


namespace AppBundle\Model\Repository\Category;


use AppBundle\Model\DataObject\Category;
use Pimcore\Model\DataObject\Category\Listing;

class CategoryRepository implements CategoryRepositoryInterface
{
    /**
     * @param array $data
     * @return Category
     * @throws \Exception
     */
    public function create(array $data): Category
    {
        $category = new Category();

        $category->setTitle($data['title']['en'], 'en');
        $category->setTitle($data['title']['hr'], 'hr');
        $category->setTitle($data['title']['ja'], 'ja');

        return $category->save();
    }

    public function getById(string $id) : Category
    {
        return Category::getById($id);
    }


    /**
     * @retun array
     */
    public function getIds() : array
    {
        $categoryListing = new Listing();
        return $categoryListing->loadIdList();
    }

}
