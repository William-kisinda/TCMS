<?php

namespace App\Http\Controllers\Tcms\ProviderCategory\Dao;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Tcms\ProviderCategory\Dto\ProductCategoryDto;
use App\Http\Controllers\Tcms\ProviderCategory\Dao\ProviderCategoryDao;
use App\Models\ProviderCategory;
use Illuminate\Support\Facades\Log;

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
        $providerCategoryArray = [];
        try {
            $sql = "SELECT * FROM \"provider_categories\"";
            $providerCategoriesInfo = DB::table('provider_categories')->get();
            if (!blank($providerCategoriesInfo)) {

                $providerCategoriesInfoArray = json_decode(json_encode($providerCategoriesInfo));

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
}
