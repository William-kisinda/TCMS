<?php

namespace App\Http\Controllers\Client\UtilityProvider;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ManageUtilityProviderController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {

        $providers = [];

        try {
            // $response = Http::get('http://localhost:8000/api/utilityProviders');
            $providers = Http::get('http://localhost:8000/api/utilityProviders')['providers'];
            // $dataArray = json_decode($response->body(), true);
            // $providers = $dataArray['providers'];
            Log::info("Providers Message::" . $providers);

        } catch (\Exception $e) {
            // Log::info("UtilityProviderException:" . $e->getMessage());
            log::channel('daily')->info("UtilityProviderException:" . $e->getMessage());
        }

        return view('utility_provider.index', compact('providers'))
                ->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexApi()
    {
    }
}
