<x-layout.default>

    <div >
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="flex justify-between flex-wrap px-4">
                    <div class="text-lg font-semibold ltr:sm:text-left rtl:sm:text-right text-center">{{ __('Add New Currency') }}</div>
                </div>
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
                <form method="POST" action="{{ route('adminCurrencyStore') }}" enctype="multipart/form-data">
                @csrf
                <div class="mt-8 px-4">
                    <div class="flex justify-between lg:flex-row flex-col">
                        <div class="lg:w-1/2 w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
                            <div class="text-lg font-semibold">{{ __('Currency Info') }}</div>
                            <div class="mt-4 items-center">
                                <label for="question" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Coin Full Name') }} <span class="text-danger">*</span></label>
                                <input id="question" type="text" name="name" class="form-input flex-1"
                                    @if(isset($item)) value="{{$item->name}}" @else value="{{old('name')}}" @endif />
                            </div>

                            <div class="items-center mt-4">
                                <label for="status" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Currency Code') }} <span class="text-danger">*</span></label>
                                <select id="currencySelect" name="code" class="form-select flex-1">
                                    @foreach(fiat_currency_array() as $val)
                                        <option @if(isset($item) && $item->code == $val['code']) selected @endif data-symbol="{{ $val['symbol'] }}" value="{{ $val['code'] }}"> {{ $val['name'].'('.$val['code'].' ,'. $val['symbol'].')' }} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4 items-center">
                                <label for="question" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Currency Symbol') }} <span class="text-danger">*</span></label>
                                <input id="symbol" type="text" name="symbol" class="form-input flex-1"
                                    @if(isset($item)) value="{{$item->symbol}}" @else value="{{old('symbol')}}" @endif />
                            </div>

                            
                            <div class="mt-4 items-center">
                                <label for="question" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Rate (1 USD = ? )') }} <span class="text-danger">*</span></label>
                                <input id="question" type="text" name="rate" class="form-input flex-1"
                                    @if(isset($item)) value="{{ $item->rate }}" @else value="{{ old('rate') }}" @endif />
                            </div>

                            <!-- rounded -->
                            <div class="mt-4 items-center">
                                <label for="question" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Status') }}</label>
                                <label class="w-12 h-6 relative">
                                    <input @if(isset($item) && $item?->status) checked @endif name="status" type="checkbox" class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" id="custom_switch_checkbox4" />
                                    <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                                </label>                              
                            </div>
                            @if(isset($item))
                                <input type="hidden" name="id" value="{{$item->id}}">
                            @endif
                           
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
                                           {{ __("Save") }}
                                        </button>
                                        <a href="{{ route('adminCurrencyList') }}">
                                            <button type="button" class="btn btn-warning w-full gap-2">
            
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                                    <path
                                                        d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                    <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5"
                                                        stroke-linecap="round" />
                                                </svg>
                                                {{ __("Cancel") }} 
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>
 
    <script>
        document.addEventListener("DOMContentLoaded", function(e) {
            var currencySelect = document.getElementById("currencySelect");

            currencySelect.addEventListener("change", function () {
                var selectedValue = currencySelect.value;
                $('.fiatCurrency').text(selectedValue);
                var selectedOption = currencySelect.options[currencySelect.selectedIndex];
                var selectedSymbol = selectedOption.getAttribute("data-symbol");
                $('#symbol').val(selectedSymbol);

            });
        });
    </script>
    
</x-layout.default>