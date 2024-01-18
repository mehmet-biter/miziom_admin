<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        {{-- <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Admin Setting') }}</h5> --}}
                        <a href="{{ route('adminCurrencyAdd') }}" class="btn btn-primary gap-2 float-right">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="w-5 h-5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            {{ __('Add New') }} </a>

                        <a href="javascript:;" onclick="getallCurrency()" class="btn btn-success gap-2 float-right">
                            {{ __('Get All Currency') }} </a>
                        <a href="{{ route('adminCurrencyRate') }}" class="btn btn-info gap-2 float-right">
                            {{ __('Live Update Rate') }} </a>
                    </div>
                </div>
            </div>
            <div class="mt-8 px-5">
                <table id="myTable" class="table-hover !pt-5">
                    <thead>
                        <tr>
                            <th class="all">{{__('Name')}}</th>
                            <th class="all">{{__('Code')}}</th>
                            <th class="all">{{__('Symbol')}}</th>
                            <th class="all">{{__('Rate')}}</th>
                            <th class="all">{{__('Status')}}</th>
                            <th class="text-lg-center all">{{__('Actions')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(isset($items[0]))
                            @foreach($items as $value)
                                <tr>
                                    <td class="!px-[18px]"> {{ $value->name}} </td>
                                    <td class="!px-[18px]"> {{$value->code}} </td>
                                    <td class="!px-[18px]">  {{$value->symbol}} </td>
                                    <td class="!px-[18px]"> {{ $value->usd_rate.' '.$value->code.' /USD' }} </td>
                                    <td class="!px-[18px]">
                                        <div>
                                            <label class="w-12 h-6 relative">
                                                <input onclick="return processFormCall(this,'{{$value->id}}')" type="checkbox" 
                                                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer" 
                                                    id="custom_switch_checkbox4" 
                                                    @if($value->status == STATUS_ACTIVE) checked @endif/>
                                                <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                                            </label> 
                                        </div>
                                    </td>
                                    <td class="!px-[18px]">
                                        <ul class=" align-items-center text-center">
                                            <li>
                                                <a  
                                                    title="{{__('Edit')}}" 
                                                    href="{{ route("adminCurrencyEdit",["id" => $value->id]) }}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512" class="fill-gray-400">
                                                        <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6">{{__('No data found')}}</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        function processFormCall(e,active_id) {
            $.ajax({
                type: "POST",
                url: "{{ route('adminCurrencyStatus') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    'active_id': active_id
                },
                success: function (data) {
                   if(data.success)
                   {
                        VanillaToasts.create({
                        text: data.message,
                        backgroundColor: "linear-gradient(135deg, #73a5ff, #5477f5)",
                        type: 'success',
                        timeout: 40000
                        });
                   }else{
                        e.checked = false;
                        VanillaToasts.create({
                        text: data.message,
                        backgroundColor: "linear-gradient(135deg, #73a5ff, #5477f5)",
                        type: 'warning',
                        timeout: 40000
                        });
                   }
                    console.log(data,e);
                }
            });
        }

        function getallCurrency(){
            $.ajax({
                type: "POST",
                url: "{{ route('adminAllCurrency') }}",
                data: {
                    '_token': "{{ csrf_token() }}"
                },
                success: function (data) {
                    window.location.reload(true);
                }
            });
        }



        $('#myTable').DataTable({
            processing: true,
            serverSide: false,
            paging: true,
            searching: true,
            ordering:  true,
            select: false,
            bDestroy: true,
            order: [1, 'desc'],
            responsive: true,
            autoWidth: false,
            language: {
                "decimal":        "",
                "emptyTable":     "{{__('No data available in table')}}",
                "info":           "{{__('Showing')}} _START_ to _END_ of _TOTAL_ {{__('entries')}}",
                "infoEmpty":      "{{__('Showing')}} 0 to 0 of 0 {{__('entries')}}",
                "infoFiltered":   "({{__('filtered from')}} _MAX_ {{__('total entries')}})",
                "infoPostFix":    "",
                "thousands":      ",",
                "lengthMenu":     "{{__('Show')}} _MENU_ {{__('entries')}}",
                "loadingRecords": "{{__('Loading...')}}",
                "processing":     "",
                "search":         "{{__('Search')}}:",
                "zeroRecords":    "{{__('No matching records found')}}",
                "paginate": {
                    "first":      "{{__('First')}}",
                    "last":       "{{__('Last')}}",
                    "next":       '{{__('Next')}} &#8250;',
                    "previous":   '&#8249; {{__('Previous')}}'
                },
                "aria": {
                    "sortAscending":  ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
        });
        
    </script>
</x-layout.default>
