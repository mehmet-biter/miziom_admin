<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        {{-- <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Admin Setting') }}</h5> --}}
                        <a href="{{ route('adminAddCoin') }}" class="btn btn-primary gap-2 float-right">

                            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" class="w-5 h-5">
                                <line x1="12" y1="5" x2="12" y2="19"></line>
                                <line x1="5" y1="12" x2="19" y2="12"></line>
                            </svg>
                            {{ __('Add New') }} </a>
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table id="myTable" class="">
                    <thead>
                        <tr>
                            <th scope="col" >{{__('Coin Name')}}</th>
                            <th scope="col" class="all">{{__('Currency Type')}}</th>
                            <th scope="col">{{__('Coin Type')}}</th>
                            <th scope="col">{{__('Coin API')}}</th>
                            <th scope="col">{{__('Coin Price')}}</th>
                            <th scope="col" class="all">{{__('Status')}}</th>
                            <th scope="col">{{__('Updated At')}}</th>
                            <th class="text-lg-center all">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($coins))
                            @foreach($coins as $coin)
                                <tr>
                                    <td> {{$coin->name}} </td>
                                    <td> {{getTradeCurrencyType($coin->currency_type)}} </td>
                                    <td> {{find_coin_type($coin->coin_type)}} </td>
                                    <td> {{ $coin->currency_type == CURRENCY_TYPE_CRYPTO ? api_settings($coin->network) : __("Fiat Currency")}} </td>
                                    <td> {{number_format($coin->coin_price,2).' USD/ '.find_coin_type($coin->coin_type)}} </td>
                                    <td>
                                        <div>
                                            <label class="w-12 h-6 relative">
                                                <input onclick="return processForm('{{$coin->id}}')" type="checkbox"
                                                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                                    id="custom_switch_checkbox4"
                                                    @if($coin->status == STATUS_ACTIVE) checked @endif/>
                                                <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td> {{$coin->updated_at}}</td>
                                    <td>
                                        <ul class="d-flex activity-menu flex">
                                            <li class="viewuser">
                                                <a href="{{route('adminCoinEdit', encrypt($coin->id))}}" title="{{__("Update")}}" class="btn btn-primary btn-sm w-1">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                            </li>
                                            @if($coin->currency_type == CURRENCY_TYPE_CRYPTO)
                                                <li class="viewuser">
                                                    <a href="{{route('adminCoinSettings', encrypt($coin->id))}}" title="{{__("Settings")}}" class="btn btn-warning btn-sm">
                                                        <i class="fa fa-regular fa-square-caret-up"></i>
                                                    </a>
                                                </li>
                                            @endif
                                            <li class="viewuser">
                                                <a href="#" onclick="showAlert('{{ encrypt($coin->id) }}')" title="{{__("Delete")}}" class="btn btn-danger btn-sm">
                                                    <i class="fa fa-regular fa-square-caret-up"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                            @endif
                        </tbody>
                </table>
            </div>

        </div>
    </div>

<script>
    $('#myTable').DataTable({
        // processing: true,
        // serverSide: false,
        // paging: true,
        // searching: true,
        // ordering:  true,
        // select: false,
        // bDestroy: true,
        // order: [1, 'desc'],
        // responsive: true,
        // autoWidth: false,
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

    function processForm(active_id) {
        $.ajax({
            type: "POST",
            url: "{{ route('adminCoinStatus') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'active_id': active_id
            },
            success: function (data) {
                console.log(data);
            }
        });
    }

    const showAlert = async (id) => {
        let url = '{{ route("adminCoinDelete") }}/' + id;
        const swalWithBootstrapButtons = window.Swal.mixin({
            confirmButtonClass: 'btn btn-secondary',
            cancelButtonClass: 'btn btn-dark ltr:mr-3 rtl:ml-3',
            buttonsStyling: false,
        });
        swalWithBootstrapButtons
        .fire({
            title: '{{ __('Delete') }}',
            text: "{{ __('Do you want to delete ?')}}",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '{{ __("Yes, delete it!") }}',
            cancelButtonText: '{{  __("No, cancel!") }}',
            reverseButtons: true,
            padding: '2em',
        })
        .then((result) => {
            if (result.value) window.location.href = url;
        });
    }
</script>
</x-layout.default>