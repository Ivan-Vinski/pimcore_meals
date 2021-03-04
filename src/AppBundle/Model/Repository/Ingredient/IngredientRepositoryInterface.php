<?php

namespace AppBundle\Model\Repository\Ingredient;

use AppBundle\Model\DataObject\Ingredient;

interface IngredientRepositoryInterface
{
    /**
     * @param array $data
     * @return Ingredient
     */
    public function create(array $data) : Ingredient;

    /**
     * @param array $ids
     * @return Ingredient[]
     */
    public function getIngredientsByIds(array $ids);

    /**
     * @return array
     */
    public function getIds() : array;


}
