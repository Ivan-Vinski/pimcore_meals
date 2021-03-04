<?php


namespace AppBundle\EventListener;


use AppBundle\Model\DataObject\Meal;
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Model\DataObject\Meal\Listing;
use Pimcore\Model\DataObject\Service;

class NewMealListener
{
    const PARENT_LOCATION = '/Meals';

    public function onCreation(ElementEventInterface $e)
    {
        if ($e->getElement() instanceof Meal) {
            $newMeal = $e->getElement();
            $mealListing = new Listing();
            $mealListing->setOrderKey('o_id');
            $mealListing->setOrder('desc');
            $mealListing->setLimit(1);
            $lastCategory = $mealListing->getObjects();

            if ($lastCategory[0]) {
                $lastKey = $lastCategory[0]->getKey();
                $keyIntPart = (explode('-', $lastKey))[1];
                $keyIncremented = (int) $keyIntPart + 1;
                $newKeyIntPart = str_pad((string) $keyIncremented, 4, '0', STR_PAD_LEFT);
            } else {
                $newKeyIntPart = '0000';
            }

            $newMeal->setParent(Service::createFolderByPath(self::PARENT_LOCATION));
            $newMeal->setKey("meal-$newKeyIntPart");
            $newMeal->setSlug("meal-$newKeyIntPart");
            $newMeal->setPublished(true);
        }
    }
}
