<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Dao;

use App\Models\ProviderCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Tcms\ProviderCategory\Dao\ProviderCategoryDao;
use App\Http\Controllers\Tcms\ProviderCategory\Dto\ProviderCategoryDto;

/**
 * This Class Controls Product Category Datastore
 * @author Daniel MM.
 * Email:danielmathew460@gmail.com
 * 01/09/2023
 *
 */

class ProviderCategoryDaoImpl implements ProviderCategoryDao
{

    /**
     * @param null
     * @return ProviderCategory|null
     * @author Daniel MM
     */
    public function getProviderCategories()
    {
        $providerCategory = null;
        try {
            $providerCategoriesInfo = DB::table('provider_categories')->get();
            if (!blank($providerCategoriesInfo)) {

                $providerCategoriesInfoArray = json_decode(json_encode($providerCategoriesInfo), true);

                // foreach ($providerCategoriesInfoArray as $prodCategInfo) {
                # code...
                $providerCategory = new ProviderCategory();
                $providerCategory->setAttributes($providerCategoriesInfoArray);

                // array_push($providerCategoryArray, $providerCategory);
                // }
            }
        } catch (\Exception $exception) {
            Log::error("ProductCategoryException", $exception->getMessage());
        }
        return $providerCategory;
    }

    /**
     * @param $providerCategoryId
     * @return ProviderCategory|null
     * @author Daniel MM
     */

    public function getProviderCategoryById($providerCategoryId)
    {
        $providerCategory = null;

        try {
            $providerCategoryInfoExists = DB::table('provider_categories')->where('id', '=', $providerCategoryId)->get();
            if (!blank($providerCategoryInfoExists)) {
                $providerCategoryInfoArray = json_decode(json_encode($providerCategoryInfoExists), true);
                $providerCategory = new ProviderCategory();
                $providerCategory->setAttributes($providerCategoryInfoArray[0]);
            }
            //throw $th;
        } catch (\Exception $e) {
            Log::error("ProductCategoryException", $e->getMessage());
        }
        return $providerCategory;
    }

    /**
     * @param ProviderCategoryDto $providerCategoryDto
     * @return ProviderCategory|null
     * @author Daniel MM
     */

   /*  old code that return error of fail to create new category provider
   public function getProviderCategoryByNameOrCode($providerCategoryName, $providerCategoryCode)
    {
        $providerCategory = null;
        try {

            $providerCategory = new ProviderCategory();

           $sql = "SELECT * FROM \"provider_categories\" WHERE \"code\"='" . $providerCategoryCode . "' OR \"name\"='" . $providerCategoryName . "'";
           $expression = DB::raw($sql);
           $stringSQL = $expression->getValue(DB::connection()->getQueryGrammar());
            $providerCategoryExistInfo =  DB::select($stringSQL);
            if (!blank($providerCategoryExistInfo)) {
                $providerCategoryInfoArray = json_decode(json_encode($providerCategoryExistInfo), true);
                $providerCategory->setAttributes($providerCategoryInfoArray);
            }
        } catch (\Exception $exception) {
            Log::error('ProductCategoryException:' . $exception->getMessage());
        }
        return $providerCategory;
    }*/
    public function getProviderCategoryByNameOrCode($providerCategoryName, $providerCategoryCode)
{
    $providerCategory = null;

    try {
        $providerCategoryExistInfo = DB::table('provider_categories')
            ->where('code', $providerCategoryCode)
            ->orWhere('name', $providerCategoryName)
            ->first(); // Use first() to get a single result

        if (!is_null($providerCategoryExistInfo)) {
            // Data exists, you can access it directly
            $providerCategory = new ProviderCategory();
            $providerCategory->setAttributes((array) $providerCategoryExistInfo);
        }
    } catch (\Exception $exception) {
        Log::error('ProductCategoryException:' . $exception->getMessage());
    }

    return $providerCategory;
}


    /**
     * @param ProviderCategoryDto $providerCategoryDto
     * @return ProviderCategory|null
     * @author Daniel MM
     */

    public function createProviderCategory(ProviderCategoryDto $providerCategoryDto)
    {
        $providerCategoryModel = null;
        try {
            $providerCategoryModel = new ProviderCategory();

            $providerCategoryModel->setProviderCategoryCode($providerCategoryDto->getProv_categ_code());
            $providerCategoryModel->setProviderCategoryName($providerCategoryDto->getProv_categ_name());

            $providerCategoryModel->save();
        } catch (\Exception $e) {
            Log::error("ProductCategoryException", $e->getMessage());
        }
        return $providerCategoryModel;
    }
}
