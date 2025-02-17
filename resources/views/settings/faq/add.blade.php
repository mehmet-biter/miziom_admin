<x-layout.default>

    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <div >
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex justify-between flex-wrap px-4">
                    <div class="text-lg font-semibold ltr:sm:text-left rtl:sm:text-right text-center">{{ __('Add New FAQ') }}</div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                <form method="POST" action="{{ route('faqStoreProcess') }}" enctype="multipart/form-data">
                 @csrf
                <div class="mt-8 px-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="w-full">
                            <div class="flex flex-col">
                                <label for="question" class=" mb-2">{{ __('Question') }} <span class="text-danger">*</span></label>
                                <input id="question" type="text" name="question" class="form-input flex-1"
                                    @if(isset($item)) value="{{ $item->question }}" @else value="{{ old('question') }}" @endif />
                            </div>
                            
                            
                        </div>
                        <div class="w-full">
                            <div class="flex flex-col">
                                <label for="status" class=" mb-2">{{ __('Activation Status') }} <span class="text-danger">*</span></label>
                                <select id="status" name="status" class="form-select flex-1">
                                    @foreach (activationStatus() as $key => $val)
                                        <option @if(isset($item) && $item->status == $key) selected @endif value="{{$key}}">{{$val}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full">
                            <label for="answer">{{ __('Answer') }} </label>
                            <textarea id="answer" name="answer" class="form-textarea min-h-[30px]" >{{ isset($item) ? $item->answer : old('answer') }}</textarea>
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
                                @if(isset($item)) <input type="hidden" name="edit_id" value="{{ $item->unique_code }}"> {{  __("Update")}} @else {{ __("Save") }} @endif
                             </button>
                             <a href="{{ route('faqList') }}">
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
            </div>

        </div>
    </div>
    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->

    <script src="/assets/js/nice-select2.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            // default
            var els = document.querySelectorAll(".selectize");
            els.forEach(function(select) {
                NiceSelect.bind(select);
            });

            // seachable
            var options = {
                searchable: true
            };
            NiceSelect.bind(document.getElementById("seachable-select"), options);
            NiceSelect.bind(document.getElementById("seachable-select2"), options);
        });
    </script>
    
</x-layout.default>
