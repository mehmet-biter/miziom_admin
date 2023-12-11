<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ResetPasswordSaveRequest;
use App\Http\Services\AuthService;
use App\Models\User;
use App\Models\UserVerificationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //login
    public function login()
    {
        if (Auth::user()) {
            if(Auth::user()->role_module == ROLE_ADMIN || Auth::user()->role_module == ROLE_SUPER_ADMIN) {
                return redirect()->route('adminDashboard');
            } else {
                Auth::logout();
                return view('auth.login');
            }
        }
        return view('auth.login');
    }

    // forgot password
    public function forgotPassword()
    {
        return view('auth.forgot');
    }

    // forgot password
    public function resetPasswordPage()
    {
        return view('auth.reset_password');
    }

    // login process
    public function loginProcess(LoginRequest $request)
    {
        $data['success'] = false;
        $data['message'] = '';
        $data['token'] = '';
        try {
            $user = User::where('email', $request->email)->first();
            $service = new AuthService();
            if (!empty($user)) {
                if(empty($user->email_verified_at))
                    $user->email_verified_at =  0;

                if($user->role_module == ROLE_ADMIN || $user->role_module == ROLE_SUPER_ADMIN) {
                    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                        //Check email verification
                        if ($user->status == STATUS_SUCCESS) {
                            if (!empty($user->email_verified)) {
                                $data['success'] = true;
                                $data['message'] = __('Login successful');
                                return redirect()->route('adminDashboard')->with('success',$data['message']);

                            } else {
                                $existsToken = User::join('user_verification_codes','user_verification_codes.user_id','users.id')
                                    ->where('user_verification_codes.user_id',$user->id)
                                    ->whereDate('user_verification_codes.expired_at' ,'>=', Carbon::now()->format('Y-m-d'))
                                    ->first();
                                if(!empty($existsToken)) {
                                    $mail_key = $existsToken->code;
                                } else {
                                    $mail_key = randomNumber(6);
                                    UserVerificationCode::create(['user_id' => $user->id, 'code' => $mail_key, 'status' => STATUS_PENDING, 'expired_at' => date('Y-m-d', strtotime('+15 days'))]);
                                }
                                try {
                                    $service ->sendEmail($user, $mail_key);
                                    $data['success'] = false;
                                    $data['message'] = __('Your email is not verified yet. Please verify your mail.');
                                    Auth::logout();

                                    return redirect()->back()->with('dismiss',$data['message']);
                                } catch (\Exception $e) {
                                    $data['success'] = false;
                                    $data['message'] = $e->getMessage();
                                    Auth::logout();

                                    return redirect()->back()->with('dismiss',$data['message']);
                                }
                            }
                        } else {
                            $data['success'] = false;
                            $data['message'] = __("Your account has been pending for system approval. please contact support team to active again");
                            Auth::logout();
                            return redirect()->back()->with('dismiss',$data['message']);
                        }

                    } else {
                        $data['success'] = false;
                        $data['message'] = __("Email or Password doesn't match");
                        return redirect()->back()->with('dismiss',$data['message']);
                    }
                } else {
                    $data['success'] = false;
                    $data['message'] = __("You have no login access");
                    Auth::logout();
                    return redirect()->back()->with('dismiss',$data['message']);
                }
            } else {
                $data['success'] = false;
                $data['message'] = __("Email or Password doesn't match");
                return redirect()->back()->with('dismiss',$data['message']);
            }
        } catch (\Exception $e) {
            storeException('login ex',$e->getMessage());
            return redirect()->back()->with('dismiss',__('Something went wrong'));
        }

    }

     // send forgot mail
     public function sendForgotMail(Request $request)
     {
         $service = new AuthService();
         $rules = ['email' => 'required|email'];
         $messages = [
             'email.required' => __('Email field can not be empty'),
             'email.email' => __('Email is invalid'),
             'email.exists' => __('Email is invalid'),
         ];
         $validatedData = $request->validate($rules,$messages);
 
         $response = $service->sendForgotMailProcess($request);
         if ($response['success'] == true) {
             return redirect()->route('resetPasswordPage')->with('success', $response['message']);
         } else {
             return redirect()->back()->with('dismiss', $response['message']);
         }
     }

     // reset password save process

    public function resetPasswordSave(ResetPasswordSaveRequest $request)
    {
        $service = new AuthService();
        $response = $service->passwordResetProcess($request);
        if ($response['success'] == true) {
            return redirect()->route('login')->with('success', $response['message']);
        } else {
            return redirect()->back()->with('dismiss', $response['message']);
        }
    }
    
    // logout
    public function logOut()
    {
        Session::flush();
        Cookie::queue(Cookie::forget('accesstokenvalue'));
        Auth::logout();

        return redirect()->route('logOut')->with('success', __('Logout successful'));
    }

}
