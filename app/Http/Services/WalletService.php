<?php

namespace App\Http\Services;

use App\Http\Repository\WalletRepository;
use App\Models\Coin;

class WalletService extends BaseService
{
    public $repository;
    public function __construct()
    {
        $this->repository =  new WalletRepository();
        parent::__construct($this->repository);

    }

    // coin data
   public function coinList($type) {
        try {
            if($type == CURRENCY_TYPE_BOTH) {
                $items = Coin::where(['status' => STATUS_ACTIVE])->get();
            } else {
                $items = Coin::where(['status' => STATUS_ACTIVE, 'currency_type' => $type])->get();
            }
            if (isset($items[0])) {
                return responseData(true, __('Data get successfully'),$items);
            } else {
                return responseData(false, __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('coin list ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

     // user wallet list
   public function userWalletList($userId,$type,$currency) {
     try {
            createUserWallet($userId);
            $items = $this->repository->getUserWalletList($userId,$type,$currency);
            if (isset($items[0])) {
                return responseData(true, __('Data get successfully'),$items);
            } else {
                return responseData(false, __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('userWalletList ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
    }

// save data
public function saveItemData($request)
{
    $response = responseData(false);
    try {
        $item='';
        if($request->edit_id) {
            $data = $request->except(['_token', 'edit_id','actions']);
            $item = $this->repository->whereFirst(['unique_code' => $request->edit_id]);
            if(empty($item)) {
                return responseData(false,__('Data not found'));
            }
        } else {
            $data = $request->except(['_token','actions']);
            $data['unique_code'] = makeUniqueId();
        }
        if(isset($request->actions[0])){
            $data['actions'] = implode('|', $request->actions);
        } else {
            return responseData(false,__('Must be select atleast one role'));
        }
        if($request->edit_id) {
            $this->repository->update(['id' => $item->id], $data);
            $response = responseData(true,__('Role updated successfully'));
        } else {
            $this->repository->create($data);
            $response = responseData(true,__('New role added successfully'));
        }
    } catch (\Exception $e) {
        
        storeException('save role', $e->getMessage());
    }
    return $response;
}

}
