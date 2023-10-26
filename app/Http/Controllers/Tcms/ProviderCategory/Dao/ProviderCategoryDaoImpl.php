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
    private $providerCategory;

    public function __construct(ProviderCategory $providerCategory) {
        $this->providerCategory = $providerCategory;
    }

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


                $this->providerCategory->setAttributes($providerCategoriesInfoArray);
            }
        } catch (\Exception $exception) {
            Log::error("ProviderCategoryException", $exception->getMessage());
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
                $this->providerCategory->setAttributes($providerCategoryInfoArray[0]);
            }
            //throw $th;
        } catch (\Exception $e) {
            Log::error("ProviderCategoryException", $e->getMessage());
        }
        return $providerCategory;
    }

    /**
     * @param ProviderCategoryDto $providerCategoryDto
     * @return ProviderCategory|null
     * @author Daniel MM
     */

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
                $this->providerCategory->setAttributes((array) $providerCategoryExistInfo);
            }
        } catch (\Exception $exception) {
            Log::error('ProviderCategoryException:' . $exception->getMessage());
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

            $this->providerCategory->setProviderCategoryCode($providerCategoryDto->getProv_categ_code());
            $this->providerCategory->setProviderCategoryName($providerCategoryDto->getProv_categ_name());

            $this->providerCategory->save();
        } catch (\Exception $e) {
            Log::error("ProviderCategoryException", $e->getMessage());
        }
        return $providerCategoryModel;
    }
}
