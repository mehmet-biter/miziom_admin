<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mt-5">
                <table id="myTable" class="">
                    <thead>
                        <tr>
                            <th>{{__('User')}}</th>
                                <th class="all">{{__('Address')}}</th>
                                <th>{{__('From Address')}}</th>
                                <th>{{__('Coin Type')}}</th>
                                <th>{{__('Coin API')}}</th>
                                <th class="all">{{__('Amount')}}</th>
                                <th >{{__('Transaction Id')}}</th>
                                <th>{{__('Date')}}</th>
                                <th class="all">{{__('Actions')}}</th>
                        </tr>
                        </thead>
                </table>
            </div>

        </div>
    </div>

<script>
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
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
        columns: [
            {"data": "receiver_wallet_id"},
            {"data": "address"},
            {"data": "from_address"},
            {"data": "coin_type"},
            {"data": "network_type"},
            {"data": "amount"},
            {"data": "transaction_id"},
            {"data": "created_at"},
            {"data": "actions"}
        ],
    });
</script>
</x-layout.default>