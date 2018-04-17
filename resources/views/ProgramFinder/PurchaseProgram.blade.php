@extends('layouts.app')

@section('content')
    <script src="{{asset('js/JSGrid/jsgrid.min.js')}}"></script>
    <div class="finderfirstBackgrounda">
        <div style="width:100%; display: table; vertical-align: bottom">
            <p style="font-size: 26px; width: 50%; color: #424242; float: left; font-weight: bold;">{{$programtype}} Program</p>
        </div>
        <div class="row">
            <div class="cols-sm-6 col-md-6 col-lg-6" style="padding-left:10px; padding-top: 10px; padding-bottom: 10px; padding-right: 20px">
                <form id="purchaseform" action="{{url('/purchasefinish')}}" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" id="purchaseProgramid" name="purchaseProgramid" value="{{$program->program_id}}">
                    <input type="hidden" id="purchaseAmount" name="purchaseAmount" value="{{floatval($program->program_price * 100)}}">
                    <input type="hidden" id="stripePubKey" name="stripePubKey" value="{{$stripePubKey}}">
                    <div class="workoutPanel" style="padding: 30px; height: 360px;">
                        <div style="margin-top: 10px; padding-left: 10px; padding-right: 7px">
                            <div style="display: table; width: 100%">
                                <p style="font-size: 30px; color: #424242; font-weight: bold; float: left">{{$program->program_name}}</p>
                                @if($program->program_kind != 3)
                                    <button type="button" id="btnPreview" style="margin-left: 20px; margin-top: 10px; margin-bottom: 20px; width: 65px; height: 25px " class="finder-but">Preview</button>
                                @endif
                                <p style="font-size: 22px; margin-top: 10px; color: #424242; font-weight: bold; float: right">
                                    @if ($program->program_isfree == 1)
                                        FREE
                                    @else
                                        $ {{$program->program_price}}
                                    @endif
                                </p>
                            </div>
                            <div>

                                @if ($program->user["user_profilepicurl"] == "")
                                    <img class="img-circle" style="width: 70px;" src="{{asset('images/dashboard/emptyprofile.jpg')}}" alt="" />
                                @else
                                    <img class="img-circle" style="width: 70px;" src="{{asset($program->user["user_profilepicurl"])}}" alt="" />
                                @endif

                                <label style="vertical-align: bottom; font-weight: bold; margin-left: 10px; font-size: 20px; margin-top: 5px; padding-top: 5px">by {{$program->user["name"]}}</label>

                                @if($program->program_isfree == 1)
                                    <button type="submit" id="btnPurchasefree" style="float: right; margin-top: 16px; margin-bottom: 20px; width: 55px; height: 30px" class="finder-but">ADD</button>
                                @else

                                    <button type="submit" id="btnPurchase" style="float: right; margin-top: 16px; margin-bottom: 20px; width: 55px; height: 30px" class="finder-but">ADD</button>
                                    <script>
                                        document.getElementById('btnPurchase').addEventListener('click', function(e) {
                                            // Open Checkout with further options:
                                            handler.open({
                                                name: 'FitHabit',
                                                description: 'Purchase <?php echo $program->program_name;?>',
                                                amount: parseFloat($('input[name=purchaseAmount]').val())
                                            });
                                            e.preventDefault();
                                        });

                                        // Close Checkout on page navigation:
                                        window.addEventListener('popstate', function() {
                                            handler.close();
                                        });

                                    </script>
                                @endif

                            </div>
                            <div>
                                <label style="vertical-align: bottom; height: 150px; overflow: auto; margin-left: 10px; margin-right:10px; font-size: 15px; margin-top: 15px; padding-top: 5px">{{$program->program_description}}</label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="cols-sm-6 col-md-6 col-lg-6" style="padding-left:10px; padding-top: 10px; padding-bottom: 10px; padding-right: 20px">
                <div class="workoutPanel" style="padding: 30px; height: 360px;">
                    <div style="margin-top: 10px; padding-left: 10px; padding-right: 7px">
                        <div style="width: 100%; text-align: center">
                            <img  style="width: 200px;" src="{{asset('images/home/phone.png')}}" alt="" />
                            <p style="font-size: 30px; color: #424242; font-weight: bold; margin-top: 20px">Add a program to send<br>to the FitHabit App.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="PreviewModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" style="width: 70%" >
            <div class="modal-content">


                <div class="modal-body">
                    <button type="button" class="close customed" style="margin-top: -10px; margin-right:-10px" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
                    <form>
                    <!-- content goes here -->
                    <div style="width:100%; display: table; vertical-align: bottom">
                        <p style="margin-left:30px; margin-top: 20px; font-size: 26px;color: #424242; float: left; font-weight: bold;">{{$program->program_name}}</p>
                        <p style="font-size: 20px; margin-left:10px; margin-top: 26px;color: #6e6e6e; float: left;">(Preview)</p>
                    @if($program->program_kind == 1 || $program->program_kind == 2)
                            <select id="selectDay" style="margin-right:30px; float:right; margin-left:10px;  width:200px; margin-top: 23px" class="form-control selectWidth">
                                <?php
                                $days = ["", "Day 1", "Day 2"];
                                ?>
                                <option value="-1" selected disabled>Select Day...</option>
                                @for ($i = 0; $i <= 2; $i++)
                                    <option value="{{$i}}">{{$days[$i]}}</option>
                                @endfor
                                    <option value="3" disabled>...</option>
                            </select>

                            <select id="selectWeek" style=" float:right; width:200px; margin-top: 23px;" class="form-control selectWidth">
                                <!--<option value="0" selected disabled>Select Week...</option>-->
                                @if($program->program_weeks > 2)
                                        <option value="1" selected>Week 1</option>
                                        <option value="2">Week 2</option>
                                        <option value="3" disabled>...</option>
                                @else
                                    <option value="1" selected>Week 1</option>
                                    <option value="2" disabled>...</option>
                                @endif
                            </select>
                    @endif

                    </div>
                    <div class="splitterdiv">
                    </div><!--split-->
                    <div class="tablediv">
                        <div style="margin-left: 20px;">
                            <!--<p id="WeekNo" name="WeekNo" style="margin-top: 15px; float: left; font-size: 20px; font-weight: bold"><b></b></p>
                            <p id="DayNo" style="margin-top: 15px; float: left; margin-left: 20px;font-size: 20px; font-weight: bold"><b></b></p>-->

                            <select id="PageCount" style="float:right; width:80px; margin-top: 15px" class="form-control selectWidth">
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
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var handler = StripeCheckout.configure({
            key: $('input[name=stripePubKey]').val(),
            image: 'https://s3.amazonaws.com/stripe-uploads/acct_19q9jgCzyzzCXQlHmerchant-icon-1487810294055-261880392327149.2Rrf78trypZ4EQekAFeW_height640.png',
            locale: 'auto',
            amount: parseFloat($('input[name=purchaseAmount]').val()),
            token: function(token) {
                //$("#purchaseform").submit();
                stripeResponseHandler(token);
            }
        });

        function stripeResponseHandler(token) {
            var $form = $('#purchaseform');
            var programId = $('input[name=purchaseProgramid]').val();

            $form.append($('<input type="hidden" name="stripeToken">').val(token));
            $form.append($('<input type="hidden" name="programId">').val(programId));

            var postUrl = "/processpurchase";

            var postdata = {
                //curPassword: curPassword,
                programId: programId,
                stripeToken: token
            };

            $.ajax({
                type: "POST",
                url: postUrl,
                data: postdata,
                dataType: "json",
                success: function (data) {
                    var res = data['result'];
                    if(res == true)
                    {
                        //console.log(data);
                        $form.get(0).submit();
                    }
                    else
                    {
                        showAlert("Checkout Failed.");
                    }
                },
                error: function (result) {
                    showAlert("Error During Process Checkout.");
                }
            });
        };



        $('#btnPreview').on("click", function() {
            $("#jsGrid").jsGrid("loadData");
            showPreviewDialog();
            return false;
        });


        function showPreviewDialog()
        {
            $('#PreviewModal').modal();
        }

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

        var ExerciseType = [
            { Name: "Strength", Id: 0 },
            { Name: "Conditioning", Id: 1 }
        ];

        var displayCount = $( "#PageCount option:selected" ).val();

        var programtype = "<?php echo $program->program_kind;?>";

        if(programtype == 1)
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
                        var selectedDayIndex = $( "#selectDay option:selected").val();
                        filter['SelectedWeek'] = selectedWeekIndex;
                        filter['SelectedDay'] = selectedDayIndex;
                        filter['ProgramId'] = "<?php echo $program->program_id;?>";
                        filter['ProgramType'] = "<?php echo $program->program_kind?>";

                        return $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "/programpreview",
                            dataType: "json",
                            data: filter
                        });
                    }
                },

                fields: [
                    {name: "No", title:"No.", align:"center", type:"number", inserting:false, editing:false, filtering:false, width: 20},
                    {name: "Day", title:"Day", type: "select", items: Days, valueField: "Id", textField: "Name", width: 30, validate: { message: "Day should be specified", validator: function(value) { return value >= 1; } }},
                    {name: "DayType", title:"Day Type", type: "select", items: DayType, valueField: "Id", textField: "Name", width: 30, validate: { message: "Day type should be specified", validator: function(value) { return value >= 0; } }},
                    {name: "MuscleGroup", title:"Muscle Group", type: "select", items: MuscleGroup, valueField: "Id", textField: "Name", width: 50, validate: { message: "Muscle group should be specified", validator: function(value) { return value >= 1; } }},
                    {name: "ExerciseName", title:"Exercise Name", type: "text", validate: { message: "Please Input Exercise Name", validator: function(value) { return value != ""; } }},
                    {name: "ExerciseType", title:"Exercise Type", type: "select",items: ExerciseType, valueField: "Id", textField: "Name", width: 40, validate: { message: "Exercise type should be specified", validator: function(value) { return value >= 0; } }},
                    {name: "SetCount", title:"Set Count", align:"center", type:"number", width: 30, validate: { message: "Set count can be 1~50", validator: "range", param: [1, 50] }},
                    {name: "Setsdata", type:"text", visible:false, width: 30},
                    {name: "WorkoutId", type:"text", visible:false, width: 30},
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
        else if(programtype == 2)
        {
            function FloatNumberField(config) {
                //jsGrid.NumberField.call(this, config);
            }

            FloatNumberField.prototype = new jsGrid.NumberField({

                filterValue: function() {
                    return parseFloat(this.filterControl.val());
                },

                insertValue: function() {
                    return parseFloat(this.insertControl.val());
                },

                editValue: function() {
                    return parseFloat(this.editControl.val());
                }
            });

            jsGrid.fields.floatNumber = FloatNumberField;

            $("#jsGrid").jsGrid({
                width: "100%",

                scroll:false,
                sorting: true,
                paging: true,
                autoload:true,
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
                        var selectedDayIndex = $( "#selectDay option:selected").val();
                        filter['SelectedWeek'] = selectedWeekIndex;
                        filter['SelectedDay'] = selectedDayIndex;
                        filter['ProgramId'] = "<?php echo $program->program_id;?>";
                        filter['ProgramType'] = "<?php echo $program->program_kind?>";
                        console.log(selectedWeekIndex);
                        console.log(filter['ProgramType']);
                        return $.ajax({
                            type: "GET",
                            contentType: "application/json; charset=utf-8",
                            url: "/programpreview",
                            dataType: "json",
                            data: filter
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
                        validate: { message: "Day type should be specified", validator: function(value) { return value >= 0; }}
                    },
                    {name: "MealType", title:"Meal", type: "select", items: MealType, valueField: "Id", textField: "Name", width: 50, validate: { message: "Meal Type should be specified", validator: function(value) { return value >= 0; } }},
                    {name: "FoodName", title:"Food", type: "text", validate: { message: "Please Input Food Name", validator: function(value) { return value != ""; } }},
                    {name: "Quantity", title:"Quantity", type: "text", width: 40, validate: { message: "Please Input Correct Quantity", validator: function(value) { return value > 0; } }},
                    {name: "QuantityType", title:"Type", type: "select", items: QuantityType, valueField: "Id", textField: "Name", width: 40, validate: { message: "Quantity type should be specified", validator: function(value) { return value >= 0; } }},
                    {name: "Protein", title:"Protein", type: "text", width: 40, validate: { message: "Please Input Correct Protein", validator: function(value) { return value > 0; } }},
                    {name: "Carbs", title:"Carbs", type: "text", width: 40, validate: { message: "Please Input Correct Carbs", validator: function(value) { return value > 0; } }},
                    {name: "Fat", title:"Fat", type: "text", width: 40, validate: { message: "Please Input Correct Fat", validator: function(value) { return value > 0; } }},
                    {name: "Calories", title:"Calories", type: "text", width: 40, validate: { message: "Please Input Correct Calories.", validator: function(value) { return value > 0; } }},
                    {name: "MealId", type:"text", visible:false, width: 30},
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
            }
            else
            {
                $('#DayNo').text(daytext);
                $('#jsGrid').jsGrid("fieldOption","Day", "selectedIndex", selectedDayIndex - 1);
            }
        });

    </script>

@endsection
