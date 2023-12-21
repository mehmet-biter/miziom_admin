<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UserAddRequest;
use App\Http\Services\UserService;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new UserService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */

     public function index(Request $request)
     {
         try {
             $data['title'] = __('Admin List');
             if($request->ajax()) {
                 $list = User::where('role_module','<>',ROLE_SUPER_ADMIN)->where('id','<>',Auth::id());
                 return datatables($list)
                 ->addColumn('name', function ($item) use($request) {
                    return $item->name;
                })
                     ->addColumn('created_at', function ($item) use($request) {
                         return $item->created_at;
                     })
                     ->addColumn('role', function ($item) use($request) {
                        return isset($item->roles) ? $item->roles->title : 'N/A' ;
                    })
                     ->addColumn('status', function ($item) use($request) {
                         return status($item->status);
                     })
                     ->addColumn('actions', function ($item) use ($request) {
                         
                         $html = '<div class="flex gap-4 items-center">';
                         $html .= edit_html('adminEdit',$item->unique_code);
                         $html .= delete_html('adminDelete',$item->unique_code);
                         $html .= '</div>';
                         
                         return $html;
                     })
                     ->rawColumns(['actions','status'])
                     ->make(true);
             }
 
             return view('user.user.index', $data);
         } catch(\Exception $e) {
             storeException('user index ex', $e->getMessage());
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
             $data['title'] = __('Add New Admin');
             $data['roles'] = Role::where(['status' => STATUS_ACTIVE])->get();
             return view('user.user.add',$data);
         } catch(\Exception $e) {
             storeException('user create ex', $e->getMessage());
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
             $data['title'] = __('Update Admin');
             $data['roles'] = Role::where(['status' => STATUS_ACTIVE])->get();
             $data['user'] = User::where(['unique_code' => $id])->first();
             if ($data['user']) {
                 return view('user.user.add',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('user edit ex', $e->getMessage());
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
             $data['item'] = User::where(['unique_code' => $id])->first();
             if ($data['item']) {
                 return view('user.user.preview',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('user preview ex', $e->getMessage());
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
             storeException('user delete ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param \Illuminate\Http\Request $request
      * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
      */
     public function store(UserAddRequest $request) {
         try {
             $response = $this->service->saveItemData($request);
             if($response['success']) {
                 return redirect()->route('adminList')->with('success',$response['message']);
             } else {
                 return redirect()->back()->withInput()->with('dismiss',$response['message']);
             }
         } catch(\Exception $e) {
             storeException('user store ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }
}
