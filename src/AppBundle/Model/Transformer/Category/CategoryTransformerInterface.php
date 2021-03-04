<?php

namespace AppBundle\Model\Transformer\Category;

interface CategoryTransformerInterface
{
    /**
     * @param $category
     * @param string $lang
     * @return array
     */
    public function transform($category, string $lang) : array;

}
