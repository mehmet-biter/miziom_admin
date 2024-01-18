<x-layout.default>


    <div>
        
        <div class="panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Admin Setting') }}</h5>
                
            </div>
            <div class="mb-5" x-data="{ tab: 'home' }">
                <div>
                    <ul
                        class="grid grid-cols-4 gap-2 sm:flex sm:flex-wrap mt-3 mb-5 sm:space-x-3 rtl:space-x-reverse">
                        <li>
                            <a href="javascript:;"
                                class="p-7 py-3 flex gap-4 items-center justify-center rounded-lg bg-[#f1f2f3] dark:bg-[#191e3a] hover:!bg-success hover:text-white hover:shadow-[0_5px_15px_0_rgba(0,0,0,0.30)]"
                                :class="{ '!bg-success text-white': tab === 'home' }" @click="tab = 'home'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <path opacity="0.5"
                                        d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                    <path d="M12 15L12 18" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                </svg>
                                {{ __('General') }}
                            </a>
                        </li>
                        {{-- <li>
                            <a href="javascript:;"
                                class="p-7 py-3 flex flex-col items-center justify-center rounded-lg bg-[#f1f2f3] dark:bg-[#191e3a] hover:!bg-success hover:text-white hover:shadow-[0_5px_15px_0_rgba(0,0,0,0.30)]"
                                :class="{ '!bg-success text-white': tab === 'profile' }"
                                @click="tab = 'profile'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mb-1">
                                    <circle cx="12" cy="6" r="4"
                                        stroke="currentColor" stroke-width="1.5"></circle>
                                    <ellipse opacity="0.5" cx="12" cy="17" rx="7"
                                        ry="4" stroke="currentColor" stroke-width="1.5"></ellipse>
                                </svg>
                                {{ __('Landing') }}
                            </a>
                        </li> --}}
                        <li>
                            <a href="javascript:;"
                                class="p-7 py-3 flex gap-4 items-center justify-center rounded-lg bg-[#f1f2f3] dark:bg-[#191e3a] hover:!bg-success hover:text-white hover:shadow-[0_5px_15px_0_rgba(0,0,0,0.30)]"
                                :class="{ '!bg-success text-white': tab === 'email' }"
                                @click="tab = 'email'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <path
                                        d="M16.1007 13.359L16.5562 12.9062C17.1858 12.2801 18.1672 12.1515 18.9728 12.5894L20.8833 13.628C22.1102 14.2949 22.3806 15.9295 21.4217 16.883L20.0011 18.2954C19.6399 18.6546 19.1917 18.9171 18.6763 18.9651M4.00289 5.74561C3.96765 5.12559 4.25823 4.56668 4.69185 4.13552L6.26145 2.57483C7.13596 1.70529 8.61028 1.83992 9.37326 2.85908L10.6342 4.54348C11.2507 5.36691 11.1841 6.49484 10.4775 7.19738L10.1907 7.48257"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                    <path opacity="0.5"
                                        d="M18.6763 18.9651C17.0469 19.117 13.0622 18.9492 8.8154 14.7266C4.81076 10.7447 4.09308 7.33182 4.00293 5.74561"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                    <path opacity="0.5"
                                        d="M16.1007 13.3589C16.1007 13.3589 15.0181 14.4353 12.0631 11.4971C9.10807 8.55886 10.1907 7.48242 10.1907 7.48242"
                                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                                    </path>
                                </svg>
                                {{ __('Email') }}
                            </a>
                        </li>
                        <li>
                            <a href="javascript:;"
                                class="p-7 py-3 flex gap-4 items-center justify-center rounded-lg bg-[#f1f2f3] dark:bg-[#191e3a] hover:!bg-success hover:text-white hover:shadow-[0_5px_15px_0_rgba(0,0,0,0.30)]"
                                :class="{ '!bg-success text-white': tab === 'logo' }"
                                @click="tab = 'logo'">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5">
                                    <circle cx="12" cy="12" r="3"
                                        stroke="currentColor" stroke-width="1.5"></circle>
                                    <path opacity="0.5"
                                        d="M13.7654 2.15224C13.3978 2 12.9319 2 12 2C11.0681 2 10.6022 2 10.2346 2.15224C9.74457 2.35523 9.35522 2.74458 9.15223 3.23463C9.05957 3.45834 9.0233 3.7185 9.00911 4.09799C8.98826 4.65568 8.70226 5.17189 8.21894 5.45093C7.73564 5.72996 7.14559 5.71954 6.65219 5.45876C6.31645 5.2813 6.07301 5.18262 5.83294 5.15102C5.30704 5.08178 4.77518 5.22429 4.35436 5.5472C4.03874 5.78938 3.80577 6.1929 3.33983 6.99993C2.87389 7.80697 2.64092 8.21048 2.58899 8.60491C2.51976 9.1308 2.66227 9.66266 2.98518 10.0835C3.13256 10.2756 3.3397 10.437 3.66119 10.639C4.1338 10.936 4.43789 11.4419 4.43786 12C4.43783 12.5581 4.13375 13.0639 3.66118 13.3608C3.33965 13.5629 3.13248 13.7244 2.98508 13.9165C2.66217 14.3373 2.51966 14.8691 2.5889 15.395C2.64082 15.7894 2.87379 16.193 3.33973 17C3.80568 17.807 4.03865 18.2106 4.35426 18.4527C4.77508 18.7756 5.30694 18.9181 5.83284 18.8489C6.07289 18.8173 6.31632 18.7186 6.65204 18.5412C7.14547 18.2804 7.73556 18.27 8.2189 18.549C8.70224 18.8281 8.98826 19.3443 9.00911 19.9021C9.02331 20.2815 9.05957 20.5417 9.15223 20.7654C9.35522 21.2554 9.74457 21.6448 10.2346 21.8478C10.6022 22 11.0681 22 12 22C12.9319 22 13.3978 22 13.7654 21.8478C14.2554 21.6448 14.6448 21.2554 14.8477 20.7654C14.9404 20.5417 14.9767 20.2815 14.9909 19.902C15.0117 19.3443 15.2977 18.8281 15.781 18.549C16.2643 18.2699 16.8544 18.2804 17.3479 18.5412C17.6836 18.7186 17.927 18.8172 18.167 18.8488C18.6929 18.9181 19.2248 18.7756 19.6456 18.4527C19.9612 18.2105 20.1942 17.807 20.6601 16.9999C21.1261 16.1929 21.3591 15.7894 21.411 15.395C21.4802 14.8691 21.3377 14.3372 21.0148 13.9164C20.8674 13.7243 20.6602 13.5628 20.3387 13.3608C19.8662 13.0639 19.5621 12.558 19.5621 11.9999C19.5621 11.4418 19.8662 10.9361 20.3387 10.6392C20.6603 10.4371 20.8675 10.2757 21.0149 10.0835C21.3378 9.66273 21.4803 9.13087 21.4111 8.60497C21.3592 8.21055 21.1262 7.80703 20.6602 7C20.1943 6.19297 19.9613 5.78945 19.6457 5.54727C19.2249 5.22436 18.693 5.08185 18.1671 5.15109C17.9271 5.18269 17.6837 5.28136 17.3479 5.4588C16.8545 5.71959 16.2644 5.73002 15.7811 5.45096C15.2977 5.17191 15.0117 4.65566 14.9909 4.09794C14.9767 3.71848 14.9404 3.45833 14.8477 3.23463C14.6448 2.74458 14.2554 2.35523 13.7654 2.15224Z"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                </svg>
                                {{ __('Logo') }}
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="flex-1 text-sm ">
                    <template x-if="tab === 'home'">
                        <div>
                            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                            @include('settings.admin.include.general_setting')
                        </div>
                    </template>
                    <template x-if="tab === 'landing'">
                        <div>
                            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                            @include('settings.admin.include.landing')
                        </div>
                    </template>
                    <template x-if="tab === 'email'">
                        <div>
                            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                            @include('settings.admin.include.email')
                        </div>
                    </template>
                    <template x-if="tab === 'logo'">
                        <div>
                            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                            @include('settings.admin.include.logo')
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <script>
    
        
    </script>
</x-layout.default>
