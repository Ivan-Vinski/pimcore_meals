<?php


namespace AppBundle\Model\Transformer\Ingredient;


class IngredientTransformer implements IngredientTransformerInterface
{
    /**
     * @param $ingredients
     * @param string $lang
     * @return array
     */
    public function transformBatch($ingredients, string $lang) : array
    {
        $result = [];
        foreach ($ingredients as $ingredient)
        {
            $result[] = [
                'id' => $ingredient->getId(),
                'title' => $ingredient->getTitle($lang),
                'slug' => $ingredient->getSlug()
            ];
        }

        return $result;
    }

}
