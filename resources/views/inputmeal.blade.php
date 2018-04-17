@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row">
                    <div class="col-sm-4">
                        <p style="margin-bottom:10px;margin-top:18px;margin-left:40px;font-size: 30px; font-weight: bold"><b>{{$programName}}</b></p>
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
            </div><!--header-->
            <div class="tablediv">
                <div style="margin-left: 20px; margin-right: 10px;">
                    <p  style="margin-top: 15px; float: left; font-size: 20px; font-weight: bold"><b>Add a food</b></p>
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


        function FloatNumberField(config) {
            jsGrid.NumberField.call(this, config);
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
            editing: true,
            inserting: true,

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


                    if(dayType == 0) {
                        var box = bootbox.confirm({
                            title: "Set Week" + selectedWeekIndex + " Day " + selectedDayIndex + " as RestDay ",
                            message: "If you have already meal info for the selected day, they'll be cleared!<br/>" +
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
                        var MealField = this._grid.fields[3];
                        var FoodNameField = this._grid.fields[4];
                        var QuantityField = this._grid.fields[5];
                        var QuantityTypeField = this._grid.fields[6];
                        var ProteinField = this._grid.fields[7];
                        var CarbsField = this._grid.fields[8];
                        var FatField = this._grid.fields[9];
                        var CaloriesField = this._grid.fields[10];

                        var $insertControl = jsGrid.fields.select.prototype.insertTemplate.call(this);

                        MealField.inserting = true;
                        FoodNameField.inserting = true;
                        QuantityField.inserting = true;
                        QuantityTypeField.inserting = true;
                        ProteinField.inserting = true;
                        CarbsField.inserting = true;
                        FatField.inserting = true;
                        CaloriesField.inserting = true;

                        $(".meal-insert").empty().append(MealField.insertTemplate());
                        $(".foodname-insert").empty().append(FoodNameField.insertTemplate());
                        $(".quantity-insert").empty().append(QuantityField.insertTemplate());
                        $(".quantitytype-insert").empty().append(QuantityTypeField.insertTemplate());
                        $(".protein-insert").empty().append(ProteinField.insertTemplate());
                        $(".carbs-insert").empty().append(CarbsField.insertTemplate());
                        $(".fat-insert").empty().append(FatField.insertTemplate());
                        $(".calories-insert").empty().append(CaloriesField.insertTemplate());

                        $insertControl.on("change", function() {
                            var selectedDayType = $(this).val();
                            if(selectedDayType == 0)
                            {
                                MealField.inserting = false;
                                FoodNameField.inserting = false;
                                QuantityField.inserting = false;
                                QuantityTypeField.inserting = false;
                                ProteinField.inserting = false;
                                CarbsField.inserting = false;
                                FatField.inserting = false;
                                CaloriesField.inserting = false;
                            }
                            else
                            {
                                MealField.inserting = true;
                                FoodNameField.inserting = true;
                                QuantityField.inserting = true;
                                QuantityTypeField.inserting = true;
                                ProteinField.inserting = true;
                                CarbsField.inserting = true;
                                FatField.inserting = true;
                                CaloriesField.inserting = true;
                            }

                            $(".meal-insert").empty().append(MealField.insertTemplate());
                            $(".foodname-insert").empty().append(FoodNameField.insertTemplate());
                            $(".quantity-insert").empty().append(QuantityField.insertTemplate());
                            $(".quantitytype-insert").empty().append(QuantityTypeField.insertTemplate());
                            $(".protein-insert").empty().append(ProteinField.insertTemplate());
                            $(".carbs-insert").empty().append(CarbsField.insertTemplate());
                            $(".fat-insert").empty().append(FatField.insertTemplate());
                            $(".calories-insert").empty().append(CaloriesField.insertTemplate());
                        });
                        return $insertControl;
                    },

                    editTemplate: function(value) {

                        var MealField = this._grid.fields[3];
                        var FoodNameField = this._grid.fields[4];
                        var QuantityField = this._grid.fields[5];
                        var QuantityTypeField = this._grid.fields[6];
                        var ProteinField = this._grid.fields[7];
                        var CarbsField = this._grid.fields[8];
                        var FatField = this._grid.fields[9];
                        var CaloriesField = this._grid.fields[10];

                        var $editControl = jsGrid.fields.select.prototype.editTemplate.call(this, value);

                        var changeDaytype = function() {
                            var selectedDayType = $editControl[0].selectedIndex;
                            console.log("Change = " + selectedDayType);
                            if(selectedDayType == 1)
                            {
                                MealField.editing = false;
                                FoodNameField.editing = false;
                                QuantityField.editing = false;
                                QuantityTypeField.editing = false;
                                ProteinField.editing = false;
                                CarbsField.editing = false;
                                FatField.editing = false;
                                CaloriesField.editing = false;
                            }
                            else
                            {
                                MealField.editing = true;
                                FoodNameField.editing = true;
                                QuantityField.editing = true;
                                QuantityTypeField.editing = true;
                                ProteinField.editing = true;
                                CarbsField.editing = true;
                                FatField.editing = true;
                                CaloriesField.editing = true;
                            }

                            $(".meal-edit").empty().append(MealField.editTemplate());
                            $(".foodname-edit").empty().append(FoodNameField.editTemplate());
                            $(".quantity-edit").empty().append(QuantityField.editTemplate());
                            $(".quantitytype-edit").empty().append(QuantityTypeField.editTemplate());
                            $(".protein-edit").empty().append(ProteinField.editTemplate());
                            $(".carbs-edit").empty().append(CarbsField.editTemplate());
                            $(".fat-edit").empty().append(FatField.editTemplate());
                            $(".calories-edit").empty().append(CaloriesField.editTemplate());
                        };
                        $editControl.on("change", changeDaytype);
                        changeDaytype();
                        return $editControl;
                    },
                },
                {name: "MealType", title:"Meal", type: "select", items: MealType, valueField: "Id", textField: "Name",  insertcss: "meal-insert", editcss: "meal-edit", width: 50, validate: { message: "Meal Type should be specified", validator: function(value) { return value >= 0; } }},
                {name: "FoodName", title:"Food", type: "text", insertcss: "foodname-insert", editcss: "foodname-edit", validate: { message: "Please Input Food Name", validator: function(value) { return value != ""; } }},
                {name: "Quantity", title:"Quantity", type: "floatNumber", insertcss: "quantity-insert", editcss: "quantity-edit", width: 40, validate: { message: "Please Input Correct Quantity", validator: function(value) { return value > 0; } }},
                {name: "QuantityType", title:"Type", type: "select", insertcss: "quantitytype-insert", editcss: "quantitytype-edit", items: QuantityType, valueField: "Id", textField: "Name", width: 40, validate: { message: "Quantity type should be specified", validator: function(value) { return value >= 0; } }},
                {name: "Protein", title:"Protein", type: "floatNumber", insertcss: "protein-insert", editcss: "protein-edit", width: 40, validate: { message: "Please Input Correct Protein", validator: function(value) { return value > 0; } }},
                {name: "Carbs", title:"Carbs", type: "floatNumber", insertcss: "carbs-insert", editcss: "carbs-edit", width: 40, validate: { message: "Please Input Correct Carbs", validator: function(value) { return value > 0; } }},
                {name: "Fat", title:"Fat", type: "floatNumber", insertcss: "fat-insert", editcss: "fat-edit", width: 40, validate: { message: "Please Input Correct Fat", validator: function(value) { return value > 0; } }},
                {name: "Calories", title:"Calories", type: "floatNumber", insertcss: "calories-insert", editcss: "calories-edit", width: 40, validate: { message: "Please Input Correct Calories.", validator: function(value) { return value > 0; } }},
                {type: "control",editButton: false, modeSwitchButton: false, width: 30},
                {name: "MealId", type:"text", visible:false, width: 30},
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

        function reloadTableData()
        {
            $("#jsGrid").jsGrid("loadData");
        }
    </script>
@endsection