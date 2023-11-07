<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Api;

use App\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\ProviderCategory\Dao\ProviderCategoryDaoImpl;
use App\Http\Controllers\Tcms\ProviderCategory\Dto\ProviderCategoryDto;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ProviderCategoryApi extends Controller
{
    private $providerCategoryDao;
    private $providerCategoriesDto;

    public function __construct(ProviderCategoryDaoImpl $providerCategory, ProviderCategoryDto $providerCategoriesDto)
    {
        $this->providerCategoryDao = $providerCategory;
        $this->providerCategoriesDto = $providerCategoriesDto;
    }

    /**
     * Display a listing of provider categories.
     *
     * @param null
     * @return \Illuminate\Http\JsonResponse
     */

    public function getProviderCategories(Request $request)
    {
        //Validate roles and request information like headers and auth tokens.
        try {
            $providerCategories = $this->providerCategoryDao->getProviderCategories();

            Log::info("ProviderCategory" . json_encode($providerCategories));
            //Checking if the object has data
            if (!blank($providerCategories)) {
                Log::info("All Providers Message::" . json_encode($providerCategories));
                return Response()->json(["error" => false, "providerCategories" => $providerCategories], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providerCategories" => $this->providerCategoriesDto->getAttributes()], Response::HTTP_BAD_REQUEST);
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

    public function getProviderCategoryById(Request $request)
    {
        try {

            $providerCategoryId = $request->input('providerCategoryId');

            //Checking if provider category exists.
            $providerCategoryExists = $this->providerCategoryDao->getProviderCategoryById($providerCategoryId);

            //Checking if the object has data
            Log::info("OriginMessage:" . gettype($providerCategoryExists));
            if (!blank($providerCategoryExists)) {
                // Log::info("Exceptional Message::" . json_encode($providerCategoryExists));

                //Using the DTO to get and set object data properties.
                $providerCategoryArray = $this->providerCategoriesDto->getProviderCategoryDto($providerCategoryExists->getProviderCategoryId(), $providerCategoryExists->getProviderCategoryCode(), $providerCategoryExists->getProviderCategoryName());

                //Now setting the provider categories array attributes.
                $this->providerCategoriesDto->setAttributes($providerCategoryArray);

                return Response()->json(["error" => false, "providerCategory" => $this->providerCategoriesDto->getAttributes()], Response::HTTP_OK);
            }
            return Response()->json(["error" => false, "providerCategory" => $this->providerCategoriesDto->getAttributes()], Response::HTTP_BAD_REQUEST);
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
            //take all the inputs and store them.
            $inputs = $request->all();

            //generate code as per the context name
            $helper = app(Helpers::class);
            $prov_categ_code = $helper->generateCode($inputs['prov_categ_name']);
            $inputs = array_merge($inputs, ['prov_categ_code' => $prov_categ_code]);

            //Transfer into DTO
            $this->providerCategoriesDto->setAttributes($inputs);

            //Validate whether such a category already esists using the name and code.
            $providerCategoryExists = $this->providerCategoryDao->getProviderCategoryByNameOrCode($this->providerCategoriesDto->getProv_categ_name(), $this->providerCategoriesDto->getProv_categ_code());
            if (blank($providerCategoryExists)) {
                $providerCategory = $this->providerCategoryDao->createProviderCategory($this->providerCategoriesDto);
                if (!blank($providerCategory->getAttributes())) {
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
