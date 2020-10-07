<?php

namespace App\Controller\Api;


use App\Entity\Camp;
use App\Entity\Ingredient;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SuppliesApiController extends ApiController
{
    public function show_for_camp(Camp $camp, Request $request)
    {
        $this->throwExceptionIfNotExcists($camp);
        $this->denyAccessUnlessGranted('view', $camp);

        $entityManager = $this->getDoctrine()->getManager();

        if (empty($request->query->get('rayons'))) {
            $rayons = null;
        } else {
            $rayons = $request->query->get('rayons');
        }

        if (empty($request->query->get('daycount'))) {
            $daycount = null;
        } else {
            $daycount = $request->query->get('daycount');
        }

        $allIngredients = $entityManager->getRepository(Ingredient::class)
            ->findArrayByCamp($camp, $rayons, $daycount);

        return new JsonResponse($allIngredients);
    }

    public function show_for_camp_with_mealdetail(Camp $camp)
    {
        $this->throwExceptionIfNotExcists($camp);
        $this->denyAccessUnlessGranted('view', $camp);

        $entityManager = $this->getDoctrine()->getManager();

        $allIngredients = $entityManager->getRepository(Ingredient::class)
            ->findArraywithDatesByCamp($camp);

        $json = $this->mapByRayon($allIngredients);

        return new JsonResponse($json);
    }

    private function mapByRayon($array)
    {
        $json = [];

        foreach ($array as $mealIngredient) {
            // if rayon doesn't exist, create it
            if (empty($json[$mealIngredient['rayon']]['rayonname'])) {
                $json[$mealIngredient['rayon']]['rayonname'] = $mealIngredient['rayon'];
            }

            // if ingredient doesn't exist, create it
            if (empty($json[$mealIngredient['rayon']]['supplies'][$mealIngredient['name']])) {
                $setKeys = ['name', 'rayon'];
                $subarray = $this->mapKeysInArray($mealIngredient, $setKeys);

                $json[$mealIngredient['rayon']]['supplies'][$mealIngredient['name']] = $subarray;
            }
            
            // set the keys for the subarray
            $setKeys = ['quantity', 'unit', 'moment', 'campdaycount', 'date'];
            $subarray = $this->mapKeysInArray($mealIngredient, $setKeys);

            $json[$mealIngredient['rayon']]['supplies'][$mealIngredient['name']]['meals'][] = $subarray;
        };

        return $json;
    }

    /**
     * Returns a mapped array with values from a given array
     * For the keys and values that are asked
     *
     * @param array $arr
     * @param array $keys
     * @return void
     */
    private function mapKeysInArray($arr, $keys)
    {
        $array = [];

        foreach ($keys as $key) {
            $array[$key] = $arr[$key];
        }

        return $array;
    }
}