<?php


namespace AppBundle\Model\Repository\Ingredient;


use AppBundle\Model\DataObject\Ingredient;
use Pimcore\Model\DataObject\Ingredient\Listing;

class IngredientRepository implements IngredientRepositoryInterface
{
    /**
     * @param array $data
     * @return Ingredient
     * @throws \Exception
     */
    public function create(array $data): Ingredient
    {
        $ingredient = new Ingredient();

        $ingredient->setTitle($data['title']['en'], 'en');
        $ingredient->setTitle($data['title']['hr'], 'hr');
        $ingredient->setTitle($data['title']['ja'], 'ja');

        return $ingredient->save();
    }

    /**
     * @param array $ids
     * @return Ingredient[]
     */
    public function getIngredientsByIds(array $ids)
    {
        $ingredientListing = new Listing();
        $ingredientListing->addConditionParam('o_id IN (?)', [$ids]);
        return $ingredientListing->getObjects();
    }

    /**
     * @retun array
     */
    public function getIds() : array
    {
       $ingredientListing = new Listing();
       return $ingredientListing->loadIdList();
    }


}
