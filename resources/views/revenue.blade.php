@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                <div>
                    <p style="margin-bottom:20px;margin-left:20px;font-size: 30px; font-weight: bold"><b>Revenue</b></p>
                </div>
                <div style="margin-bottom:20px; margin-left: 10%; margin-right:10%;">
                    {!! $chartjs->render() !!}
                </div>
            </div>
            <div class="tablediv">
                <div id="jsGrid" class="griddiv">
                </div>
            </div>
        </div>
    </div>

<script src="{{asset('js/jquery.js')}}"></script>
<script src="{{asset('js/JSGrid/jsgrid.min.js')}}"></script>
<script>
    var clients = [
/*
        {"No": 1, "TransactionId": "1224", "Product": "Lean Gains", "Program":"Nutrition", "Type": "Public", "SalesAmount": "$47", "NetSale": "$44.85", "Purchaser": "Demo780", "Date": "mm-dd-yyyy", "Status": "Refunded"},
        {"No": 2, "TransactionId": "1225", "Product": "Accelerated Cuts", "Program":"Workout", "Type": "Public", "SalesAmount": "$47", "NetSale": "$44.85", "Purchaser": "Demo780", "Date": "mm-dd-yyyy", "Status": "Completed"}*/
    ];

    $("#jsGrid").jsGrid({
        width: "100%",

        scroll:false,
        sorting: true,
        paging: true,


        noDataContent: "No Record Found",
        loadIndication: true,
        loadIndicationDelay: 500,
        loadMessage: "Please, wait...",
        loadShading: true,
        deleteConfirm: "Do you really want to delete the client?",

        pagesize: 15,

        data: clients,

        fields: [
            {name: "No", title:"No.", type: "number", width: 10},
            {name: "TransactionId", title:"Transaction ID", type: "number", width:20},
            {name: "Product", type: "text", width: 60},
            {name: "Program", type: "text", width: 20},
            {name: "Type", type: "text", width: 20},
            {name: "SalesAmount", title: "Sale Amount", type: "number", width: 20},
            {name: "NetSale", title: "Net Sale", type: "number", width: 20},
            {name: "Purchaser", title: "Purchaser", type: "number", width: 25},
            {name: "Date", title: "Date", type: "number", width: 25},
            {name: "Status", title: "Status", type: "number", width: 20},
        ]
    });
</script>

@endsection