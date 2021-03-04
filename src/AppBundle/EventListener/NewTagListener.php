<?php


namespace AppBundle\EventListener;


use AppBundle\Model\DataObject\Tag;
use Pimcore\Event\Model\ElementEventInterface;
use Pimcore\Model\DataObject\Service;
use Pimcore\Model\DataObject\Tag\Listing;

class NewTagListener
{
    const PARENT_LOCATION = '/Tags';

    public function onCreation(ElementEventInterface $e)
    {
        if ($e->getElement() instanceof Tag) {
            $newTag = $e->getElement();
            $tagListing = new Listing();
            $tagListing->setOrderKey('o_id');
            $tagListing->setOrder('desc');
            $tagListing->setLimit(1);
            $lastTag = $tagListing->getObjects();

            if ($lastTag[0]) {
                $lastKey = $lastTag[0]->getKey();
                $keyIntPart = (explode('-', $lastKey))[1];
                $keyIncremented = (int) $keyIntPart + 1;
                $newKeyIntPart = str_pad((string) $keyIncremented, 4, '0', STR_PAD_LEFT);
            } else {
                $newKeyIntPart = '0000';
            }

            $newTag->setParent(Service::createFolderByPath(self::PARENT_LOCATION));
            $newTag->setKey("tag-$newKeyIntPart");
            $newTag->setSlug("tag-$newKeyIntPart");
            $newTag->setPublished(true);


        }
    }
}
