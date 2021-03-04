<?php


namespace AppBundle\EventListener;


use AppBundle\Model\DataObject\Category;
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Model\DataObject\Category\Listing;
use Pimcore\Model\DataObject\Service;

class NewCategoryListener
{
    const PARENT_LOCATION = '/Categories';

    public function onCreation(ElementEventInterface $e)
    {
        if ($e->getElement() instanceof Category) {
            $newCategory = $e->getElement();
            $categoryListing = new Listing();
            $categoryListing->setOrderKey('o_id');
            $categoryListing->setOrder('desc');
            $categoryListing->setLimit(1);
            $lastCategory = $categoryListing->getObjects();

            if ($lastCategory[0]) {
                $lastKey = $lastCategory[0]->getKey();
                $keyIntPart = (explode('-', $lastKey))[1];
                $keyIncremented = (int) $keyIntPart + 1;
                $newKeyIntPart = str_pad((string) $keyIncremented, 4, '0', STR_PAD_LEFT);
            } else {
                $newKeyIntPart = '0000';
            }

            $newCategory->setParent(Service::createFolderByPath(self::PARENT_LOCATION));
            $newCategory->setKey("category-$newKeyIntPart");
            $newCategory->setSlug("category-$newKeyIntPart");
            $newCategory->setPublished(true);
        }

    }

}
