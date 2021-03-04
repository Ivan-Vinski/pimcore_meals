<?php


namespace AppBundle\Model\Repository\Tag;


use AppBundle\Model\DataObject\Tag;
use Pimcore\Db;
use Pimcore\Model\Dataobject\Service;
use Pimcore\Model\DataObject\Tag\Listing;

class TagRepository implements TagRepositoryInterface
{
    /**
     * @param array $data
     * @return Tag
     * @throws \Exception
     */
    public function create(array $data): Tag
    {
        $tag = new Tag();

        $tag->setTitle($data['title']['en'], 'en');
        $tag->setTitle($data['title']['hr'], 'hr');
        $tag->setTitle($data['title']['ja'], 'ja');

        return $tag->save();
    }

    /**
     * @param array $ids
     * @return Tag[]
     */
    public function getTagsByIds(array $ids)
    {
        $tagListing = new Listing();
        $tagListing->addConditionParam('o_id IN (?)', [$ids]);
        return $tags = $tagListing->getObjects();
    }

    /**
     * @retun array
     */
    public function getIds() : array
    {
       $tagListing = new Listing();
       return $tagListing->loadIdList();
    }

}
