<x-layout.default>

    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Users</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Account Settings</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Update Profile') }}</h5>
            </div>
            <div x-data="{ tab: 'home' }">
                <div>
                    <form action="{{ route('updateProfileProcess') }}" enctype="multipart/form-data" method="post"
                        class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
                        @csrf
                        <h6 class="text-lg font-bold mb-5">General Information</h6>
                        <div class="flex flex-col sm:flex-row">
                            <div class="ltr:sm:mr-4 rtl:sm:ml-4 w-full sm:w-2/12 mb-5">
                                <img @if(!empty($user->photo)) src="{{ showUserImage(VIEW_IMAGE_PATH_USER,$user->photo) }}" @else src="{{ asset('assets/images/avatar.jpg') }}" @endif alt="image"
                                    class="w-20 h-20 md:w-32 md:h-32 rounded-full object-cover mx-auto" />
                            </div>
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name">First Name</label>
                                    <input id="name" type="text" name="first_name" value="{{ $user->first_name }}"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="profession">Last Name</label>
                                    <input id="profession" type="text" name="last_name" value="{{ $user->last_name }}"
                                        class="form-input" />
                                </div>
                                
                                <div>
                                    <label for="address">Email</label>
                                    <input id="address" type="email" name="email" value="{{ $user->email }}"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="phone">Phone</label>
                                    <input id="phone" type="text" name="phone" value="{{ $user->phone }}"
                                        class="form-input" />
                                    <input type="hidden" name="edit_id" value="{{ $user->id }}">    
                                </div>
                                <div>
                                    <label for="email">Profile Image</label>
                                    <input id="email" type="file" name="photo"
                                        class="form-input" />
                                </div>
                                
                                
                                <div class="sm:col-span-2 mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ route('changePasswordProcess') }}" enctype="multipart/form-data" method="post"
                        class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 bg-white dark:bg-[#0e1726]">
                        @csrf
                        <h6 class="text-lg font-bold mb-5">Change Password</h6>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name">Old Password</label>
                                    <input id="name" type="password" name="old_password" 
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="profession">New Password</label>
                                    <input id="profession" type="password" name="password" 
                                        class="form-input" />
                                </div>
                                
                                <div>
                                    <label for="address">Confirm Password</label>
                                    <input id="address" type="password" name="password_confirmation" 
                                        class="form-input" />
                                </div>
                                
                                <div class="sm:col-span-2 mt-3">
                                    <button type="submit" class="btn btn-primary">Change</button>
                                </div>
                            </div>
                            
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>

</x-layout.default>
