@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Programs List</b></p>
                    </div>
                    <div class="col-sm-8">

                    </div>
                </div>
                <!--split-->
                <div class="splitterdiv">
                </div><!--split-->
            </div><!--header-->

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
                <div id="jsGrid" class="griddiv"></div>
            </div>
        </div>
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
            deleteConfirm: "Do you really want to delete the client?",
            autoload:true,
            controller: {
                loadData: function(filter) {
                    return $.ajax({
                        type: "POST",
                        contentType: "application/json; charset=utf-8",
                        url: "/myprograms",
                        dataType: "json",
                        data: filter
                    });
                }
            },

            fields: [
                {name: "No", title:"No.", align:"center", type:"number", inserting:false, editing:false, filtering:false, width: 20},
                {name: "ProgramName", title:"Program Name", type: "text"},
                {name: "ProgramType", title:"Type", align:"center", type: "text", width:40},
                {name: "ProgramCreated", title:"Created", align:"center", type: "text", width:40},
                {name: "ProgramModified", title:"Modified", align:"center", type: "text", width:40},
                {name: "SignUps", title:"Sign Ups", align:"right", type: "text", width:30},
                {name: "Available", title:"Availability", align:"center", type: "text", width:35},
                {name: "Status", title:"Status", align:"center", type: "text", width:40,
                    itemTemplate: function (value, item) {
                        var status = item["Status"];

                        if(status == "Published")
                        {
                            return '<a style="color: #2ea14b">Published</a>';
                        }
                        else
                        {
                            return '<a style="color: #c9302c">Editing...</a>';
                        }
                    }
                },
                {
                    name: "", type: "text", width: 20, sorting: false, filtering: false,
                    itemTemplate: function (value, item) {
                        var editUrl = item["EditUrl"];
                        return '<div class="edit-container"><a class="edit-custom-field-link"  href="' + editUrl + '">Edit</a></div>';
                    }
                },
                {name: "ProgramId", type:"text", visible:false, width: 0},

            ],
        });

        $('#PageCount').change(function() {
            var displayCount = $( "#PageCount option:selected" ).val();

            $("#jsGrid").jsGrid("option", "pageSize", displayCount);
        });
    </script>

@endsection
