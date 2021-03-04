<?php

namespace AppBundle\Model\Repository\Tag;

use AppBundle\Model\DataObject\Tag;

interface TagRepositoryInterface
{
    /**
     * @param array $data
     * @return Tag
     */
    public function create(array $data) : Tag;

    /**
     * @param array $ids
     * @return Tag[]
     */
    public function getTagsByIds(array $ids);

    /**
     * @return array
     */
    public function getIds() : array;

}
