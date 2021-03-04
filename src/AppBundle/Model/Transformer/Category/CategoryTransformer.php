<?php


namespace AppBundle\Model\Transformer\Category;


use AppBundle\Model\DataObject\Category;

class CategoryTransformer implements CategoryTransformerInterface
{
    /**
     * @param $category
     * @param string $lang
     * @return array
     */
    public function transform($category, string $lang) : array
    {
        return $result = [
            'id' => $category->getId(),
            'title' => $category->getTitle($lang),
            'slug' => $category->getSlug()
        ];
    }

}
