<x-layout.default>
    <div>
        <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
            <div class="mt-5">
                <table id="myTable" class="">
                    <thead>
                        <tr>
                            <th scope="col" >{{__('Type')}}</th>
                            <th scope="col" class="all">{{__('Sender')}}</th>
                            <th scope="col">{{__('Coin Type')}}</th>
                            <th scope="col">{{__('Address')}}</th>
                            <th scope="col">{{__('Network')}}</th>
                            <th scope="col">{{__('Receiver')}}</th>
                            <th scope="col">{{__('Amount')}}</th>
                            <th scope="col">{{__('Fees')}}</th>
                            <th scope="col">{{__('Transaction Id')}}</th>
                            <th class="text-lg-center all">{{__('Actions')}}</th>
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
                    {"data": "address_type"},
                    {"data": "sender"},
                    {"data": "coin_type"},
                    {"data": "address"},
                    {"data": "network"},
                    {"data": "receiver"},
                    {"data": "amount"},
                    {"data": "fees"},
                    {"data": "transaction_hash"},
                    {"data": "actions"}
                ],
    });
</script>
</x-layout.default>