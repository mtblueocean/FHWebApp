@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:22px;margin-left:40px;font-size: 30px; font-weight: bold"><b>{{$programName}}</b></p>
                    </div>
                    <div class="col-sm-8">
                        <div style="margin-left:40px; float: left; ;margin-top:30px;">
                            <p style="float: left; margin-bottom:10px;font-size: 15px; font-weight: bold"><b>Week</b></p>
                            <select id="selectWeek" style="margin-left:10px; width:150px; margin-top: -7px" class="form-control selectWidth">
                                <option value="1" selected>Week 1</option>

                                @if ($noWeeks > 1)
                                    @for ($i = 2; $i <= $noWeeks; $i++)
                                        <option value="{{$i}}">Week {{$i}}</option>
                                    @endfor
                                @endif
                            </select>
                        </div>

                        <div style="margin-left:40px; float: left; ;margin-top:30px;">
                            <p style="float: left; margin-bottom:10px;font-size: 15px; font-weight: bold"><b>Day</b></p>
                            <select id="selectDay" style="margin-left:10px;  width:150px; margin-top: -7px" class="form-control selectWidth">
                                <?php
                                $days = ["All", "Day 1", "Day 2", "Day 3", "Day 4","Day 5", "Day 6", "Day 7"];
                                ?>
                                <option value="-1" selected disabled>Select Day...</option>
                                @for ($i = 0; $i <= 7; $i++)
                                    <option value="{{$i}}">{{$days[$i]}}</option>
                                @endfor
                            </select>
                        </div>
                        <div style="width:30%; margin-right:30px; float: right; ;margin-top:18px;" class="editworkout">
                            <button type="button" class="next-but" style="margin-right: 5px" onclick="window.location='{{ url($nexturl) }}'">Next</button>
                            <button type="button" class="back-but" onclick="window.location='{{ url($backurl) }}'">Back</button>
                        </div>
                    </div>
                </div>
                <!--split-->
                <div class="splitterdiv">
                </div><!--split-->
                <div class="tablediv">
                    <div style="margin-left: 20px; margin-right: 10px;">
                        <p  style="margin-top: 15px; float: left; font-size: 20px; font-weight: bold"><b>Add an exercise</b></p>
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
            </div><!--header-->
        </div>
    </div>

    <!--ChangeBillingMethod Modal-->
    <div class="modal fade" id="SetModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" >
            <div class="modal-content" style="background-color: #f3f1f5">
                <button type="button" class="close customed" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                <h3 class="registerModalTitleDescription" id="linemodeldescription"><strong>Edit Set Info</strong></h3>

                <div class="modal-body">
                    <!-- content goes here -->
                    <form id="SetInfoForm">
                        <div class="modal-form" style="padding: 30px 30px 15px 30px">
                            <div>
                                <input type="hidden" id="workoutidvalue" class="form-control">
                                <input type="hidden" id="setcountvalue" class="form-control">
                                <div style="text-align: center">
                                    <label style="font-size: 20px; font-weight: bold">Total Sets:</label>
                                    <label id="setcountlabel" style="font-size: 20px;font-weight: bold"></label>
                                </div>
                            </div>
                            <div class="setinfodivider"></div>

                            <div id="SetInfoBody" style="text-align: center">
                                <!-----  ADDED JAVASCRIPT  ------>
                            </div>
                        </div>


                    <div class="row" style="margin-top: 30px">
                        <div class="col-sm-6">
                            <button id="modalCancel" type="button" style="width: 98%; height: 50px; background-color: white;color: #424242; font-weight: bold" class="btn btn-default">Cancel</button>
                        </div>
                        <div class="col-sm-6">
                            <button id="modalSave" type="submit" style="width: 98%; height: 50px; background-color: #8dcea5;color: white; font-weight: bold" class="btn btn-default">Save</button>
                        </div>
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
            { Name: "Forearms", Id: 6 },
            { Name: "Legs", Id: 7 },
            { Name: "Shoulders", Id: 8 },
            { Name: "Trapezius", Id: 9 },
            { Name: "Triceps", Id: 10 }
        ];
        var ExerciseType = [
            { Name: "Strength", Id: 0 },
            { Name: "Conditioning", Id: 1 }
        ];

        var displayCount = $( "#PageCount option:selected" ).val();

        $("#jsGrid").jsGrid({
            width: "100%",

            scroll:false,
            sorting: true,
            paging: true,
            editing: true,
            inserting: true,

            noDataContent: "No Record Found",
            pageSize:displayCount,
            loadIndication: true,
            loadIndicationDelay: 500,
            loadMessage: "Please, wait...",
            loadShading: true,
            deleteConfirm: "Do you really want to delete the exercise?",

            controller: {
                    loadData: function(filter) {
                        var selectedWeekIndex = $( "#selectWeek option:selected").val();
                        var selectedDayIndex = $( "#selectDay option:selected").val();

                        filter['SelectedWeek'] = selectedWeekIndex;
                        filter['SelectedDay'] = selectedDayIndex;
                        filter['ProgramId'] = "<?php echo $programid;?>";
                        filter['ProgramType'] = "<?php echo $programtype?>";

                        return $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                            dataType: "json",
                            data: filter
                        });
                },
                insertItem: function(item) {
                    var selectedWeekIndex = $( "#selectWeek option:selected").val();
                    var selectedDayIndex = item['Day'];
                    item['ProgramId'] = "<?php echo $programid;?>";
                    item['Week'] = selectedWeekIndex;
                    item['ProgramType'] = "<?php echo $programtype?>";

                    var dayType = item['DayType'];
                    console.log(dayType);

                    if(dayType == 0) {
                        var box = bootbox.confirm({
                            title: "Set Week" + selectedWeekIndex + " Day " + selectedDayIndex + " as RestDay ",
                            message: "If you have already exercise info for the selected day, they'll be cleared!<br/>" +
                            "Do you want to continue?",
                            buttons: {
                                cancel: {
                                    label: '<i class="fa fa-times"></i> Cancel'
                                },
                                confirm: {
                                    label: '<i class="fa fa-check"></i> OK'
                                }
                            },
                            callback: function (result) {
                                if (result == true) {
                                    $.ajax({
                                        type: "POST",
                                        url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                                        data: item
                                    });
                                    reloadTableData();
                                }
                                else {
                                    return;
                                }
                            }
                        });

                        box.find('.modal-content').css({
                            'background-color': '#fff',
                            'text-align': 'center',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '25px'
                        });
                        box.find('.modal-footer').css({'text-align': 'center', 'height': '70px'});
                        box.find(".btn-default").removeClass("btn-default").css({
                            'width': '100px',
                            'height': '40px',
                            'background-color': 'white',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '20px'
                        });
                        box.find(".btn-primary").removeClass("btn-primary").css({
                            'width': '100px',
                            'height': '40px',
                            'margin-left': '50px',
                            'background-color': '#fff',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '20px'
                        });
                    }
                    else
                    {
                        return $.ajax({
                            type: "POST",
                            url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                            data: item
                        });
                    }
                },
                updateItem: function(item) {
                    var selectedWeekIndex = $( "#selectWeek option:selected").val();
                    var selectedDayIndex = item['Day'];
                    item['ProgramId'] = "<?php echo $programid;?>";
                    item['Week'] = selectedWeekIndex;
                    item['ProgramType'] = "<?php echo $programtype?>";
                    var dayType = item['DayType'];
                    console.log(dayType);

                    if(dayType == 0) {
                        var box = bootbox.confirm({
                            title: "Set Week" + selectedWeekIndex + " Day " + selectedDayIndex + " as RestDay ",
                            message: "If you have already exercise info for the selected day, they'll be cleared!<br/>" +
                            "Do you want to continue?",
                            buttons: {
                                cancel: {
                                    label: '<i class="fa fa-times"></i> Cancel'
                                },
                                confirm: {
                                    label: '<i class="fa fa-check"></i> OK'
                                }
                            },
                            callback: function (result) {
                                if (result == true) {
                                    $.ajax({
                                        type: "PUT",
                                        url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                                        data: item
                                    });
                                    reloadTableData();
                                }
                                else {
                                    return;
                                }
                            }
                        });

                        box.find('.modal-content').css({
                            'background-color': '#fff',
                            'text-align': 'center',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '25px'
                        });
                        box.find('.modal-footer').css({'text-align': 'center', 'height': '70px'});
                        box.find(".btn-default").removeClass("btn-default").css({
                            'width': '100px',
                            'height': '40px',
                            'background-color': '#fff',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '20px'
                        });
                        box.find(".btn-primary").removeClass("btn-primary").css({
                            'width': '100px',
                            'height': '40px',
                            'margin-left': '50px',
                            'background-color': '#fff',
                            'font-weight': 'bold',
                            color: '#333',
                            'font-size': '20px'
                        });
                    }
                    else
                    {
                        return $.ajax({
                            type: "PUT",
                            url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                            data: item
                        });
                    }
                },
                deleteItem: function(item) {
                    item['ProgramType'] = "<?php echo $programtype?>";
                    return $.ajax({
                        type: "DELETE",
                        url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/data",
                        data: item
                    });
                }
            },

            fields: [
                {name: "No", title:"No.", align:"center", type:"number", inserting:false, editing:false, filtering:false, width: 20},
                {name: "Day", title:"Day", type: "select", items: Days, valueField: "Id", textField: "Name", width: 30, validate: { message: "Day should be specified", validator: function(value) { return value >= 1; } }},
                {
                    name: "DayType",
                    title:"Day Type",
                    type: "select",
                    items: DayType, valueField: "Id", textField: "Name",
                    width: 30,
                    validate: { message: "Day type should be specified", validator: function(value) { return value >= 0; } },

                    insertTemplate: function() {
                        var MuscleField = this._grid.fields[3];
                        var ExerciseNameField = this._grid.fields[4];
                        var ExerciseTypeField = this._grid.fields[5];
                        var ExerciseSetCount = this._grid.fields[6];

                        var $insertControl = jsGrid.fields.select.prototype.insertTemplate.call(this);

                        MuscleField.inserting = true;
                        ExerciseNameField.inserting = true;
                        ExerciseTypeField.inserting = true;
                        ExerciseSetCount.inserting = true;

                        $(".muscle-insert").empty().append(MuscleField.insertTemplate());
                        $(".exercisename-insert").empty().append(ExerciseNameField.insertTemplate());
                        $(".exercisetype-insert").empty().append(ExerciseTypeField.insertTemplate());
                        $(".setcount-insert").empty().append(ExerciseSetCount.insertTemplate());

                        $insertControl.on("change", function() {
                            var selectedDayType = $(this).val();
                            if(selectedDayType == 0)
                            {
                                MuscleField.inserting = false;
                                ExerciseNameField.inserting = false;
                                ExerciseTypeField.inserting = false;
                                ExerciseSetCount.inserting = false;
                            }
                            else
                            {
                                MuscleField.inserting = true;
                                ExerciseNameField.inserting = true;
                                ExerciseTypeField.inserting = true;
                                ExerciseSetCount.inserting = true;
                            }

                            $(".muscle-insert").empty().append(MuscleField.insertTemplate());
                            $(".exercisename-insert").empty().append(ExerciseNameField.insertTemplate());
                            $(".exercisetype-insert").empty().append(ExerciseTypeField.insertTemplate());
                            $(".setcount-insert").empty().append(ExerciseSetCount.insertTemplate());
                        });
                        return $insertControl;
                    },

                    editTemplate: function(value) {

                        //var DayField = this._grid.fields[1];
                        var MuscleField = this._grid.fields[3];
                        var ExerciseNameField = this._grid.fields[4];
                        var ExerciseTypeField = this._grid.fields[5];
                        var ExerciseSetCount = this._grid.fields[6];
                        var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                        var changeDaytype = function() {
                            var selectedDayType = $editControl[0].selectedIndex;
                            console.log("Change = " + selectedDayType);
                            if(selectedDayType == 1)
                            {
                                //DayField.editing = false;
                                MuscleField.editing = false;
                                ExerciseNameField.editing = false;
                                ExerciseTypeField.editing = false;
                                ExerciseSetCount.editing = false;
                            }
                            else
                            {
                                //DayField.editing = true;
                                MuscleField.editing = true;
                                ExerciseNameField.editing = true;
                                ExerciseTypeField.editing = true;
                                ExerciseSetCount.editing = true;
                            }

                            //$(".day-edit").empty().append(DayField.editTemplate());
                            $(".muscle-edit").empty().append(MuscleField.editTemplate());
                            $(".exercisename-edit").empty().append(ExerciseNameField.editTemplate());
                            $(".exercisetype-edit").empty().append(ExerciseTypeField.editTemplate());
                            $(".setcount-edit").empty().append(ExerciseSetCount.editTemplate());
                        };
                        $editControl.on("change", changeDaytype);
                        changeDaytype();
                        return $editControl;
                    },
                },
                {name: "MuscleGroup", title:"Muscle Group", type: "select", insertcss: "muscle-insert", editcss: "muscle-edit", items: MuscleGroup, valueField: "Id", textField: "Name", width: 50, validate: { message: "Muscle group should be specified", validator: function(value) { return value >= 1; } }},
                {name: "ExerciseName", title:"Exercise Name", type: "text", insertcss: "exercisename-insert", editcss: "exercisename-edit", validate: { message: "Please Input Exercise Name", validator: function(value) { return value != ""; } }},
                {name: "ExerciseType", title:"Exercise Type", type: "select", insertcss: "exercisetype-insert", editcss: "exercisetype-edit", items: ExerciseType, valueField: "Id", textField: "Name", width: 40, validate: { message: "Exercise type should be specified", validator: function(value) { return value >= 0; } }},
                {name: "SetCount", title:"Set Count", align:"center", type:"number", insertcss: "setcount-insert", editcss: "setcount-edit", width: 30, validate: { message: "Set count can be 1~50", validator: "range", param: [1, 50] }},
                {
                    name: "SetInfo", width: 20, sorting: false, filtering: false, align:"center",

                    itemTemplate: function(value, item) {
                        var setdata = item["Setsdata"];
                        var daytype = item["DayType"];

                        if(daytype == 0)
                        {
                            return $("<div></div>");
                        }
                        else
                        {
                            if(setdata == "")
                            {
                                return $("<button style=' color: #ff2e1f'>").text("Add")
                                        .on("click", function() {
                                            showSetInfoDialog(item);
                                            return false;
                                        });
                            }
                            else
                            {
                                return $("<button style='color: #345ef8'>").text("Edit")
                                        .on("click", function() {
                                            showSetInfoDialog(item);
                                            return false;
                                        });
                            }
                        }
                    }
                },
                {type: "control",editButton: false, modeSwitchButton: false, width: 30},
                {name: "Setsdata", type:"text", visible:false, width: 30},
                {name: "WorkoutId", type:"text", visible:false, width: 30},
            ],

            onItemInserting: function(args) {
                var selectedWeekIndex = $( "#selectWeek option:selected").val();

                if(selectedWeekIndex == 0) {
                    args.cancel = true;
                    showAlert("Specify the Week!");
                }
            },

            onItemEditing: function(args) {
                var selectedWeekIndex = $( "#selectWeek option:selected").val();

                if(selectedWeekIndex == 0) {
                    args.cancel = true;
                    showAlert("Specify the Week!");
                }
            },

            onItemDeleting: function(args) {
                var selectedWeekIndex = $( "#selectWeek option:selected").val();

                if(selectedWeekIndex == 0) {
                    args.cancel = true;
                    showAlert("Specify the Week!");
                }
            },

            onDataLoading: function(args) {
                var selectedWeekIndex = $("#selectWeek option:selected").val();

                if (selectedWeekIndex == 0) {
                    args.cancel = true;
                }
            },

            onItemInserted: function(args) {
                this.loadData();
            },

            onItemDeleted: function(args)
            {
                this.loadData();
            },

            onItemUpdated: function(args)
            {
                this.loadData();
            },

            invalidNotify: function(args) {
                var message = args.errors[0]["message"];
                showAlert(message);
            },
        });

        $( document ).ready(function() {
            var weektext = $( "#selectWeek option:selected" ).text();
            var selectedWeekIndex = $( "#selectWeek option:selected" ).val();
            if(selectedWeekIndex == 0)
            {
                $('#WeekNo').text("Please Select Week");
                $('#selectDay').attr('disabled', 'disabled');

            }
            else
            {
                $('#WeekNo').text(weektext);
                $('#selectDay').removeAttr('disabled');
            }

            var daytext = $( "#selectDay option:selected" ).text();
            var selectedDayIndex = $( "#selectDay option:selected" ).val();
            if(selectedDayIndex == 0 || selectedDayIndex == -1)
            {
                $('#DayNo').text("");
            }
            else
            {
                $('#DayNo').text(daytext);
            }
            $("#jsGrid").jsGrid("loadData");
        });

        $('#selectWeek').change(function() {
            var weektext = $( "#selectWeek option:selected" ).text();
            var selectedWeekIndex = $( "#selectWeek option:selected").val();

            $("#jsGrid").jsGrid("loadData");

            if(selectedWeekIndex == 0)
            {
                $('#WeekNo').text("Please Select Week");
                $('#selectDay').attr('disabled', 'disabled');
            }
            else
            {

                $('#WeekNo').text(weektext);
                $('#selectDay').removeAttr('disabled');
                $('#selectDay').val(0);

                $('#DayNo').text("");
                $('#jsGrid').jsGrid("fieldOption","Day", "selectedIndex", 0);
                $('#jsGrid').jsGrid("fieldOption","Day", "readOnly", false);
                $("#jsGrid").jsGrid("loadData");
            }
        });

        $('#PageCount').change(function() {
            var displayCount = $( "#PageCount option:selected" ).val();

            $("#jsGrid").jsGrid("option", "pageSize", displayCount);
        });

        $('#selectDay').change(function() {
            var daytext = $( "#selectDay option:selected" ).text();
            var selectedDayIndex = parseInt($( "#selectDay option:selected" ).val(), 10);

            $("#jsGrid").jsGrid("loadData");

            if(selectedDayIndex == 0 || selectedDayIndex == -1)
            {
                $('#DayNo').text("");
                $('#jsGrid').jsGrid("fieldOption","Day", "selectedIndex", 0);
                $('#jsGrid').jsGrid("fieldOption","Day", "readOnly", false);
            }
            else
            {
                $('#DayNo').text(daytext);
                $('#jsGrid').jsGrid("fieldOption","Day", "selectedIndex", selectedDayIndex - 1);
                $('#jsGrid').jsGrid("fieldOption","Day", "readOnly", true);
            }
        });

        /*function showAlert(error)
        {
            var box = bootbox.alert(error);
            box.find('.modal-content').css({'background-color': '#efe4b0', 'text-align':'center', 'font-weight' : 'bold', color: '#F00', 'font-size': '25px'} );
            box.find('.modal-footer').css({'text-align':'center'});
            box.find(".btn-primary").removeClass("btn-primary").css({'width':'150px','background-color': '#61ce7b', 'font-weight' : 'bold', color: '#F00', 'font-size': '25px'});
        };*/

        function showSetInfoDialog(item)
        {
            var setscount = item["SetCount"];
            var setdata = item["Setsdata"];
            var setdataJSON;
            var bDisplay = false;

            if(setdata == "" || setdata == null)
            {
                bDisplay = false;
            }
            else
            {
                setdataJSON =  $.parseJSON(setdata);
                bDisplay = true;
            }

            var extype = item["ExerciseType"];
            var workoutid = item["WorkoutId"];
            $("#jsGrid").jsGrid("option", "editing", false);
            $("#jsGrid").jsGrid("option", "editing", true);

            $("#SetModal #setcountlabel").text(setscount);
            $("#SetModal #workoutidvalue").val(workoutid);
            $("#SetModal #setcountvalue").val(setscount);


            var typeString = "";
            var exerciseType = parseInt(extype);

            var weighttime = "";

                weighttime = "Time";
                typeString = "'text' pattern='[0-5][0-9]:[0-5][0-9]' maxlength='5' placeholder='00:00' ";


            for ( var i=0; i<setscount; i++) {
                var index = (i + 1).toString();

                var displayValue = "";
                var displayReps = "";
                if(bDisplay)
                {
                    displayValue = setdataJSON[i]['val'];
                    displayReps = setdataJSON[i]['reps'];
                }
                if(exerciseType == 1)
                {
                    var tag = $("<div><label class='setNoLabel'>" +
                            "Set" + index + ":</label><label>" + weighttime + "</label>" +
                            "<input type=" + typeString + " id='measuvalue" + index + "' name='measuvalue" + index + "'class='form-control setinfoedit time' maxlength='5' value = '" + displayValue + "' required>" +
                            "<label>Reps</label>" +
                            "<input type='number' min='1' id='repsvalue" + index + "' name='repsvalue" + index + "'class='form-control setinfoedit' placeholder='Reps' value = '" + displayReps + "'required>" +
                            "<div class='setdivider'></div>" +
                            "</div>");
                    $("#SetModal #SetInfoBody").append(tag);
                }
                else
                {
                    var tag = $("<div><label class='setNoLabel'>" +
                            "Set" + index + ":</label>" +
                            "<label>Reps</label>" +
                            "<input type='number' min='1' id='repsvalue" + index + "' name='repsvalue" + index + "'class='form-control setinfoedit' placeholder='Reps' value = '" + displayReps + "'required>" +
                            "<div class='setdivider'></div>" +
                            "</div>");
                    $("#SetModal #SetInfoBody").append(tag);
                }

            }

            var exercisetypetag = $("<input type='hidden' id='modalextype' value='" + extype + "'>");
            $("#SetModal #SetInfoBody").append(exercisetypetag);

            $('.time').mask('00:00');
            $('#SetModal').modal();
        }

        $('#SetInfoForm').submit(function(event){
            event.preventDefault();

            $setcounts = $("#setcountvalue").val();
            $workoutid = $("#workoutidvalue").val();
            $workouttype = $("#modalextype").val();

            var data = $("#SetInfoForm").serialize();

            var extradata = "&SetCount=" + $setcounts + "&WorkoutId=" + $workoutid + "&extype=" + $workouttype;
            data = data + extradata;
            $.ajax({
                type: "POST",
                url: "/programbuilder/<?php echo $programtype?>/<?php echo $userid;?>/<?php echo $programid;?>/savesetinfo",
                data: data
            });
            $("#jsGrid").jsGrid("loadData");
            dismissmodal();
        });

        $('#modalCancel').click(function() {
            dismissmodal();
        });

        $('#SetModal').on('hidden.bs.modal', function () {
            dismissmodal();
        });

        function dismissmodal()
        {
            $("#SetInfoBody").empty();
            $('#SetModal').modal('hide');
        }

        function reloadTableData()
        {
            $("#jsGrid").jsGrid("loadData");
        }
    </script>
@endsection