<?php

namespace App\Http\Controllers\admin;

use App\Models\CustomPage;
use App\Models\AdminSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class LandingController extends Controller
{
    private $landingService;
    public function __construct(){
        // $this->landingService = 
    }

    public function adminCustomPage()
    {
        $data['title'] = __("Custom Page");
        $data['pages'] = CustomPage::get();
        return view('custom_pages.pages', $data);
    }

    public function adminCustomPageAdd()
    {
        return view('custom_pages.add_page');
    }
 
    public function adminCustomPageEdit($id)
    {
        if($page = CustomPage::find($id)){
            $data['item'] = $page;
            return view('custom_pages.add_page', $data);
        }
        return redirect()->back()->withInput()->with(['dismiss' => __("Custom page not found!")]);
    }

    public function adminCustomPageSave(Request $request)
    {
        try {
            $rules = [
                'title' => 'required|max:255',
                'body' => 'required',
            ];

            $messages = [
                'title.required' => __('Title Can\'t be empty!'),
                'body.required' => __('Description Can\'t be empty!'),
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors[0];

                return redirect()->back()->withInput()->with(['dismiss' => $data['message']]);
            }
            $id = $request->edit_id ?? 0;
            $custom_page = [
                'title'  => $request->title,
                'slug'   => make_unique_slug($request->title),
                'body'   => $request->body,
                'status' => isset($request->status)
            ];
            CustomPage::updateOrCreate(['id' => $id], $custom_page);

            if ($request->edit_id) {
                $message = __('Custom page updated successfully');
            } else {
                $message = __('Custom Page created successfully');
            }

            return redirect()->route('adminCustomPage')->with(['success' => $message]);
        } catch (\Exception $e) {
            storeException('adminCustomPageSave', $e->getMessage());
            return redirect()->back()->with(['dismiss' => __('Something went wrong')]);
        }
    }

    public function customPagesDelete($id)
    {
         try{
            $responseErr =  __('Custom page deleted failed');
            $responseSuc =  __('Custom page deleted Successful');
            $data = CustomPage::where(['id' => $id])->delete();
            if($data) return redirect()->route('adminCustomPage')->with('success', $responseSuc);
            return redirect()->back()->with('dismiss', $responseErr);
         } catch (\Exception $e) {
             storeException('CustomPagesDeleteProcess',$e->getMessage());
             return redirect()->back()->with('dismiss', __("Something went wrong"));
         }
    }

    public function adminPageStatus(Request $request)
    {
        $page = CustomPage::find($request->id);
        if ($page) {
            if ($page->status == STATUS_ACTIVE) {
               $page->update(['status' => STATUS_DEACTIVE]);
            } else {
                $page->update(['status' => STATUS_ACTIVE]);
            }
            return response()->json(['message'=>__('Custom page status changed successfully')]);
        } else {
            return response()->json(['message'=>__('Custom page not found')]);
        }
    }

    public function landingHeroPageSetting()
    {
        $setting = allsetting(['HERO_SECTION_COVER_IMAGE', 'HERO_SECTION_DESCRIPTION', 'HERO_SECTION_SECOND_HEADER', 'HERO_SECTION_HEADER']);
        $data['setting'] = $setting;
        return view('landing.section-1', $data);
    }
    public function landingHeroPageSettingSave(Request $request)
    {
        try {
            $rules = [
                'header' => 'required|max:255',
                'description' => 'required',
                'second_header' => 'required',
            ];

            $messages = [
                'header.required' => __('Header Can\'t be empty!'),
                'description.required' => __('Description Can\'t be empty!'),
                'second_header.required' => __('Second header Can\'t be empty!'),
            ];
            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {
                $errors = [];
                $e = $validator->errors()->all();
                foreach ($e as $error) {
                    $errors[] = $error;
                }
                $data['message'] = $errors[0];

                return redirect()->back()->withInput()->with(['dismiss' => $data['message']]);
            }

            AdminSetting::updateOrCreate(['slug' => 'HERO_SECTION_HEADER'], ['value' => $request->header]);
            AdminSetting::updateOrCreate(['slug' => 'HERO_SECTION_SECOND_HEADER'], ['value' => $request->second_header]);
            AdminSetting::updateOrCreate(['slug' => 'HERO_SECTION_DESCRIPTION'], ['value' => $request->description]);

            if ($request->hasFile("cover_image")) {
                $image = uploadImage($request->cover_image, IMG_PATH, isset(allsetting()["HERO_SECTION_COVER_IMAGE"]) ? allsetting()["HERO_SECTION_COVER_IMAGE"] : '');
                AdminSetting::updateOrCreate(['slug' => "HERO_SECTION_COVER_IMAGE"], ['value' => $image]);
            } 
            return redirect()->route('landingHeroPageSetting')->with(['success' => __('Section one updated successfully')]);
        } catch (\Exception $e) {
            storeException('landingHeroPageSetting', $e->getMessage());
            return redirect()->back()->with(['dismiss' => __('Something went wrong')]);
        }
    }
}
