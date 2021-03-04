<?php

namespace AppBundle\Model\Transformer\Ingredient;

interface IngredientTransformerInterface
{
    /**
     * @param $ingredient
     * @param string $lang
     * @return array
     */
    public function transformBatch($ingredient, string $lang) : array;
}
