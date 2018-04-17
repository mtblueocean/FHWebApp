@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Signup List</b></p>
                    </div>
                    <div class="col-sm-8">

                    </div>
                </div>
                <!--split-->
                <div class="splitterdiv">
                </div><!--split-->
            </div><!--header-->
            <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                <div style="margin-bottom:20px; margin-left: 10%; margin-right:10%;">
                    {!! $chartjs->render() !!}
                </div>
            </div>
            <div class="tablediv">
                <div style="margin-left: 20px; margin-right: 10px;">
                    <select id="PageCount" style="float:right;margin-right: 10px; width:80px; margin-top: 15px" class="form-control selectWidth">
                        <?php
                        $pages = [15, 20, 25, 30, 50, 100, 200];
                        ?>
                        @for ($i = 0; $i <= 6; $i++)
                            <option value="{{$pages[$i]}}">{{$pages[$i]}}</option>
                        @endfor
                    </select>
                    <p id="PageCountLabel" style="float:right;margin-right: 10px; margin-top:20px; font-size: 15px; font-weight: bold"><b>Rows per page: </b></p>
                </div>
                <div id="jsGrid" class="griddiv">
                </div>
            </div>
        </div>
        <form id="toClientOverviewForm" action="{{url('/clientoverview')}}" method="post">
            {!! csrf_field() !!}
            <input type="hidden" name="clientId" id="clientId" class="form-control">
        </form>
    </div>
    <script src="{{asset('js/JSGrid/jsgrid.min.js')}}"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var displayCount = $( "#PageCount option:selected" ).val();

        $("#jsGrid").jsGrid({
            width: "100%",

            scroll:false,
            sorting: true,
            paging: true,

            noDataContent: "No Record Found",
            pageSize:displayCount,
            loadIndication: true,
            loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,
            autoload:true,
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "POST",
                        contentType: "application/json; charset=utf-8",
                        url: "/signuplist",
                        dataType: "json",
                        data: filter
                    });
                }
            },

            fields: [
                {name: "No", type: "number", width: 10},
                {name: "UserName", title:"User Name", type: "text", width: 50},
                {name: "Email", title:"Email", type: "text", width: 50},
                {name: "Type", type: "text", width: 30},
                {name: "SignupDate", title:"SignUp Date", type: "text", width: 30},
                {name: "Programs", type: "number", width: 50, align: 'center'},
                {
                    name: "", type: "text", width: 20, sorting: false, filtering: false,
                    itemTemplate: function (value, item) {
                        var atag = $("<a class='edit-custom-field-link'>").text("View")
                                .on("click", function() {
                                    goToClientOverview(item);
                                    return false;
                                });
                        return atag;
                    }
                },
                {name: "ClientId", type:"text", visible:false, width: 0},
                {name: "ProgramId", type:"text", visible:false, width: 0},
            ],
        });

        $('#PageCount').change(function() {
            var displayCount = $( "#PageCount option:selected" ).val();

            $("#jsGrid").jsGrid("option", "pageSize", displayCount);
        });

        function goToClientOverview(item)
        {
            var clientId = item["ClientId"];
            $("#clientId").val(clientId);
            $("#toClientOverviewForm").submit();
        }
    </script>

@endsection