<x-layout.default>

    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">{{ __('Admin') }}</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>{{ isset($user) ? __('Update Admin') : __('Create Admin') }}</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="flex items-center justify-between mb-5">
            </div>
            <div x-data="{ tab: 'home' }">
                <div>
                    <form action="{{ route('adminStoreProcess') }}" enctype="multipart/form-data" method="post"
                        class="border border-[#ebedf2] dark:border-[#191e3a] rounded-md p-4 mb-5 bg-white dark:bg-[#0e1726]">
                        @csrf
                        <h6 class="text-lg font-bold mb-5">General Information</h6>
                        <div class="flex flex-col sm:flex-row">
                            <div class="ltr:sm:mr-4 rtl:sm:ml-4 w-full sm:w-2/12 mb-5">
                                <img @if(isset($user) && !empty($user->photo)) src="{{ showUserImage(VIEW_IMAGE_PATH_USER,$user->photo) }}" @else src="{{ asset('assets/images/avatar.jpg') }}" @endif alt="image"
                                    class="w-20 h-20 md:w-32 md:h-32 rounded-full object-cover mx-auto" />
                            </div>
                            <div class="flex-1 grid grid-cols-1 sm:grid-cols-2 gap-5">
                                <div>
                                    <label for="name">User Name</label>
                                    <input id="name" type="text" name="name" value="{{ isset($user) ? $user->name : old('name') }}"
                                        class="form-input" />
                                </div>
                                
                                
                                <div>
                                    <label for="address">Email</label>
                                    <input id="address" type="email" name="email" value="{{ isset($user) ? $user->email : old('email') }}"
                                        class="form-input" />
                                </div>
                                <div>
                                    <label for="phone">Phone</label>
                                    <input id="phone" type="text" name="phone" value="{{ isset($user) ? $user->phone : old('phone') }}"
                                        class="form-input" />
                                    @if(isset($user))    
                                    <input type="hidden" name="edit_id" value="{{ $user->id }}"> 
                                    @endif   
                                </div>
                                <div>
                                    <label for="address">Role</label>
                                    <select name="role" id="" class="form-select">
                                        @if(isset($roles[0]))
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->title }}</option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="">
                                    <label for="status" class="">{{ __('Activation Status') }} <span class="text-danger">*</span></label>
                                    <select id="status" name="status" class="form-select">
                                        @foreach (activationStatus() as $key => $val)
                                            <option @if(isset($item) && $item->status == $key) selected @endif value="{{$key}}">{{$val}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label >Password</label>
                                    <input autocomplete="off" type="password" name="password" class="form-input" />
                                </div>
                                <div>
                                    <label >Password Confirmation</label>
                                    <input type="password" name="password_confirmation" class="form-input" />
                                </div>
                                <div>
                                    <label for="">Profile Image</label>
                                    <input id="" type="file" name="photo"
                                        class="form-input" />
                                </div>
                                
                                
                                <div class="sm:col-span-2 mt-3">
                                    <button type="submit" class="btn btn-primary">{{ isset($user) ? __('Update') : __('Create') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                </div>
                
            </div>
        </div>
    </div>

</x-layout.default>
