<?php

namespace App\Http\Controllers\Tcms\Partners\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Tcms\Partners\Dao\PartnersDaoImp;

/**
 * This Class Controls Meter validation API
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

class PartnersApi extends Controller
{
    private $partnerDao;

    public function __construct(PartnersDaoImp $partnerDao)
    {
        $this->partnerDao = $partnerDao;
    }


/**
 * This is the method for validating meter Number
 * @author Julius.
 * Email: juliusstephen1@gmail.com
 *
 */

    public function registerPartner(Request $request)
    {
        try {
             //Validate received Inputs
             $validatedInputs = $request->validate([
                'name' => ['required','string','max:255'],
                'code' => ['required','alpha_num:ascii'],
             ]);

            //save the Partner Information to the database.
            $this->partnerDao->createPartner($validatedInputs);

                //Log send Response information
             Log::info("\nNew partner is successful saved with the following information : ".json_encode($validatedInputs));

            return response()->json(["error" => false, "Meter Information" => $validatedInputs], Response::HTTP_OK);
        }
        catch (\Illuminate\Validation\ValidationException $e) {
            // If validation fails, Laravel throws a ValidationException. Errors can be retrieved as follows
            $validationErrors = $e->validator->errors()->all();
                //Log Response Error
            Log::error("\nNew partner failed to be added with the Error: ".json_encode($validationErrors));
            return response()->json(["error" => true, "message" => $validationErrors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }catch (\Exception $exception) {
            //Log Response Error
            Log::error("\nSuccessful send the user following information : ".json_encode($exception->getMessage()));
            return response()->json(["error" => true, "message" =>  json_encode($exception->getMessage())], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
