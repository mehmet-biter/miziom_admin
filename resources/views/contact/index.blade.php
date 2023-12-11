<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="px-5">
                <div class=" md:top-5 ltr:md:left-5 rtl:md:right-5">
                    <div class="flex items-center gap-2 mb-5">
                        
                    </div>
                </div>
            </div>
            <div class="mt-5">
                <table id="myTable" class="">
                    <thead>
                        <tr>
                            <th class="all">{{__('Name')}}</th>
                            <th>{{__('Email')}}</th>
                            <th>{{__('Subject')}}</th>
                            <th class="all">{{__('Created At')}}</th>
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
            ajax: '{{route('contactList')}}',
            order: [3, 'desc'],
            responsive: true,
            autoWidth: false,
            columns: [
                    {"data": "name", "orderable": false},
                    {"data": "email", "orderable": true},
                    {"data": "subject", "orderable": false},
                    {"data": "created_at", "orderable": true},
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
