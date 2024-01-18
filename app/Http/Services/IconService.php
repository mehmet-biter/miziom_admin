<?php

namespace App\Http\Services;
use Exception;
use App\Models\IconList;
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

    public function createIcon($icon)
    {
        try {
            $successResponse = responseData(true, __("Icon created successfully"));
            $faildResponse = responseData(false, __("Icon failed to create"));
            $successUpdateResponse = responseData(true, __("Icon updated successfully"));
            $faildUpdateResponse = responseData(false, __("Icon failed to updat"));

            $finder = [ 'id' => (isset($icon->id) ? $icon->id : 0)] ;
        
            $createData = [
                'title'       => $icon->title,
                'tag'         => $icon->tag,
                'category_id' => $icon->category_id,
                'status'      => isset($icon->status),
            ];

            if($icon->hasFile('icon')){
                $icon_name = '';
                if(isset($icon->id)){
                    if($iconData = IconList::find($icon->id)){
                        if(!empty($iconData->icon)) $icon_name = uploadImage($icon->icon, IMG_PATH, $iconData->icon);
                        else $icon_name = uploadImage($icon->icon, IMG_PATH);
                    }
                }else{
                    $icon_name = uploadImage($icon->icon, IMG_PATH);
                }
                $createData['icon'] = $icon_name;
            }

            if(IconList::updateOrCreate($finder, $createData))
            {
                if(isset($icon->id)) return $successUpdateResponse;
                return $successResponse;
            }

            if(isset($icon->id)) return $faildUpdateResponse;
            return $faildResponse;

        } catch (Exception $e) {
            storeException("createIconCategory", $e->getMessage());
            return responseData(false, __("Something went wrong!"));
        }
    }

    public function deleteIcon($id)
    {
        try {
            if($icon = IconList::find($id))
            {
                $iconImage = $icon->icon;
                if($icon->delete()) {
                    $deleteIcon = uploadImage('', IMG_PATH, $iconImage);
                    return responseData(true, __("Icon deleted successfully"));
                }
                return responseData(false, __("Icon falied delete!"));
            }
            return responseData(false, __("Icon not found!"));
        } catch (Exception $e) {
            storeException("deleteIcon", $e->getMessage());
            return responseData(false, __("Someting went wrong!"));
        }
    }

    public function changeIconStatus($id)
    {
        try {
            if($icon = IconList::find($id))
            {
                if($icon->update(['status' => !$icon->status])) 
                    return responseData(true, __("Icon status updated successfully"));
                return responseData(false, __("Icon falied change status!"));
            }
            return responseData(false, __("Icon not found!"));
        } catch (Exception $e) {
            storeException("deleteIcon", $e->getMessage());
            return responseData(false, __("Someting went wrong!"));
        }
    }
}
