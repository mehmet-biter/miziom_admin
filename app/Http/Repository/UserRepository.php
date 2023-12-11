<?php
namespace App\Http\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public static function createUser($request){

        $data=[
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
            'role'=>USER_ROLE_USER,
        ];
       return User::create($data);
    }
    public static function updatePassword($request,$user_id){
       return User::where(['id'=>$user_id])->update(['password'=>bcrypt($request->password)]);
    }
    public static function apiUpdatePassword($request,$user_id){
        return User::where(['id'=>$user_id])->update(['password'=>bcrypt($request->new_password)]);
    }

    // update user profile
    public function profileUpdate($request, $user_id)
    {
        if (env('APP_MODE') == 'demo') {
            return ['success' => false, 'message' => __('Currently disable only for demo')];
        }
        $response['success'] = false;
        $response['user'] = (object)[];
        $response['message'] = __('Invalid Request');
        try {
            $user = User::find($user_id);
            $userData = [];
            if ($user) {
                
                $userData = [
                    'email' => $request['email'],
                    'first_name' => $request['first_name'],
                    'last_name' => $request['last_name'],
                    'phone' => $request['phone'],
                ];
                if (!empty($request['country'])) {
                    $userData['country'] = $request['country'];
                }
                if (!empty($request['gender'])) {
                    $userData['gender'] = $request['gender'];
                }
                if (!empty($request['birth_date'])) {
                    $userData['birth_date'] = $request['birth_date'];
                }

                if (!empty($request['photo'])) {
                    $old_img = '';
                    if (!empty($user->photo)) {
                        $old_img = $user->photo;
                    }
                    $userData['photo'] = uploadFileStorage($request['photo'], IMAGE_PATH_USER, $old_img);
                }
                if ($user->phone != $request->phone){
                    $userData['phone'] =  $request->phone;
                    $userData['phone_verified'] = 0;
                }

                $affected_row = User::where('id', $user_id)->update($userData);
                if ($affected_row) {
                    $response['success'] = true;
                    
                    $response['message'] = __('Profile updated successfully');
                }
            } else {
                $response['success'] = false;
                $response['user'] = (object)[];
                $response['message'] = __('Invalid User');
            }
        } catch (\Exception $e) {
            storeException('profileUpdate', $e->getMessage());
            $response = [
                'success' => false,
                'user' => (object)[],
                'message' => $e->getMessage()
            ];
            return $response;
        }

        return $response;
    }

    public function passwordChange($request, $user_id)
    {
        if (env('APP_MODE') == 'demo') {
            return ['success' => false, 'message' => __('Currently disable only for demo')];
        }
        $response['success'] = false;
        $response['message'] = __('Invalid Request');
        try {
            $user = User::find($user_id);
            if ($user) {
                $old_password = $request['old_password'];
                if (Hash::check($old_password, $user->password)) {
                    if(!Hash::check($request->password,$user->password)) {
                        $user->password = bcrypt($request['password']);
                        $user->save();
                        $affected_row = $user->save();

                        if (!empty($affected_row)) {
                            $response['success'] = true;
                            $response['message'] = __('Password changed successfully.');
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = __('You already used password');
                    }
                } else {
                    $response['success'] = false;
                    $response['message'] = __('Incorrect old password');
                }
            } else {
                $response['success'] = false;
                $response['message'] = __('Invalid user');
            }
        } catch (\Exception $e) {
            storeException('passwordChange', $e->getMessage());
            $response = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
        }
        return $response;
    }

    // user profile
    public function userProfile($user_id)
    {
        try {
            if (isset($user_id)) {
                $user = User::select(
                    'id',
                    'nickname',
                    'first_name',
                    'last_name',
                    'email',
                    'country',
                    'google2fa_secret',
                    'phone_verified',
                    'phone',
                    'gender',
                    'birth_date',
                    'photo',
                    'status',
                    'is_verified',
                    'phone_verified',
                    'created_at',
                    'updated_at',
                    'currency'
                )->findOrFail($user_id);

                $data['user'] = $user;
                $data['user']->photo = imageSrcUser($user->photo,IMG_USER_VIEW_PATH);
                $data['user']->online_status = lastSeenStatus($user->id)['data'];
                $data['user']->country_name = !empty($user->country) ? country(strtoupper($user->country)) : '';
                $data['activityLog'] = ActivityLog::where('user_id', $user_id)->where('action',USER_ACTIVITY_LOGIN)->latest()->take(5)->get();
                $data['success'] = true;
                $data['message'] = __('Successful');
            } else {
                $data= [
                    'success' => false,
                    'user' => (object)[],
                    'message' => __('User not found'),
                ];
            }
        } catch (\Exception $e) {
            storeException('userProfile', $e->getMessage());
            $data = [
                'success' => false,
                'message' => __('Something went wrong')
            ];
        }
        return $data;
    }

   

}
