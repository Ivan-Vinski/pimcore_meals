<?php


namespace AppBundle\Model\Transformer\Meal;


use AppBundle\Model\DataObject\Meal;
use AppBundle\Model\Transformer\Category\CategoryTransformerInterface;
use AppBundle\Model\Transformer\Ingredient\IngredientTransformerInterface;
use AppBundle\Model\Transformer\Tag\TagTransformerInterface;
use Zend\Paginator\Paginator;

class MealTransformer implements MealTransformerInterface
{

    private $categoryTransformer;
    private $ingredientTransformer;
    private $tagTransformer;

    public function __construct(
        CategoryTransformerInterface $categoryTransformer,
        IngredientTransformerInterface $ingredientTransformer,
        TagTransformerInterface $tagTransformer
    ) {
        $this->categoryTransformer = $categoryTransformer;
        $this->ingredientTransformer = $ingredientTransformer;
        $this->tagTransformer = $tagTransformer;
    }

    public function transform(Meal $meal): array
    {
        // TODO: Implement transform() method.
    }

    /**
     * @param Paginator $paginator
     * @param string $lang
     * @return array
     */
    public function transformBatch(Paginator $paginator, string $lang): array
    {
        $result = [];
        foreach ($paginator->getCurrentItems() as $key => $meal) {
            $result[$key] = [
                'id' => $meal->getId(),
                'title' => $meal->getTitle($lang),
                'status' => $meal->getStatus(),
            ];

            if ($category = $meal->getEagerCategory()) {
                $categoryTransformed = $this->categoryTransformer->transform($category, $lang);
                $result[$key]['category'] = $categoryTransformed;
            }

            if ($ingredients = $meal->getEagerIngredients()) {
                $ingredientsTransformed = $this->ingredientTransformer->transformBatch($ingredients, $lang);
                $result[$key]['ingredients'] = $ingredientsTransformed;
            }

            if ($tags = $meal->getEagerTags()) {
                $tagsTransformed = $this->tagTransformer->transformBatch($tags, $lang);
                $result[$key]['tags'] = $tagsTransformed;
            }

        }

        return $result;
    }

}
