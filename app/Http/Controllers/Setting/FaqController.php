<?php

namespace App\Http\Controllers\Setting;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqAddRequest;
use App\Http\Services\FaqService;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FaqController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new FaqService();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */

     public function index(Request $request)
     {
         try {
             $data['title'] = __('FAQ');
             if($request->ajax()) {
                 $list = Faq::select('*');
                 return datatables($list)
                     ->addColumn('question', function ($item) use($request) {
                        return Str::limit($item->question, 35, '...');
                     })
                     ->addColumn('created_at', function ($item) use($request) {
                         return $item->created_at;
                     })
                     ->addColumn('status', function ($item) use($request) {
                         return status($item->status);
                     })
                     ->addColumn('actions', function ($item) use ($request) {
                         
                         $html = '<div class="flex gap-4 items-center">';
                         $html .= edit_html('faqEdit',$item->unique_code);
                         $html .= delete_html('faqDelete',$item->unique_code);
                         $html .= '</div>';
                         
                         return $html;
                     })
                     ->rawColumns(['actions','status'])
                     ->make(true);
             }
 
             return view('settings.faq.index', $data);
         } catch(\Exception $e) {
             storeException('faq index ex', $e->getMessage());
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
             $data['title'] = __('Add New FAQ');
             return view('settings.faq.add',$data);
         } catch(\Exception $e) {
             storeException('faq create ex', $e->getMessage());
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
             $data['title'] = __('Update FAQ');
             $data['item'] = $this->service->whereFirst(['unique_code' => $id]);
             if ($data['item']) {
                 return view('settings.faq.add',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('team edit ex', $e->getMessage());
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
             $data['title'] = __('Preview FAQ');
             $data['item'] = $this->service->whereFirst(['unique_code' => $id]);
             if ($data['item']) {
                 return view('settings.faq.preview',$data);
             } else {
                 return redirect()->back()->with('dismiss', __('Data not found'));
             }
         } catch(\Exception $e) {
             storeException('faq preview ex', $e->getMessage());
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
     public function store(FaqAddRequest $request) {
         try {
             $response = $this->service->saveItemData($request, Auth::user());
             if($response['success']) {
                 return redirect()->route('faqList')->with('success',$response['message']);
             } else {
                 return redirect()->back()->withInput()->with('dismiss',$response['message']);
             }
         } catch(\Exception $e) {
             storeException('faq store ex', $e->getMessage());
             return redirect()->back()->with('dismiss', __('Something went wrong'));
         }
     }

     public function getFaqApi(Request $request)
     {
        return response()->json(
            $this->service->getFaqApi($request)
        );
     }
}
