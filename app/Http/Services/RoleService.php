<?php

namespace App\Http\Services;

use App\Http\Repository\RoleRepository;
use App\Models\User;

class RoleService extends BaseService
{
    public $repository;
    public function __construct()
    {
        $this->repository =  new RoleRepository();
        parent::__construct($this->repository);

    }

    // delete data
   public function deleteData($id) {
    try {
        $item = $this->repository->whereFirst(['unique_code' => $id]);
        if ($item) {
            $checkRole = User::where(['role' => $item->id])->first();
            if ($checkRole) {
                return responseData(true, __('This role is assigned at user, it should not delete'));
            }
            $delete = $this->repository->fullDelete($item->id);
            return responseData(true, __('Data deleted successfully'));
        } else {
            return responseData(false, __('Data not found'));
        }
    } catch(\Exception $e) {
        storeException('delete team ex', $e->getMessage());
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
