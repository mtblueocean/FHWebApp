@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
<!--                        <p style="margin-bottom:10px;margin-top:19px;margin-left:40px;font-size: 30px; font-weight: bold"><b>Client Details</b></p>-->
                        <img id="navProfilePic" class="img-circle" style="width: 45px; margin-bottom:10px;margin-top:19px;margin-left:40px;"
                             @if ($userinfo->user_profilepicurl == "")
                             src="{{asset('images/dashboard/emptyprofile.jpg')}}"
                             @else
                             src="{{asset($userinfo->user_profilepicurl)}}"
                             @endif
                             alt="" />
                        <label style="margin-top: 20px; vertical-align:middle; margin-left: 10px; font-size: 18px"><?php echo $userinfo->name;?></label>

                        <label style="color: #1f5aa1; margin-top: 23px; vertical-align: middle; margin-left: 20px" onclick="goToClientOverview()">Return to Overview</label>
                    </div>
                    <div class="col-sm-8">
                        <form class="form switchprogramform" id="ProgramtypeSelectForm" method="post">
                            {!! csrf_field() !!}
                            <div class="btn-group btn-toggle" data-toggle="buttons">
                                @if ($programType == 1)
                                    <label class="btn btn-info active">
                                        <input type="radio" name="options">  Workout
                                    </label>
                                    <label class="btn btn-default">
                                        <input type="radio" name="options" checked=""> Nutrition
                                    </label>
                                @elseif($programType == 2)
                                    <label class="btn btn-default">
                                        <input type="radio" name="options" checked="">  Workout
                                    </label>
                                    <label class="btn btn-info active">
                                        <input type="radio" name="options"> Nutrition
                                    </label>
                                @endif
                            </div>
                        </form>

                        <div style="margin-right:35px; float: right; ;margin-top:30px;">
                            <p style="float: left; margin-bottom:10px;font-size: 15px; font-weight: bold"><b>Week</b></p>
                            <select id="selectWeek" style="margin-left:10px; width:150px; margin-top: -7px" class="form-control selectWidth">
                                @if($programweeks == 0)
                                    <option value="0" disabled selected>No Weeks</option>
                                @else
                                    <option value="1" selected >Week 1</option>
                                    @for($i = 2; $i <= $programweeks; $i ++ )
                                        <option value="{{$i}}">Week {{$i}}</option>
                                    @endfor
                                @endif
                            </select>
                        </div>

                        <div style="text-align:center;margin-top:20px;float: right; margin-right: 40px">
                            <button id="daybtn1" class="weekview futureday" href="{{ url('/') }}">Mo</button>
                            <button id="daybtn2" class="weekview futureday"  href="{{ url('/') }}">Tu</button>
                            <button id="daybtn3" class="weekview futureday"  href="{{ url('/') }}">We</button>
                            <button id="daybtn4" class="weekview futureday"  href="{{ url('/') }}">Th</button>
                            <button id="daybtn5" class="weekview futureday"  href="{{ url('/') }}">Fr</button>
                            <button id="daybtn6" class="weekview restday"  href="{{ url('/') }}">Sa</button>
                            <button id="daybtn7" class="weekview restday"  href="{{ url('/') }}">Su</button>
                        </div>
                    </div>
                </div>
                <!--split-->
                <div class="splitterdiv">
                </div><!--split-->
            </div><!--header-->

            <div class="tablediv">
                <div style="margin-left: 20px; margin-right: 10px;">
                    <p id="ProgramName" name="ProgramName" style="margin-top: 15px; float: left; font-size: 20px; font-weight: bold"><b>{{$programName}}</b></p>
                    <!--<p id="DayNo" style="margin-top: 15px; float: left; margin-left: 20px;font-size: 20px; font-weight: bold"><b></b></p>-->

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

    <form id="toClientOverviewForm" action="{{url('/clientoverview')}}" method="post">
        {!! csrf_field() !!}
        <input type="hidden" name="clientId" id="clientId" class="form-control">
    </form>


    <div class="modal fade" id="SetInfoModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 70%" >
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close customed" style="margin-top: -10px; margin-right:-10px" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <form>
                        <!-- content goes here -->
                        <div style="width:100%; display: table; vertical-align: bottom">
                            <p id="exTitleLabel" style="margin-left:30px; margin-top: 20px; font-size: 26px;color: #424242; float: left; font-weight: bold;">Exercise Detail</p>
                        </div>
                        <div class="splitterdiv">
                        </div><!--split-->
                        <div class="tablediv">
                            <p id="pExName" style="margin-top: 15px; float: left; margin-left: 20px;font-size: 20px; font-weight: bold"><b></b></p>
                            <div style="margin-left: 20px;">
                                <select id="setdetailPageCount" style="float:right; width:80px; margin-top: 15px" class="form-control selectWidth">
                                    <?php
                                    $pages = [15, 20, 25, 30, 50, 100, 200];
                                    ?>
                                    @for ($i = 0; $i <= 6; $i++)
                                        <option value="{{$pages[$i]}}">{{$pages[$i]}}</option>
                                    @endfor
                                </select>
                                <p id="PageCountLabel" style="float:right;margin-right: 10px; margin-top:20px; font-size: 15px; font-weight: bold"><b>Rows per page: </b></p>
                            </div>
                            <div id="setGrid" class="griddiv"></div>
                        </div>
                    </form>
                </div>
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

        var programtype = "<?php echo $programType?>";
        var userID = "<?php echo $userID?>";
        var errno = "<?php echo $errno?>";
        var programID = "<?php echo $programID?>";
        if(errno == "1")
        {
            showAlert("No Active WorkoutProgram");
        }
        else if(errno == "2")
        {
            showAlert("No Active NutritionProgram");
        }

        $('.btn-toggle').click(function() {
            var url = "";
            if(programtype == "1")
            {
                programtype == "2"
                url = "/clientoverview/" + userID + "/nutrition";
            }
            else if(programtype == "2")
            {
                url = "/clientoverview/" + userID + "/workout";
            }

            $('#ProgramtypeSelectForm').method = "POST";
            $('#ProgramtypeSelectForm').url = url;
            $(this).find('.btn').toggleClass('active');

            if ($(this).find('.btn-info').size()>0) {
                $(this).find('.btn').toggleClass('btn-info');
            }

            $('#ProgramtypeSelectForm').attr('action', url).submit();
        });

        var Days = [
            { Name: "1", Id: 1 },
            { Name: "2", Id: 2 },
            { Name: "3", Id: 3 },
            { Name: "4", Id: 4 },
            { Name: "5", Id: 5 },
            { Name: "6", Id: 6 },
            { Name: "7", Id: 7 }
        ]

        var DayType = [
            { Name: "Active", Id: 1 },
            { Name: "Rest", Id: 0 }
        ];

        var MuscleGroup = [
            { Name: "Compound", Id: 1 },
            { Name: "Abdominals", Id: 2 },
            { Name: "Back", Id: 3 },
            { Name: "Biceps", Id: 4 },
            { Name: "Chest", Id: 5 },
            { Name: "Foreamrs", Id: 6 },
            { Name: "Legs", Id: 7 },
            { Name: "Shoulders", Id: 8 },
            { Name: "Trapezius", Id: 9 },
            { Name: "Triceps", Id: 10 }
        ];

        var ExerciseType = [
            { Name: "Strength", Id: 0 },
            { Name: "Conditioning", Id: 1 }
        ];

        var MealType = [
            { Name: "Breakfast", Id: 1 },
            { Name: "Lunch", Id: 2 },
            { Name: "Dinner", Id: 3 },
            { Name: "Snack", Id: 4 },
            { Name: "Supplement", Id: 5 }
        ];

        var QuantityType = [
            { Name: "Grams", Id: 1 },
            { Name: "Cup", Id: 2 },
            { Name: "Ounce", Id: 3 },
            { Name: "Teaspoon", Id: 4 },
            { Name: "Tablespoon", Id: 5 }
        ];
        var displayCount = $( "#PageCount option:selected" ).val();
        var setGridCount = $("#setdetailPageCount option:selected" ).val();

        if(programtype == "1")
        {
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

                controller: {
                    loadData: function(filter) {
                        var selectedWeekIndex = $( "#selectWeek option:selected").val();
                        if(errno == "3")
                        {
                            var postdata = {
                                SelectedWeek: selectedWeekIndex,
                                UserID: userID,
                                ProgramID: programID
                            };

                            return $.ajax({
                                type: "POST",
                                url: "/workoutdetail",
                                dataType: "json",
                                data: postdata
                            });
                        }
                    }
                },
                fields: [
                    {name: "Date", title:"Date", type: "text", width: 30, align:"center"},
                    {name: "Day", title:"Day", type: "text", width: 30, align:"left"},
                    {name: "Muscle", title:"MuscleGroup", type: "text", width: 30, align:"center"},
                    {name: "ExName", title:"Exercise Name", type: "text", width: 40, align:"left"},
                    {name: "ExType", title:"Exercise Type", type: "text", width: 30, align:"center"},
                    {name: "Sets", title:"Set Count", type: "text",width: 20, align:"center"},
                    {
                        name: "SetsInfos",
                        title: "Set Info",
                        width: 30,
                        sorting: false,
                        filtering: false,
                        align: "center",
                        itemTemplate: function(value, item) {
                            return $("<img style='width: 25px; height:25px;' src='{{asset('images/home/setinfo.png')}}'/>").click(function(){
                                showSetInfoDialog(item);
                                return false;
                            });
                            /*return $("<button style='color: #345ef8; background:url(../images/home/setinfo.png);background-repeat: no-repeat;'>").text("...")
                                    .on("click", function () {
                                        showSetInfoDialog(item);
                                        return false;
                                    });*/
                        }
                    },
                    {
                        name: "Status", title:"Status", width: 20, sorting: false, filtering: false, align:"center",

                        itemTemplate: function(value, item) {
                            var complete = item["Completed"];

                            if(complete == 0)
                            {
                                return $("<img style='width: 21px; height:27px;' src='{{asset('images/home/uncheck.png')}}'/>");
                            }
                            else
                            {
                                return $("<img style='width: 21px; height:27px;' src='{{asset('images/home/check.png')}}'/>");
                            }
                        }
                    },
                    {name: "Completed", type:"text", visible:false, width: 30},
                    {name: "SetContent", type:"text", visible:false, width: 30},
                    {name: "Exid", type:"text", visible:false, width: 30},
                ],

                onDataLoading: function(args) {
                    var selectedWeekIndex = $("#selectWeek option:selected").val();

                    if (selectedWeekIndex == 0) {
                        args.cancel = true;
                    }
                },
                invalidNotify: function(args) {
                    var message = args.errors[0]["message"];
                    showAlert(message);
                },
            });
        }
        else if(programtype == "2")
        {
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
                deleteConfirm: "Do you really want to delete the food?",

                controller: {
                    loadData: function(filter) {
                        var selectedWeekIndex = $( "#selectWeek option:selected").val();
                        if(errno == "3")
                        {
                            var postdata = {
                                SelectedWeek: selectedWeekIndex,
                                UserID: userID,
                                ProgramID: programID
                            };

                            return $.ajax({
                                type: "POST",
                                url: "/nutritiondetail",
                                data: postdata,
                                dataType: "json"
                                //contentType: "application/json; charset=utf-8",
                            });
                        }
                    }
                },

                fields: [
                    {name: "Date", title:"Date", type: "text", width: 30, align:"center"},
                    {name: "Day", title:"Day", type: "text", width: 20, align:"left"},
                    {name: "Meal", title:"Meal", type: "text", width: 40, align:"left"},
                    {name: "Food", title:"Food", type: "text",width: 50, align:"left"},
                    {name: "Qty", title:"Qty", type: "text", width: 20, align:"right"},
                    {name: "Measurement", title:"Measurement", type: "text", width: 30, align:"center"},
                    {name: "Protein", title:"Protein(G)", type: "text", width: 20, align:"center"},
                    {name: "Carbs", title:"Carbs(G)", type: "text", width: 20, align:"center"},
                    {name: "Fat", title:"Fat(G)", type: "text", width: 20, align:"center"},
                    {name: "Calories", title:"Calories(G)", type: "text", width: 20, align:"center"},
                    {
                        name: "Status", title:"Status", width: 20, sorting: false, filtering: false, align:"center",

                        itemTemplate: function(value, item) {
                            var complete = item["Completed"];

                            if(complete == 0)
                            {
                                return $("<img style='width: 21px; height:27px;' src='{{asset('images/home/uncheck.png')}}'/>");
                            }
                            else
                            {
                                return $("<img style='width: 21px; height:27px;' src='{{asset('images/home/check.png')}}'/>");
                            }
                        }
                    },
                    {name: "Completed", type:"text", visible:false, width: 30}
                ],

                onDataLoading: function(args) {
                    var selectedWeekIndex = $("#selectWeek option:selected").val();

                    if (selectedWeekIndex == 0) {
                        args.cancel = true;
                    }
                },

                invalidNotify: function(args) {
                    var message = args.errors[0]["message"];
                    showAlert(message);
                },
            });
        }

        $('#selectWeek').change(function() {
            var weektext = $( "#selectWeek option:selected" ).text();
            var selectedWeekIndex = $( "#selectWeek option:selected").val();

            $("#jsGrid").jsGrid("loadData");

            var postUrl = "/weekdetail";

            var postdata = {
                ProgramID: programID,
                UserID : userID,
                SelectedWeek : selectedWeekIndex,
                ProgramType : programtype
            };

            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {

                    $('#daybtn1').css('background', data['result'][0]['color']);
                    $('#daybtn1').html(data['result'][0]['day']);

                    $('#daybtn2').css('background', data['result'][1]['color']);
                    $('#daybtn2').html(data['result'][1]['day']);

                    $('#daybtn3').css('background', data['result'][2]['color']);
                    $('#daybtn3').html(data['result'][2]['day']);

                    $('#daybtn4').css('background', data['result'][3]['color']);
                    $('#daybtn4').html(data['result'][3]['day']);

                    $('#daybtn5').css('background', data['result'][4]['color']);
                    $('#daybtn5').html(data['result'][4]['day']);

                    $('#daybtn6').css('background', data['result'][5]['color']);
                    $('#daybtn6').html(data['result'][5]['day']);

                    $('#daybtn7').css('background', data['result'][6]['color']);
                    $('#daybtn7').html(data['result'][6]['day']);
                },
                error: function (result) {

                }
            });
        });


        $('#PageCount').change(function() {
            var displayCount = $( "#PageCount option:selected" ).val();

            $("#jsGrid").jsGrid("option", "pageSize", displayCount);
        });

        $('#setdetailPageCount').change(function() {
            var setdisplayCount = $( "#setdetailPageCount option:selected" ).val();

            $("#setGrid").jsGrid("option", "pageSize", displayCount);
        });

        $('document').ready(function () {
            if(errno == 3)
            {
                $("#selectWeek").change();
            }
        });

        var selectedworkoutIndex = 0;
        function showSetInfoDialog(item)
        {
            selectedworkoutIndex = item['Exid'];
            $('#pExName').text(item['ExName']);
            $("#setGrid").jsGrid("loadData");
            $('#SetInfoModal').modal();
        }

        $('#SetInfoModal').on('hidden.bs.modal', function () {
            dismissmodal();
        })

        function goToClientOverview()
        {
            $("#clientId").val(userID);
            $("#toClientOverviewForm").submit();
        }

        function dismissmodal()
        {

        }

        $("#setGrid").jsGrid({
            width: "100%",

            scroll:false,
            sorting: true,
            paging: true,
            noDataContent: "Not Rcord Set Yet",
            pageSize:setGridCount,
            loadIndication: true,
            loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,
            deleteConfirm: "Do you really want to delete the food?",

            controller: {
                loadData: function(filter) {
                    if(errno == "3")
                    {
                        var postdata = {
                            ClientWorkoutID: selectedworkoutIndex,
                        };

                        return $.ajax({
                            type: "POST",
                            url: "/exercisedetail",
                            data: postdata,
                            dataType: "json"
                        });
                    }
                }
            },

            fields: [
                {name: "SetNo", title:"Set No.", type: "text", width: 30, align:"center"},
                {name: "Value", title:"Weight / Time", type: "text", width: 40, align:"center"},
                {name: "Reps", title:"Reps", type: "text", width: 30, align:"center"},
                {name: "LastSession", title:"Last Session", type: "text",width: 40, align:"center"},
                {name: "Rest", title:"Rest Time / Cool Down", type: "text", width: 50, align:"center"}
            ]
        });
    </script>
@endsection