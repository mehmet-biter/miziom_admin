<x-layout.default>
    <div >
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                {{-- Top Header --}}
                <div class="flex justify-between flex-wrap px-4">
                    <div class="text-lg font-semibold ltr:sm:text-left rtl:sm:text-right text-center">{{ $title }}</div>
                </div>
                {{-- Top Horizon --}}
                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">

                {{-- Body Start --}}
                <div class="px-5">

                    {{-- Body Top Buttons --}}
                    <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                        <div class="flex items-center gap-2 mb-5">
                            @if($item->network == BITGO_API)
                                <a  href="{{route('adminCoinApiSettings',['tab' => 'bitgo'])}}" 
                                    class="btn btn-primary gap-2 float-right">
                                    {{ __('Bitgo Api Setting') }} 
                                </a>
                                
                                <a  href="{{route('adminAdjustBitgoWallet',encrypt($item->coin_id))}}" 
                                    class="btn btn-success gap-2 float-right">
                                    {{ __('Adjust Bitgo Wallet') }} 
                                </a>
                            @endif
                        </div>


                        <form method="POST" action="{{ route('adminSaveCoinSetting') }}" enctype="multipart/form-data">
                            @csrf
                            @if(isset($item))<input type="hidden" name="coin_id" value="{{encrypt($item->coin_id)}}">  @endif
                            <input type="hidden" class="form-control" name="currency_type" @if(isset($item))value="{{$item->currency_type}}" @else value="{{old('currency_type')}}" @endif>
                            @include('coin-order.include.bitgo')
                        </form>

                        <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">

                        @if($item->network == BITGO_API)
                            <form method="POST" action="{{ route('webhookSave') }}" enctype="multipart/form-data">
                                @csrf
                                @if(isset($item))<input type="hidden" name="coin_id" value="{{encrypt($item->coin_id)}}">  @endif
                                @include('coin-order.include.webhook')
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

    </script>
    
</x-layout.default>