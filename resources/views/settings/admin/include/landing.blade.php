<form method="POST" action="{{ route('updateGeneralSetting') }}" enctype="multipart/form-data">
    @csrf
        <div class="mt-4 px-4">
            <div class="flex justify-between lg:flex-row flex-col">
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Banner Section') }}</h5>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Banner Title') }}</label>
                        <input type="text" name="landing_banner_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_banner_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Banner Sub Title') }}</label>
                        <input type="text" name="landing_banner_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_banner_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Banner Button Text') }}</label>
                        <input type="text" name="landing_banner_button_text" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_banner_button_text']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Banner Background Image') }}</label>
                        <input type="file" name="landing_banner_image" class="mt-2 form-input flex-1"/>
                        @if(!empty($settings['landing_banner_image']))
                            <div>
                                <img class="w-40 h-20" src="{{ showImage(VIEW_IMAGE_SETTING_PATH,$settings['landing_banner_image']) }}" alt="">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing About Section') }}</h5>

                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('About Title') }}</label>
                        <input type="text" name="landing_about_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_about_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('About Sub Title') }}</label>
                        <input type="text" name="landing_about_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_about_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('About Description') }}</label>
                        <textarea id="" name="landing_about_des" class="form-textarea h-20" >{{ $settings['landing_about_des'] }}</textarea>
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('About Image') }}</label>
                        <input type="file" name="landing_about_image" class="mt-2 form-input flex-1"/>
                        @if(!empty($settings['landing_about_image']))
                            <div>
                                <img class="w-40 h-20" src="{{ showImage(VIEW_IMAGE_SETTING_PATH,$settings['landing_about_image']) }}" alt="">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
            <div class="flex justify-between lg:flex-row flex-col">
                
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Service Section') }}</h5>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Service Title') }}</label>
                        <input type="text" name="landing_service_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_service_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Service Sub Title') }}</label>
                        <input type="text" name="landing_service_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_service_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Service Description') }}</label>
                        <textarea id="" name="landing_service_des" class="form-textarea h-20" >{{ $settings['landing_service_des'] }}</textarea>
                    </div>
                </div>
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Team Section') }}</h5>

                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Team Title') }}</label>
                        <input type="text" name="landing_team_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_team_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Team Sub Title') }}</label>
                        <input type="text" name="landing_team_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_team_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Team Description') }}</label>
                        <textarea id="" name="landing_team_des" class="form-textarea h-20" >{{ $settings['landing_team_des'] }}</textarea>
                    </div>
                    
                </div>
            </div>
            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
            <div class="flex justify-between lg:flex-row flex-col">
                
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Job Section') }}</h5>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Title') }}</label>
                        <input type="text" name="landing_job_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_job_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Sub Title') }}</label>
                        <input type="text" name="landing_job_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_job_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Description') }}</label>
                        <textarea id="" name="landing_job_des" class="form-textarea h-20" >{{ $settings['landing_job_des'] }}</textarea>
                    </div>
                </div>
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Contact Section') }}</h5>

                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Contact Title') }}</label>
                        <input type="text" name="landing_contact_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_contact_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Contact Sub Title') }}</label>
                        <input type="text" name="landing_contact_sub_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_contact_sub_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Contact Description') }}</label>
                        <textarea id="" name="landing_contact_des" class="form-textarea h-20" >{{ $settings['landing_contact_des'] }}</textarea>
                    </div>
                    
                </div>
            </div>
            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
            <div class="flex justify-between lg:flex-row flex-col">
                
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Landing Other Section') }}</h5>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Ready Title') }}</label>
                        <input type="text" name="landing_job_ready_title" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_job_ready_title']}}" />
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Ready Button Text') }}</label>
                        <input type="text" name="landing_job_ready_button_text" class="mt-2 form-input flex-1"
                            value="{{ $settings['landing_job_ready_button_text']}}" />
                    </div>
                </div>
                <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                    <h5 class="font-semibold text-lg dark:text-white-light"></h5>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Ready Description') }}</label>
                        <textarea id="" name="landing_job_ready_des" class="form-textarea h-20" >{{ $settings['landing_job_ready_des'] }}</textarea>
                    </div>
                    <div class="mt-4  items-center">
                        <label class="ltr:mr-2 rtl:ml-2 w-full mb-0">{{ __('Job Ready Background Image') }}</label>
                        <input type="file" name="landing_job_ready_back_img" class="mt-2 form-input flex-1"/>
                        @if(!empty($settings['landing_job_ready_back_img']))
                            <div>
                                <img class="w-40 h-20" src="{{ showImage(VIEW_IMAGE_SETTING_PATH,$settings['landing_job_ready_back_img']) }}" alt="">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-8">
            <div class="flex justify-between sm:flex-row flex-col mt-6 px-4">
                <div class="sm:mb-0 mb-6 flex justify-between gap-2">
                    <button type="submit" class="btn btn-success w-full gap-2">

                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path
                                d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                stroke="currentColor" stroke-width="1.5" />
                            <path
                                d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                stroke="currentColor" stroke-width="1.5" />
                            <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" />
                        </svg>
                        {{  __("Update")}} 
                    </button>
                    <a href="{{ route('adminDashboard') }}">
                        <button type="button" class="btn btn-warning w-full gap-2">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                <path
                                    d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" />
                            </svg>
                            Cancel </button>
                        </a>
                </div>
            </div>
        </div>
    </form>