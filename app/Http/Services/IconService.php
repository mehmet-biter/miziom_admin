<?php

namespace App\Http\Services;
use Exception;
use App\Models\IconCategory;

class IconService
{
    public function __construct(){}

    public function createIconCategory($category)
    {
        try {
            if(! isset($category->title)) return responseData(false, __("Title is required"));

            $successResponse = responseData(true, __("Icon category created successfully"));
            $faildResponse = responseData(false, __("Icon category failed to create"));
            $successUpdateResponse = responseData(true, __("Icon category updated successfully"));
            $faildUpdateResponse = responseData(false, __("Icon category failed to updat"));

            $finder = [ 'id' => (isset($category->id) ? $category->id : 0)] ;

            $createData = [
                'title'  => $category->title,
                'status' => isset($category->status)
            ];

            if(IconCategory::updateOrCreate($finder, $createData))
            {
                if(isset($category->id)) return $successUpdateResponse;
                return $successResponse;
            }

            if(isset($category->id)) return $faildUpdateResponse;
            return $faildResponse;

        } catch (Exception $e) {
            storeException("createIconCategory", $e->getMessage());
            return responseData(false, __("Something went wrong!"));
        }
    }

    public function deleteIconCategory($id)
    {
        try {
            if($category = IconCategory::find($id))
            {
                if($category->delete()) return responseData(true, __("Icon category deleted successfully"));
                return responseData(false, __("Icon category falied delete!"));
            }
            return responseData(false, __("Icon category not found!"));
        } catch (Exception $e) {
            storeException("deleteIconCategory", $e->getMessage());
            return responseData(false, __("Someting went wrong!"));
        }
    }

    public function changeIconCategoryStatus($id)
    {
        try {
            if($category = IconCategory::find($id))
            {
                if($category->update(['status' => !$category->status])) 
                    return responseData(true, __("Icon category status updated successfully"));
                return responseData(false, __("Icon category falied change status!"));
            }
            return responseData(false, __("Icon category not found!"));
        } catch (Exception $e) {
            storeException("deleteIconCategory", $e->getMessage());
            return responseData(false, __("Someting went wrong!"));
        }
    }
}
