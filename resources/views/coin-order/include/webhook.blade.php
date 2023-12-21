<div class="mt-8 px-4">
    <div class="flex justify-between lg:flex-col flex-col">
        <div class="w-full ltr:lg:mr-6 rtl:lg:ml-6 mb-6">
            <div class="text-lg font-semibold">{{ __('Add Bitgo Webhook') }}</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class=" mt-4">
                    <label for="name" class="ltr:mr-2 rtl:ml-2 w-3/3 mb-0">{{ __('Webhook Title') }} <span class="text-danger">*</span></label>
                    <input id="name" type="text" name="label" class="form-input flex-1" 
                    @if(isset($item)) value="{{ $item->bitgo_webhook_label }}" @endif />
                </div>
                <div class=" mt-4">
                    <label for="allTokentype" class="ltr:mr-2 rtl:ml-2 w-3/3 mb-0">{{ __('Coin Api') }} <span class="text-danger">*</span></label>
                    <select id="allTokentype" name="type" class="form-select flex-1">
                        @foreach(webhook_type() as $key => $value)
                            <option @if(isset($item) && $item->bitgo_webhook_type == $key) selected @endif value="{{$key}}">{{$value}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class=" mt-4">
                    <label for="status" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Webhook Url') }} <span class="text-danger">*</span></label>
                    <input id="question" type="text" name="url" class="form-input flex-1"
                        @if(isset($item)) value="{{ $item->bitgo_webhook_url }}" @else value="{{ old('bitgo_webhook_url') }}" @endif />
                </div>
                <div class="mt-4 ">
                    <label for="question" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Number of Confirmation') }} <span class="text-danger">*</span></label>
                    <input id="question" type="text" name="numConfirmations" class="form-input flex-1"
                        @if(isset($item)) value="{{ $item->bitgo_webhook_numConfirmations ? ($item->bitgo_webhook_numConfirmations) : '' }}" @else value="{{ old('bitgo_webhook_numConfirmations') }}" @endif />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div class="mt-4 ">
                    <label for="allToken" class="ltr:mr-2 rtl:ml-2 w-1/3 mb-0">{{ __('Bitgo Wallet Chain') }} <span class="text-danger">*</span></label>
                    <select id="allToken" name="allToken" class="form-select flex-1">
                        <option @if(isset($item) && $item->bitgo_webhook_allToken == STATUS_DEACTIVE) selected @endif value="{{STATUS_DEACTIVE}}">{{__('False')}}</option>
                        <option @if(isset($item) && $item->bitgo_webhook_allToken == STATUS_ACTIVE) selected @endif value="{{STATUS_ACTIVE}}">{{__('True')}}</option>
                    </select>
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
                           {{ __("Update") }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>