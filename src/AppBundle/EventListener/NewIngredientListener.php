<?php


namespace AppBundle\EventListener;


use AppBundle\Model\DataObject\Ingredient;
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Model\DataObject\Ingredient\Listing;
use Pimcore\Model\DataObject\Service;

class NewIngredientListener
{
    const PARENT_LOCATION = '/Ingredients';

    public function onCreation(ElementEventInterface $e)
    {
        if ($e->getElement() instanceof Ingredient) {
            $newIngredient = $e->getElement();
            $ingredientListing = new Listing();
            $ingredientListing->setOrderKey('o_id');
            $ingredientListing->setOrder('desc');
            $ingredientListing->setLimit(1);
            $lastIngredient = $ingredientListing->getObjects();

            if ($lastIngredient[0]) {
                $lastKey = $lastIngredient[0]->getKey();
                $keyIntPart = (explode('-', $lastKey))[1];
                $keyIncremented = (int) $keyIntPart + 1;
                $newKeyIntPart = str_pad((string) $keyIncremented, 4, '0', STR_PAD_LEFT);
            } else {
                $newKeyIntPart = '0000';
            }

            $newIngredient->setParent(Service::createFolderByPath(self::PARENT_LOCATION));
            $newIngredient->setKey("ingredient-$newKeyIntPart");
            $newIngredient->setSlug("ingredient-$newKeyIntPart");
            $newIngredient->setPublished(true);
        }
    }
}
