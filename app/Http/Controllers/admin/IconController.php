<?php

namespace App\Http\Controllers\admin;

use App\Models\IconList;
use App\Models\IconCategory;
use Illuminate\Http\Request;
use App\Http\Services\IconService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\IconSaveRequest;

class IconController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new IconService;
    }

    public function iconCategoryPage(Request $request)
    {
        if($request->wantsJson()){
            $icon = IconCategory::query();
            return datatables()->of($icon)
            ->editColumn('status', function($item){
                return activationStatus($item->status);
            })
            ->editColumn('created_at', function($item){
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })
            ->editColumn('status', function($item){
                return $html = '
                    <div>
                        <label class="w-12 h-6 relative">
                            <input onclick="return processForm(' . $item->id .')" type="checkbox"
                                class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                id="custom_switch_checkbox4"
                                '. (($item->status == STATUS_ACTIVE) ?'checked':'') .'/>
                            <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                        </label>
                    </div>
                ';
            })
            ->addColumn('actions', function($item){
                $html = '<div class="flex gap-4 items-center">';
                $html .= edit_html('iconCategoryAddEdit',$item->id);
                $html .= delete_html('iconCategoryDelete',$item->id);
                $html .= '</div>';
                
                return $html;
            })
            ->rawColumns(['actions','status'])
            ->make(TRUE);
        }
        $data['title'] = __("Icon Category");
        return view('icon.categories.index', $data);
    }

    public function iconCategoryAddEdit($id = null)
    {
        $data['title'] = __("Icon Category");
        if($id) {
            $data['title'] = __("Update Icon Category");
            $data['item'] = IconCategory::find($id);
        }
        return view('icon.categories.addEdit', $data);
    }

    public function iconCategoryAddEditProccess(Request $request)
    {
        $rseponse = $this->service->createIconCategory($request); 
        if(isset($rseponse['success']) && $rseponse['success'])
            return redirect()->route('iconCategoryPage')->with('success', $rseponse['message']);
        return redirect()->back()->with('dismiss', $rseponse['message'] ?? __("Update failed"));
    }

    public function iconCategoryDelete($id)
    {
        $rseponse = $this->service->deleteIconCategory($id);
        if(isset($rseponse['success']) && $rseponse['success'])
            return redirect()->route('iconCategoryPage')->with('success', $rseponse['message']);
        return redirect()->back()->with('dismiss', $rseponse['message'] ?? __("Delete failed"));
    }

    public function iconCategoryStatusUpdate(Request $request)
    {
        if(!isset($request->id)) 
            return response()->json(responseData(false, __("Id is missing")));

        return response()->json(
            $this->service->changeIconCategoryStatus($request->id)
        ); 
    }


    // icon list
    public function iconPage(Request $request)
    {
        if($request->wantsJson()){
            $icon = IconList::with('category');
            return datatables()->of($icon)
            ->editColumn('status', function($item){
                return activationStatus($item->status);
            })
            ->addColumn('category', function($item){
                return $item?->category?->title;
            })
            ->editColumn('created_at', function($item){
                return date('Y-m-d H:i:s', strtotime($item->created_at));
            })
            ->editColumn('status', function($item){
                return $html = '
                    <div>
                        <label class="w-12 h-6 relative">
                            <input onclick="return processForm(' . $item->id .')" type="checkbox"
                                class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                id="custom_switch_checkbox4"
                                '. (($item->status == STATUS_ACTIVE) ?'checked':'') .'/>
                            <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                        </label>
                    </div>
                ';
            })
            ->addColumn('actions', function($item){
                $html = '<div class="flex gap-4 items-center">';
                $html .= edit_html('iconAddEdit',$item->id);
                $html .= delete_html('iconDelete',$item->id);
                $html .= '</div>';
                
                return $html;
            })
            ->rawColumns(['actions','status'])
            ->make(TRUE);
        }
        $data['title'] = __("Icon Category");
        return view('icon.index', $data);
    }

    public function iconAddEdit($id = null)
    {
        $data['title'] = __("Icon Category");
        if($id) {
            $data['title'] = __("Update Icon Category");
            $data['item'] = IconList::find($id);
        }
        $data['categories'] = IconCategory::get();
        return view('icon.addEdit', $data);
    }

    public function iconAddEditProccess(IconSaveRequest $request)
    {
        $rseponse = $this->service->createIcon($request); 
        if(isset($rseponse['success']) && $rseponse['success'])
            return redirect()->route('iconPage')->with('success', $rseponse['message']);
        return redirect()->back()->with('dismiss', $rseponse['message'] ?? __("Update failed"));
    }

    public function iconDelete($id)
    {
        $rseponse = $this->service->deleteIcon($id);
        if(isset($rseponse['success']) && $rseponse['success'])
            return redirect()->route('iconPage')->with('success', $rseponse['message']);
        return redirect()->back()->with('dismiss', $rseponse['message'] ?? __("Delete failed"));
    }

    public function iconStatusUpdate(Request $request)
    {
        if(!isset($request->id)) 
            return response()->json(responseData(false, __("Id is missing")));

        return response()->json(
            $this->service->changeIconStatus($request->id)
        ); 
    }
}
