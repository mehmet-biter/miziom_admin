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
                        <a href="{{ route('roleAdd') }}" class="btn btn-info gap-2 float-right">
                            {{ __('Live Update Rate') }} </a>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table id="myTable" class="">
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
                                    <td> {{ $value->name}} </td>
                                    <td> {{$value->code}} </td>
                                    <td> {{$value->symbol}} </td>
                                    <td> {{ $value->usd_rate.' '.$value->code.' /USD' }} </td>
                                    <td>
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
                                    <td>
                                        <ul class=" align-items-center text-center">
                                            <li>
                                                <a  class="btn btn-primary btn-sm rounded-full"
                                                    title="{{__('Edit')}}" 
                                                    href="{{ route("adminCurrencyEdit",["id" => $value->id]) }}">
                                                    {{ __("Edit") }}
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
