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

    public function getProviderCategories()
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $providerCategories = $this->providerCategoryDao->getProviderCategories();

            $providerCategoriesDto = new ProviderCategoryDto();
            //Checking if the object has data
            if (!blank($providerCategories)) {
                Log::info("Exceptional Message::" . json_encode($providerCategories));
                // foreach ($providerCategories as $providerCategory) {
                //     $providerCategory = json_encode($providerCategory, true);
                //     $providerCategoriesArray = $providerCategoriesDto->getProviderCategoryDto($providerCategory['id'], $providerCategory['code'], $providerCategory['name']);
                //     $providerCategoriesDto->setAttributes($providerCategoriesArray);
                // }
                return Response()->json(["error" => false, "providerCategories" => $providerCategories], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providerCategories" => $providerCategoriesDto->getAttributes()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Get a listing of provider categories By Id.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getProviderCategoryById(Request $request, $providerCategoryId)
    {
        try {

            //Checking if provider category exists.
            $providerCategoryExists = $this->providerCategoryDao->getProviderCategoryById($providerCategoryId);

            $providerCategoryDto = new ProviderCategoryDto();
            //Checking if the object has data
            Log::info("OriginMessage:" . gettype($providerCategoryExists));
            if (!blank($providerCategoryExists)) {
                // Log::info("Exceptional Message::" . json_encode($providerCategoryExists));

                //Using the DTO to get and set object data properties.
                $providerCategoryArray = $providerCategoryDto->getProviderCategoryDto($providerCategoryExists->getProviderCategoryId(), $providerCategoryExists->getProviderCategoryCode(), $providerCategoryExists->getProviderCategoryName());

                //Now setting the provider categories array attributes.
                $providerCategoryDto->setAttributes($providerCategoryArray);

                return Response()->json(["error" => false, "providerCategories" => $providerCategoryDto->getAttributes()], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providerCategory" => ['No Data Found']], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $exception) {
            Log::info("Exceptional Message::" . $exception->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Create a provider category.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */
    public function createProviderCategory(Request $request)
    {
        try {
            $providerCategoryDto = new ProviderCategoryDto();
            $providerCategoryDto->setAttributes($request->all());

            //Validate whether such a category already esists using the name and code.
            $providerCategoryExists = $this->providerCategoryDao->getProviderCategoryByNameOrCode($providerCategoryDto->getProv_categ_code(), $providerCategoryDto->getProv_categ_name());
            Log::info("Log Message:" . json_encode($request->all()));
            if (blank($providerCategoryExists)) {
                $providerCategory = $this->providerCategoryDao->createProviderCategory($providerCategoryDto);
                if (!blank($providerCategory)) {
                    return Response()->json(["error" => false, 'message' => ['OK']], Response::HTTP_OK);
                }
                return Response()->json(["error" => false, 'message' => ['Failed to create provider category']], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, 'message' => ['Provider category already exists!']], Response::HTTP_OK);
        } catch (\Exception $e) {
            Log::info("Exceptional Message::" . $e->getMessage());
            return Response()->json(["error" => true, "message" => ['Failed! Something went wrong on our end!']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
