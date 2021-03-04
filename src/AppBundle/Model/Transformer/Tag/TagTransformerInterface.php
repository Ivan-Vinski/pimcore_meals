<?php

namespace AppBundle\Model\Transformer\Tag;

interface TagTransformerInterface
{
    /**
     * @param $tags
     * @param string $lang
     * @return array
     */
    public function transformBatch($tags, string $lang) : array;

}
