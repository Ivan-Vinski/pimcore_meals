<?php


namespace AppBundle\Model\Transformer\Tag;


class TagTransformer implements TagTransformerInterface
{
    /**
     * @param $tags
     * @param string $lang
     * @return array
     */
    public function transformBatch($tags, string $lang) : array
    {
        $result = [];
        foreach ($tags as $tag)
        {
            $result[] = [
                'id' => $tag->getId(),
                'title' => $tag->getTitle($lang),
                'slug' => $tag->getSlug()
            ];
        }

        return $result;
    }
}
