<?php

namespace AppBundle\Model\Repository\Category;

use AppBundle\Model\DataObject\Category;

interface CategoryRepositoryInterface
{
    /**
     * @param array $data
     * @return Category
     */
    public function create(array $data) : Category;

    /**
     * @return array
     */
    public function getIds() : array;


}
