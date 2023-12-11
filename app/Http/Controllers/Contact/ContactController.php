<?php

namespace App\Http\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\JobCategoryAddRequest;
use App\Http\Services\ContactService;
use App\Models\ContractList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    private $service;
    public function __construct()
    {
        $this->service = new ContactService();
    }

    public function sendEmail(Request $request) {
        try {
            $response = $this->service->saveItemData($request);
            if($response['success']) {
                return redirect()->back()->with('success',$response['message']);
            } else {
                return redirect()->back()->withInput()->with('dismiss',$response['message']);
            }
        } catch(\Exception $e) {
            storeException('send contact mail ex', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\Response|\Illuminate\View\View
     */

    public function index(Request $request)
    {
        try {
            $data['title'] = __('Contact List');
            if($request->ajax()) {
                $list = ContractList::select('*');
                return datatables($list)
                    
                    ->addColumn('created_at', function ($item) use($request) {
                        return $item->created_at;
                    })
                    ->addColumn('status', function ($item) use($request) {
                        return status($item->status);
                    })
                    ->addColumn('actions', function ($item) use ($request) {
                        
                        $html = '<div class="flex gap-4 items-center">';
                        $html .= view_html('contactPreview',$item->unique_code);
                        $html .= delete_html('contactDelete',$item->unique_code);
                        $html .= '</div>';
                        
                        return $html;
                    })
                    ->rawColumns(['actions','status'])
                    ->make(true);
            }

            return view('contact.index', $data);
        } catch(\Exception $e) {
            storeException('contact index ex', $e->getMessage());
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
            $data['title'] = __('Contact Details');
            $data['item'] = $this->service->whereFirst(['unique_code' => $id]);
            if ($data['item']) {
                return view('contact.preview',$data);
            } else {
                return redirect()->back()->with('dismiss', __('Data not found'));
            }
        } catch(\Exception $e) {
            storeException('contact preview ex', $e->getMessage());
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
            storeException('contact delete ex', $e->getMessage());
            return redirect()->back()->with('dismiss', __('Something went wrong'));
        }
    }

    
}
