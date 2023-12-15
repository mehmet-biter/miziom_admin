
<h3>{{__('Hello')}}, {{isset($user) ? $user->first_name.' '.$user->last_name : ''}}</h3>
<p>
    {{ __('You are receiving this email because we received a password reset request for your account.') }}
    {{__('Please use the code below to reset your password.')}}
</p>
<p style="text-align:center;font-size:30px;font-weight:bold">
    {{$token}}
</p>
@if(isset($user) && ($user->role_module != MODULE_USER))
    <p>{{__('You can reset your password with this link')}} : <a href="{{route('resetPasswordPage')}}">{{__('Click Here')}}</a></p>
@endif

