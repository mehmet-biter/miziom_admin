<x-layout.default>

    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">{{ __('Contact') }}</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>{{ $title }}</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="grid grid-cols-1 lg:grid-cols-3 xl:grid-cols-4 gap-5 mb-5">
                
                <div class="panel lg:col-span-2 xl:col-span-3">
                    <div class="mb-5">
                        <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Email Details') }}</h5>
                    </div>
                    <div class="mb-5">
                        <div class="content p-6">
                            
                            <h4 class="mb-4 mt-4  font-medium dark:text-white">{{ __('Name') }} : {{ $item->name}}</h4>
                            <h4 class="mb-4 mt-4  font-medium dark:text-white">{{ __('Email') }} : {{ $item->email}}</h4>
                            <h4 class="mb-4 mt-4  font-medium dark:text-white">{{ __('Subject') }} : {{ $item->subject}}</h4>
                            
                            <h2 class="text-black text-base font-medium uppercase mb-2 mt-5">{{ __('Details')}} :</h2>
                            <p class="text-slate-400 mt-2">{!! $item->description !!}</p>
                            
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout.default>
