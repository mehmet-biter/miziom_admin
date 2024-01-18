<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        {{-- <h5 class="font-semibold text-lg dark:text-white-light">{{ __('Admin Setting') }}</h5> --}}
                        <a href="{{ route('roleAdd') }}" class="btn btn-primary gap-2 float-right">

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
                            <th class="all">{{__('Role')}}</th>
                            <th >{{__('Created At')}}</th>
                            <th class="all">{{__('Status')}}</th>
                            <th class="text-lg-center all">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                </table>
            </div>

        </div>
    </div>

    <script>
        $('#myTable').DataTable({
            processing: true,
            serverSide: false,
            paging: true,
            searching: true,
            ordering:  true,
            select: false,
            bDestroy: true,
            ajax: '{{route('roleList')}}',
            order: [1, 'desc'],
            responsive: true,
            autoWidth: false,
            columns: [
                    {"data": "title", "orderable": true},
                    {"data": "created_at", "orderable": true},
                    {"data": "status", "orderable": true},
                    {"data": "actions", "orderable": false}
                ],
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
