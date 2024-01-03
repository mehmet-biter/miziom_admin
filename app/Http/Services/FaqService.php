<?php

namespace App\Http\Services;

use App\Models\Faq;
use App\Http\Repository\FaqRepository;

class FaqService extends BaseService
{
    public $repository;
    public function __construct()
    {
        $this->repository =  new FaqRepository();
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
        storeException('delete team ex', $e->getMessage());
        return responseData(false, __('Something went wrong'));
    }
    
}

// save data
public function saveItemData($request, $user)
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
            $data = $request->except(['_token', 'image']);
            $data['unique_code'] = makeUniqueId();
            $data['author'] = $user->id;
        }

        if($request->edit_id) {
            $this->repository->update(['id' => $item->id], $data);
            $response = responseData(true,__('FAQ updated successfully'));
        } else {
            $this->repository->create($data);
            $response = responseData(true,__('New FAQ added successfully'));
        }
    } catch (\Exception $e) {
        storeException('save faq', $e->getMessage());
    }
    return $response;
}

    public function getFaqApi($request)
    {
        try{

            $faqList = Faq::where('status', STATUS_ACTIVE)
                // ->when(isset($request->faq_type_id),function($query)use($request){
                //     $query->Where('faq_type_id',$request->faq_type_id);
                // })
                ->orderBy('id', 'DESC')->paginate($request->per_page ?? 200);

            if(isset($faqList[0])) return responseData(true, __("FAQ get successfully"), $faqList);
            return responseData(false, __("FAQ not found"));
        } catch(\Exception $e){
            storeException('faq api', $e->getMessage());
            return responseData(false, __("Something went wrong!"));
        }
    }

}
