<?php

namespace AppBundle\Model\Transformer\Meal;

use AppBundle\Model\DataObject\Meal;
use Zend\Paginator\Paginator;

interface MealTransformerInterface
{
    /**
     * @param Meal $meal
     * @return array
     */
    public function transform(Meal $meal) : array;


    /**
     * @param Paginator $paginator
     * @param string $lang
     * @return array
     */
    public function transformBatch(Paginator $paginator, string $lang) : array;
}
