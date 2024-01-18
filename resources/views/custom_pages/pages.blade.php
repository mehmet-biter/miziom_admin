<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        {{-- <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Admin Setting') }}</h5> --}}
                        <a href="{{ route('adminCustomPageAdd') }}" class="btn btn-primary gap-2 float-right">

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
            <div class="mt-8 px-5">
                <table id="myTable" class="table-hover !pt-5">
                    <thead>
                        <tr>
                            <th scope="col" >{{__('Title')}}</th>
                            <th scope="col" >{{__('Slug')}}</th>
                            <th scope="col" class="all">{{__('Status')}}</th>
                            <th scope="col">{{__('Updated At')}}</th>
                            <th scope="col">{{__('Created At')}}</th>
                            <th class="text-lg-center all">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(isset($pages))
                            @foreach($pages as $p)
                                <tr>
                                    <td class="!px-[18px]"> {{$p->title}} </td>
                                    <td class="!px-[18px]"> {{$p->slug}} </td>
                                    <td class="!px-[18px]">
                                        <div>
                                            <label class="w-12 h-6 relative">
                                                <input onclick="return processForm('{{$p->id}}')" type="checkbox"
                                                    class="custom_switch absolute w-full h-full opacity-0 z-10 cursor-pointer peer"
                                                    id="custom_switch_checkbox4"
                                                    @if($p->status == STATUS_ACTIVE) checked @endif/>
                                                <span for="custom_switch_checkbox4" class="bg-[#ebedf2] dark:bg-dark block h-full rounded-full before:absolute before:left-1 before:bg-white dark:before:bg-white-dark dark:peer-checked:before:bg-white before:bottom-1 before:w-4 before:h-4 before:rounded-full peer-checked:before:left-7 peer-checked:bg-blue-500 before:transition-all before:duration-300"></span>
                                            </label>
                                        </div>
                                    </td>
                                    <td class="!px-[18px]"> {{$p->updated_at}}</td>
                                    <td class="!px-[18px]"> {{$p->created_at}}</td>
                                    <td class="!px-[18px]">
                                        <ul class="flex gap-4 items-center">
                                            <li class="viewuser">
                                                <a href="{{route('adminCustomPageEdit', ($p->id))}}" title="{{__("Update")}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="16" viewBox="0 0 512 512" class="fill-gray-400">
                                                        <path d="M441 58.9L453.1 71c9.4 9.4 9.4 24.6 0 33.9L424 134.1 377.9 88 407 58.9c9.4-9.4 24.6-9.4 33.9 0zM209.8 256.2L344 121.9 390.1 168 255.8 302.2c-2.9 2.9-6.5 5-10.4 6.1l-58.5 16.7 16.7-58.5c1.1-3.9 3.2-7.5 6.1-10.4zM373.1 25L175.8 222.2c-8.7 8.7-15 19.4-18.3 31.1l-28.6 100c-2.4 8.4-.1 17.4 6.1 23.6s15.2 8.5 23.6 6.1l100-28.6c11.8-3.4 22.5-9.7 31.1-18.3L487 138.9c28.1-28.1 28.1-73.7 0-101.8L474.9 25C446.8-3.1 401.2-3.1 373.1 25zM88 64C39.4 64 0 103.4 0 152V424c0 48.6 39.4 88 88 88H360c48.6 0 88-39.4 88-88V312c0-13.3-10.7-24-24-24s-24 10.7-24 24V424c0 22.1-17.9 40-40 40H88c-22.1 0-40-17.9-40-40V152c0-22.1 17.9-40 40-40H200c13.3 0 24-10.7 24-24s-10.7-24-24-24H88z"/>
                                                    </svg>
                                                </a>
                                            </li>
                                            <li class="viewuser">
                                                <a href="#" onclick="showAlert('{{ ($p->id) }}')" title="{{__("Delete")}}">
                                                    <svg xmlns="http://www.w3.org/2000/svg" height="16" width="14" viewBox="0 0 448 512" class="fill-gray-400">
                                                        <path d="M135.2 17.7L128 32H32C14.3 32 0 46.3 0 64S14.3 96 32 96H416c17.7 0 32-14.3 32-32s-14.3-32-32-32H320l-7.2-14.3C307.4 6.8 296.3 0 284.2 0H163.8c-12.1 0-23.2 6.8-28.6 17.7zM416 128H32L53.2 467c1.6 25.3 22.6 45 47.9 45H346.9c25.3 0 46.3-19.7 47.9-45L416 128z"/>
                                                    </svg>
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
            url: "{{ route('customPagestatus') }}",
            data: {
                '_token': "{{ csrf_token() }}",
                'id': active_id
            },
            success: function (data) {
                console.log(data);
            }
        });
    }

    const showAlert = async (id) => {
        let url = '{{ route("adminCustomPageDelete") }}/' + id;
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