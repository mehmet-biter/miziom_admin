<?php

namespace App\Http\Controllers\admin;

use App\Models\CurrencyList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\CurrencyService;
use App\Http\Requests\Admin\CurrencyRequest;

class CurrencyController extends Controller
{
    private $service;
    function __construct()
    {
        $this->service = new CurrencyService();
    }
    public function adminCurrencyList()
    {
        $data['title'] = __('Fiat Currency List');
        $data['items'] = CurrencyList::get();

        return view('currency.list', $data);
    }

    public function adminCurrencyAdd(){
        $data['title'] = __('Fiat Currency Add');
        return view('currency.addEdit',$data);
    }

    public function adminCurrencyAddEdit(CurrencyRequest $request)
    {
        $response = $this->service->currencyAddEdit($request);
        if($response["success"]) return redirect()->route("adminCurrencyList")->with("success",$response["message"]);
        return redirect()->route("adminCurrencyList")->with("dismiss",$response["message"]);
    }

    public function adminCurrencyEdit($id){
        $data['title'] = __('Fiat Currency Edit');
        $data['item'] = CurrencyList::find($id);
        return view('currency.addEdit',$data);
    }

    public function adminCurrencyStatus(Request $request){
        return response()->json(
            $this->service->currencyStatusUpdate($request->active_id ?? 0)
        );
    }

    public function adminAllCurrency(Request $request){
        $this->service->saveAllCurrency();
        return response()->json(["status" => true]);
    }

    public function adminCurrencyRate(){
        try {
            $this->service->currencyRateSave();
            $response = $this->service->response;
            if($response["success"]) return redirect()->route("adminCurrencyList")->with("success",$response["message"]);
            return redirect()->route("adminCurrencyList")->with("dismiss",$response["message"]);
        } catch(\Exception $e) {
            storeException('adminCurrencyRate ex', $e->getMessage());
            return redirect()->route("adminCurrencyList")->with("dismiss",__('Currency api key is not valid'));
        }

    }
}
