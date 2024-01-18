<x-layout.default>
    <div>
        <div class="panel px-5 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <div class="w-full px-2 mb-4 bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                    <div class="py-7 px-6">
                        <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">{{ __("Clear Application Cache") }}</h5>
                        <p class="text-white-dark ">{{ __('From here you can clear your application all configuration . or also from the command line you can run the command "php artisan cache:clear"') }}</p>
                        <hr><br>
                        <a href="{{route('adminRunCommand',COMMAND_TYPE_CACHE)}}" class="btn btn-success">{{ __("Cache Clear") }}</a>
                    </div>
                </div>

                <div class="w-full px-2 mb-4 bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                    <div class="py-7 px-6">
                        <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">{{ __("Clear Application Config") }}</h5>
                        <p class="text-white-dark ">{{ __('From here you can clear your application cache . or also from the command line you can run the command "php artisan config:clear"') }}</p>
                        <hr><br>
                        <a href="{{route('adminRunCommand',COMMAND_TYPE_CONFIG)}}" class="btn btn-success">{{ __("Config Clear") }}</a>
                    </div>
                </div>

                <div class="w-full px-2 mb-4 bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                    <div class="py-7 px-6">
                        <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">{{ __("Clear Application View / Route") }}</h5>
                        <p class="text-white-dark ">{{ __('From here you can clear your application view and route . or also from the command line you can run the command "php artisan view:clear", "php artisan route:clear"') }}</p>
                        <hr><br>
                        <a href="{{route('adminRunCommand',COMMAND_TYPE_VIEW)}}" class="btn btn-success">{{ __("View Clear") }}</a>
                    </div>
                </div>

                <div class="w-full px-2 mb-4 bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                    <div class="py-7 px-6">
                        <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">{{ __("Run Migration") }}</h5>
                        <p class="text-white-dark ">{{ __('For the new migration you can click the button to migrate or run the command "php artisan migrate"') }}</p>
                        <hr><br>
                        <a href="{{route('adminRunCommand',COMMAND_TYPE_MIGRATE)}}" class="btn btn-success">{{ __("Migrate Clear") }}</a>
                    </div>
                </div>

                <div class="w-full px-2 mb-4 bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                    <div class="py-7 px-6">
                        <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">{{ __("Run Schedule") }}</h5>
                        <p class="text-white-dark ">{{ __('In this command we use some command, that should always run in the background') }}</p>
                        <hr><br>
                        <a href="{{route('adminRunCommand',COMMAND_TYPE_SCHEDULE_START)}}" class="btn btn-success">{{ __("Run Command") }}</a>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <script>

    </script>
</x-layout.default>
