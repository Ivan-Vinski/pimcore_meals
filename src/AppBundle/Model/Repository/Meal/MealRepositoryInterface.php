<?php

namespace AppBundle\Model\Repository\Meal;

use AppBundle\Model\DataObject\Meal;
use Pimcore\Model\DataObject\Meal\Listing;

interface MealRepositoryInterface
{
    /**
     * @param array $data
     * @return Meal
     */
    public function create(array $data) : Meal;

    /**
     * @param array $filters
     * @param array $embed
     * @return Listing
     */
    public function getMealListing(array $filters, array $embed) : Listing;
}
