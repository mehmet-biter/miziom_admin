<?php

namespace App\Http\Services;

use App\Http\Repository\ContactRepository;

class ContactService extends BaseService
{
    public $repository;
    public function __construct()
    {
        $this->repository =  new ContactRepository();
        parent::__construct($this->repository);

    }

    // delete data
    public function deleteData($id) {
        try {
            $item = $this->repository->whereFirst(['unique_code' => $id]);
            if ($item) {
                $delete = $this->repository->fullDelete($item->id);
                return responseData(true, __('Data deleted successfully'));
            } else {
                return responseData(false, __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('delete service ex', $e->getMessage());
            return responseData(false, __('Something went wrong'));
        }
        
    }

    // save data
    public function saveItemData($request)
    {
        $response = responseData(false);
        try {
            $item='';
            $oldImg = '';
            if($request->edit_id) {
                $data = $request->except(['_token', 'edit_id']);
                $item = $this->repository->whereFirst(['unique_code' => $request->edit_id]);
                if(empty($item)) {
                    return responseData(false,__('Data not found'));
                }
                
            } else {
                $data = $request->except(['_token']);
                $data['unique_code'] = makeUniqueId();
            }

            if($request->edit_id) {
                $this->repository->update(['id' => $item->id], $data);
                $response = responseData(true,__('Message updated successfully'));
            } else {
                $this->repository->create($data);
                $response = responseData(true,__('Mail sent successfully'));
            }
        } catch (\Exception $e) {
            storeException('save contact', $e->getMessage());
        }
        return $response;
    }

}
