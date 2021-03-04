<?php


namespace AppBundle\Model\Repository\Meal;


use AppBundle\Model\DataObject\Meal;
use AppBundle\Model\Repository\Category\CategoryRepositoryInterface;
use AppBundle\Model\Repository\Ingredient\IngredientRepositoryInterface;
use AppBundle\Model\Repository\Tag\TagRepositoryInterface;
use Pimcore\Model\DataObject\Meal\Listing;
use Pimcore\Db;

class MealRepository implements MealRepositoryInterface
{
    private $categoryRepository;
    private $tagRepository;
    private $ingredientRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        TagRepositoryInterface $tagRepository,
        IngredientRepositoryInterface $ingredientRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->tagRepository = $tagRepository;
        $this->ingredientRepository = $ingredientRepository;
    }

    /**
     * @param array $data
     * @return Meal
     * @throws \Exception
     */
    public function create(array $data): Meal
    {
        $meal = new Meal();

        //$meal->setValues($data);

        $meal->setTitle($data['title']['en'], 'en');
        $meal->setTitle($data['title']['hr'], 'hr');
        $meal->setTitle($data['title']['ja'], 'ja');

        $meal->setCategory($data['category']);
        $meal->setIngredients($data['ingredients']);
        $meal->setTags($data['tags']);
        $meal->setCreated_at($data['created_at']);
        $meal->setUpdated_at($data['updated_at']);
        $meal->setDeleted_at($data['deleted_at']);
        $meal->setStatus($data['status']);

        return $meal->save();
    }

    /**
     * @param array $filters
     * @param array $embed
     * @return Listing
     */
    public function getMealListing(array $filters, array $embed) : Listing
    {
        $mealListing = new Listing();

        foreach ($filters as $filterName => $filterParam) {
            $method = 'filter'.ucfirst($filterName);
            if (method_exists(MealRepository::class, $method)) {
                $mealListing = $this->$method($mealListing, $filterParam);
            }
        }

        foreach ($embed as $value) {
            $method = "embed$value";
            if (method_exists(MealRepository::class, $method)) {
                $mealListing = $this->$method($mealListing);
            }
        }
        return $mealListing;
    }

    /**
     * @param Listing $mealListing
     * @param $filterParam
     * @return Listing
     */
    private function filterCategory(Listing $mealListing, $filterParam) : Listing
    {
        if ($filterParam) {
            $mealListing->addConditionParam('category__id = :category', ['category' => $filterParam]);
        }

        return $mealListing;
    }

    /**
     * @param Listing $mealListing
     * @param $filterParam
     * @return Listing
     */
    public function filterDiffTime(Listing $mealListing, $filterParam) : Listing
    {
        if ($filterParam) {
            $mealListing->addConditionParam('created_at > :date OR updated_at > :date OR deleted_at > :date', ['date' => $filterParam]);
        } else {
            $mealListing->addConditionParam("status != 'deleted'");
        }

        return $mealListing;
    }

    /**
     * @param Listing $mealListing
     * @return Listing
     */
    public function embedCategory(Listing $mealListing) : Listing
    {
        $meals = $mealListing->getObjects();
        $mealCategoryIds = $this->getMealCategoryIdPairs();
        //dd($mealCategoryIds);

        foreach ($meals as $meal) {
            $categoryId = $mealCategoryIds[$meal->getId()];
            $category = $this->categoryRepository->getById($categoryId);
            //dd($meal);
            $meal->setEagerCategory($category);
        }

        return $mealListing->setObjects($meals);
    }

    /**
     * @param Listing $mealListing
     * @return Listing
     */
    public function embedTags(Listing $mealListing) : Listing
    {
        $meals = $mealListing->getObjects();

        $mealTagsIds = $this->getMealTagsIdPairs();

        foreach ($meals as $meal) {
            $tagsIds = $mealTagsIds[$meal->getId()];
            $tags = $this->tagRepository->getTagsByIds($tagsIds);
            $meal->setEagerTags($tags);
        }

        return $mealListing->setObjects($meals);
    }

    /**
     * @param Listing $mealListing
     * @return Listing
     */
    public function embedIngredients(Listing $mealListing) : Listing
    {
        $meals = $mealListing->getObjects();
        $mealIngredientsIds = $this->getMealIngredientsIdPairs();

        foreach ($meals as $meal) {
            $ingredientsIds = $mealIngredientsIds[$meal->getId()];
            $ingredients = $this->ingredientRepository->getIngredientsByIds($ingredientsIds);
            $meal->setEagerIngredients($ingredients);
        }

        return $mealListing->setObjects($meals);
    }


    /**
     * @return array
     * @throws \Doctrine\DBAL\DBALException
     */
    public function getMealCategoryIdPairs() : array
    {
        $conn = Db::get();
        $sql = "SELECT src_id, dest_id FROM object_relations_Meal WHERE fieldname LIKE 'category' GROUP BY src_id, dest_id";
        return $conn->fetchPairs($sql);
    }

    /**
     * @return array
     */
    public function getMealTagsIdPairs() : array
    {
        $conn = Db::get();
        $sql = "SELECT src_id, dest_id FROM object_relations_Meal WHERE fieldname LIKE 'tags' GROUP BY src_id, dest_id";
        $res = $conn->fetchAll($sql);

        $processed = [];
        foreach ($res as $element) {
            $processed[$element['src_id']][] = $element['dest_id'];
        }

        return $processed;
    }

    /**
     * @return array
     */
    public function getMealIngredientsIdPairs() : array
    {
        $conn = Db::get();
        $sql = "SELECT src_id, dest_id FROM object_relations_Meal WHERE fieldname LIKE 'ingredients' GROUP BY src_id, dest_id";
        $res = $conn->fetchAll($sql);

        $processed = [];
        foreach ($res as $element) {
            $processed[$element['src_id']][] = $element['dest_id'];
        }

        return $processed;
    }

}
