<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Services\WalletService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new WalletService();
    }

    //coin list
    public function coinList($type){
        try {
            $response = $this->service->coinList($type);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('coinList',$e->getMessage());
            return responseJsonData(false);
        }
    }

    //coin list
    public function walletList(Request $request,$type){
        try {
            $currency = $request->header('currency') ?? 'NGN';
            $response = $this->service->userWalletList(Auth::id(),$type,$currency);
            return responseJsonData($response['success'],$response['message'],$response['data']);
        } catch(\Exception $e) {
            storeException('walletList',$e->getMessage());
            return responseJsonData(false);
        }
    }

    // update profile
    // public function updateProfile(ProfileUpdateRequest $request) {
    //     try {
    //         $response = $this->service->userProfileUpdate($request,Auth::id());
    //         return responseJsonData($response['success'],$response['message'],$response['data']);
    //     } catch(\Exception $e) {
    //         storeException('profile update ex', $e->getMessage());
    //         return responseJsonData(false);
    //     }
    // }

    public function searcheCustomer(Request $request)
    {
        return response()->json(
            $this->service->searcheCustomer($request)
        );
    }

    public function walletWithdrawal(Request $request)
    {
        return response()->json(
            $this->service->walletWithdrawal($request)
        );
    }

    public function walletDeposit(Request $request)
    {
        $currency = $request->header('currency') ?? 'NGN';
        return response()->json(
            $this->service->walletDeposit($request, $currency)
        );
    }
   
}
