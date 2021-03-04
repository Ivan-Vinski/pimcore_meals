<?php


namespace AppBundle\Model\DataObject;


class Meal extends \Pimcore\Model\DataObject\Meal
{
    protected $eagerCategory;
    protected $eagerIngredients = [];
    protected $eagerTags = [];

    /**
     * @param Category $category
     */
    public function setEagerCategory(Category $category)
    {
        $this->eagerCategory = $category;
    }

    /**
     * @return Category
     */
    public function getEagerCategory()
    {
        //dd($this->eagerCategory);
        return $this->eagerCategory;
    }

    /**
     * @param Ingredient[]
     */
    public function setEagerIngredients($ingredients)
    {
        $this->eagerIngredients = $ingredients;
    }

    /**
     * @return Ingredient[]
     */
    public function getEagerIngredients()
    {
        return $this->eagerIngredients;
    }

    /**
     * @param Tag[]
     */
    public function setEagerTags($tags)
    {
        $this->eagerTags = $tags;
    }

    /**
     * @return Tag[]
     */
    public function getEagerTags()
    {
        return $this->eagerTags;
    }



}
