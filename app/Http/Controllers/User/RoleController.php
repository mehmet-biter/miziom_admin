<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RoleAddRequest;
use App\Http\Services\RoleService;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new RoleService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */

     public function index(Request $request)
     {
         try {
             $data['title'] = __('Role');
             if($request->ajax()) {
                 $list = Role::select('*');
                 return datatables($list)
                     
                     ->addColumn('created_at', function ($item) use($request) {
                         return $item->created_at;
                     })
                     ->addColumn('status', function ($item) use($request) {
                         return status($item->status);
                     })
                     ->addColumn('actions', function ($item) use ($request) {
                         
                         $html = '<div class="flex gap-4 items-center">';
                         $html .= edit_html('roleEdit',$item->unique_code);
                         $html .= delete_html('roleDelete',$item->unique_code);
                         $html .= '</div>';
                         
                         return $html;
                     })
                     ->rawColumns(['actions','status'])
                     ->make(true);
             }
 
             return view('user.role.index', $data);
         } catch(\Exception $e) {
             storeException('role index ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
      */
     public function create() {
         try {
             $data['title'] = __('Add New Role');
             return view('user.role.add',$data);
         } catch(\Exception $e) {
             storeException('role create ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Show the form for editing the specified resource.
      *
      * @param id
      * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
      */
     public function edit($id) {
         try {
             $data['title'] = __('Update Role');
             $data['item'] = $this->service->whereFirst(['unique_code' => $id]);
             if ($data['item']) {
                 return view('user.role.add',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('role edit ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Show the  specified resource.
      *
      * @param id
      * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
      */
     public function preview($id) {
         try {
             $data['title'] = __('Preview Role');
             $data['item'] = $this->service->whereFirst(['unique_code' => $id]);
             if ($data['item']) {
                 return view('user.role.preview',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('role preview ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Destroy the  specified resource.
      *
      * @param id
      * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
      */
     public function destroy($id) {
         try {
             $response = $this->service->deleteData($id);
             if ($response['success']) {
                 return back()->with('success', $response['message']);
             } else {
                 return redirect()->back()->with('dismiss', $response['message']);
             }
         } catch(\Exception $e) {
             storeException('faq delete ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
      */
     public function store(RoleAddRequest $request) {
         try {
             $response = $this->service->saveItemData($request);
             if($response['success']) {
                 return redirect()->route('roleList')->with('success',$response['message']);
             } else {
                 return redirect()->back()->withInput()->with('dismiss',$response['message']);
             }
         } catch(\Exception $e) {
             storeException('role store ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
}
