<?php

namespace AppBundle\Controller;

use AppBundle\Model\Repository\Meal\MealRepositoryInterface;
use AppBundle\Model\Transformer\Meal\MealTransformerInterface;
use AppBundle\Validation\GetMealValidator;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Zend\Paginator\Paginator;

class DefaultController extends FrontendController
{
    /**
     * @param Request $request
     * @param GetMealValidator $validator
     * @param MealRepositoryInterface $mealRepository
     */
    public function defaultAction (
        Request $request,
        GetMealValidator $validator,
        MealRepositoryInterface $mealRepository,
        MealTransformerInterface $mealTransformer
    )
    {
        $lang = $request->get('lang') ? $request->get('key') : $this->document->getProperty('lang');
        //dd($lang);

        $errors = $validator->validate([
            'lang' => $lang,
            'per_page' => $request->get('per_page'),
            'page' => $request->get('page'),
            'diff_time' => $request->get('diff_time'),
            'with' => explode(',', $request->get('with'))
        ]);

        if ($errors->count() != 0) {
            return $this->json([$errors]);
        }

        $filters = [
            'category' => $request->get('category'),
            'diffTime' => $request->get('diff_time'),
        ];

        $embed = explode(',', $request->get('with'));

        $mealListing = $mealRepository->getMealListing($filters, $embed);
        $paginator = new Paginator($mealListing);
        $paginator->setCurrentPageNumber($request->get('page'));
        $paginator->setItemCountPerPage($request->get('per_page'));

        $lang = $request->get('lang');
        $final = $mealTransformer->transformBatch($paginator, $lang);
        return $this->json($final);

    }
}
