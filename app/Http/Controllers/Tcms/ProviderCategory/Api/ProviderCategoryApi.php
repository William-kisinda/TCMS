<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\ProviderCategory\Dao\ProviderCategoryDaoImpl;
use App\Http\Controllers\Tcms\ProviderCategory\Dto\ProviderCategoryDto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProviderCategoryApi extends Controller
{
    private $providerCategoryDao = null;

    public function __construct()
    {
        $this->providerCategoryDao = new ProviderCategoryDaoImpl();
    }

    /**
     * Display a listing of provider categories.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function providerCategories()
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $providerCategories = $this->providerCategoryDao->getProviderCategories();

            $providerCategoriesDto = new ProviderCategoryDto();
            //Checking if the object has data
            if (!blank($providerCategories)) {
                $providerCategoriesArray = $providerCategoriesDto->getProviderCategoryDto($providerCategories->getProviderCategoryId(), $providerCategories->getProviderCategoryCode(), $providerCategories->getProviderCategoryName());
                $providerCategoriesDto->setAttributes($providerCategoriesArray);
                return Response()->json(["error" => false, "providerCategories" => $providerCategoriesDto->getAttributes()], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providerCategories" => $providerCategoriesDto->getAttributes()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
