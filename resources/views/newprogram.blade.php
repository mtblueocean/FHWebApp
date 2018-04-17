@extends('layouts.app')

@section('content')

    <style>
        video {
            margin-top: 10px;
            max-width: 100%;
            height: auto;
            background-color: #0a97b9;
            border-style: solid;
            border-width: 1px;
            margin-bottom: 20px;
        }
        .imageupload {
            margin: 0;
        }

    </style>

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <form id="newProgramForm" action="{{url($formurl)}}" method="post" enctype="multipart/form-data">
                {!! csrf_field() !!}
                @if (count($errors) > 0)
                    <script>
                        showAlert("An exist program name! Please Input another.");
                    </script>
                @endif
                <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <div style="text-align:center;margin-bottom:20px;">
                            <div style="margin-top: 10px">
                                <p style="margin-bottom:17px;font-size: 22px; font-weight: bold"><b>Product Image</b></p>
                            </div>
                            <div class="imageupload panel panel-default" style="border-style: none;">
                                <div class="file-tab panel-body">
                                        <div class="file-tab panel-body">
                                            <div id="imgdiv" style="border-style:solid; border-width:1px;display: block;
                                                                          width: 100%;
                                                                          height: auto;
                                                                          position: relative;
                                                                          overflow: hidden;
                                                                          padding: 75% 0 0 0; text-align: center">
                                                <img id="imgPreview" style="width: 250px; height: 200px; display: block;
                                                                          max-width: 100%;
                                                                          max-height: 100%;
                                                                          position: absolute;
                                                                          top: 0;
                                                                          bottom: 0;
                                                                          left: 0;
                                                                          right: 0; margin-right: auto; margin-left: auto;
                                                                          background: url(http://fithabit.io/images/dashboard/default-image.jpg);
                                                                          background-size: 100% 100%;                                                                          
                                                                          background-repeat: no-repeat;" 
                                                     @if ($newprogram == 0)
                                                     src = "{{asset($programdata->program_image)}}"
                                                        @endif
                                                     alt="">
                                            </div>
                                            <div>
                                                <br>
                                                <span style="font-size: 12px">(Required Size: 1280px by 960px)</span>
                                            </div>
                                            <label class="btn btn-default btn-file" style="margin-top: 20px">
                                                <span id="btnName">
                                                    @if ($newprogram == 1)
                                                        Browse
                                                    @else
                                                        Change
                                                    @endif
                                                </span>
                                                <!-- The file is stored here. -->
                                                <input type="file" style="width: 40px; height: 40px" name="imageprogram" onchange="readImgFromURL(this);" id="imageprogram"
                                                       @if ($newprogram == 1)
                                                        required
                                                       @else

                                                       @endif
                                                >
                                            </label>
                                        </div>


                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-5 col-md-5 col-lg-5 new-program">
                        <div style="margin-top: 0;">
                            <div class="row">
                                <div class="col-sm-5 col-md-5 col-lg-5">

                                    <p style="margin:10px 0 20px;font-size: 20px; vertical-align: bottom"><b>Program Name</b></p>
                                    <div>
                                        @if (count($errors) > 0)
                                            <input type="text" name="program_name" autocomplete="off" size="40" class="form-control" aria-invalid="false" value="{{old('program_name')}}" required>
                                        @else
                                            @if ($newprogram == 1)
                                                <input type="text" name="program_name" autocomplete="off" size="40" class="form-control" aria-invalid="false" value="" required>
                                            @else
                                                <input type="text" name="program_name" autocomplete="off" size="40" class="form-control" aria-invalid="false" value="{{$programdata->program_name}}" required>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                                <div class="col-sm-7 col-md-7 col-lg-7">
                                    <p style="margin:10px 0 20px 15px; font-size: 20px; font-weight: bold"><b>Price</b></p>                                 
                                    <div style="margin-left:7px;">
                                        <span>
                                            <input type="radio" name="paymethod"

                                                    @if (count($errors) > 0)
                                                        @if(old('paymethod') == "free")
                                                            <?php echo "checked"; ?>
                                                        @endif
                                                    @else
                                                        @if ($newprogram == 0)
                                                            @if($programdata->program_isfree == 1)
                                                                <?php echo "checked"; ?>
                                                            @endif
                                                        @else
                                                            <?php echo "checked"; ?>
                                                        @endif
                                                    @endif
                                                    value="free" onchange="paymethodselected()"><span class="wpcf7-list-item-label"><b>Free</b></span>
                                        </span>
                                        <span style="margin-left: 10px">
                                            <input type="radio" name="paymethod"
                                                    @if (count($errors) > 0)
                                                        @if(old('paymethod') == "paid")
                                                            <?php echo "checked"; ?>
                                                        @endif
                                                    @else
                                                        @if ($newprogram == 0)
                                                            @if($programdata->program_isfree == 0)
                                                                <?php echo "checked"; ?>
                                                            @endif
                                                        @endif
                                                    @endif
                                                    value="paid" onchange="paymethodselected()" ><span class="wpcf7-list-item-label"><b>Paid</b></span>



                                            @if (count($errors) > 0)
                                                <input type="number" name="programprice" value="{{old('programprice')}}" step="0.01" autocomplete="off" id="programprice" onchange="setTwoNumberDecimal(event)" size="40" class="form-control" style=" margin-right:10px;margin-top:8px; float:right;width:100px;" aria-invalid="false" required>
                                            @else
                                                @if ($newprogram == 1)
                                                    <input type="number" name="programprice" autocomplete="off" step="0.01" id="programprice" value="" size="40" onchange="setTwoNumberDecimal(event)" class="form-control" style=" margin-right:10px; float:right;width:100px;" aria-invalid="false" required>
                                                @else
                                                    <input type="number" name="programprice" value="{{$programdata->program_price}}" step="0.01" autocomplete="off" onchange="setTwoNumberDecimal(event)" id="programprice" size="40" class="form-control" style=" margin-right:10px; float:right; width:100px;" aria-invalid="false" required>
                                                @endif
                                            @endif

                                            <span style="font-size:16px; float: right; margin-top: 7px; margin-right: 10px"><b>$</b></span>
                                        </span>
                                    </div>                                    
                                </div>                                
                            </div>
                        </div>

                        <div style="margin-top:20px;">
                            <div class="row">
                                <div class="col-sm-12 col-md-12 col-lg-12">
                                    <p style="margin-bottom:20px; font-size: 20px; vertical-align: bottom"><b>Product Description</b></p>
                                    <div style="margin-right: 10px;">
                                        @if (count($errors) > 0)
                                            <textarea name="productdescription" cols="40" rows="8" class="form-control textarea" aria-invalid="false" required>{{old('productdescription')}}</textarea>
                                        @else
                                            @if ($newprogram == 1)
                                                <textarea name="productdescription" cols="40" rows="8" class="form-control textarea" aria-invalid="false" required></textarea>
                                            @else
                                                <textarea name="productdescription" cols="40" rows="8" class="form-control textarea" aria-invalid="false" required>{{$programdata->program_description}}</textarea>
                                            @endif
                                        @endif

                                    </div>
                                </div>
                            </div>

                            <div style="text-align: center">
                                <button type="submit" class="next-but">Next</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4 col-md-4 col-lg-4">
                        <div class="row">
                            @if($type != "infodoc")
                                <div class="col-sm-6">
                                    <div style="margin-top:10px">
                                        <p style="padding:5px 0 11px;font-size: 16px; vertical-align: bottom"><b># of Weeks</b></p>
                                    </div>
                                    <div>

                                        @if (count($errors) > 0)
                                            <input type="number" min="1" step = "1" autocomplete="off" name="programweek" value="{{old('programweek')}}" size="40" class="form-control" aria-invalid="false" required>
                                        @else
                                            @if ($newprogram == 1)
                                                <input type="number" min="1" step = "1" autocomplete="off" name="programweek" value="" size="40" class="form-control" aria-invalid="false" required>
                                            @else
                                                <input type="number" min="1" step = "1" autocomplete="off" name="programweek" value="{{$programdata->program_weeks}}" size="40" class="form-control" aria-invalid="false" required>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endif


                            <div class="col-sm-6">
                                <div style="margin-top:10px">
                                    <p style="padding:5px 0 11px;font-size: 16px; vertical-align: bottom"><b>Program Type</b></p>
                                </div>
                                <div>
                                    <select class="form-control" id="program_type" name="program_type" required="required">
                                        <option value="" disabled="disabled" selected></option>

                                        @if (count($errors) > 0)
                                            <option value="1" {{ (old("program_type") == "1" ? "selected":"") }}>Public</option>
                                            <option value="2" {{ (old("program_type") == "2" ? "selected":"") }}>Custom</option>
                                            @if(Auth::user()->user_type == 2)
                                                <option value="3" {{ (old("program_type") == "3" ? "selected":"") }}>Internal</option>
                                            @endif
                                        @else
                                            @if ($newprogram == 1)
                                                <option value="1">Public</option>
                                                <option value="2">Custom</option>
                                                @if(Auth::user()->user_type == 2)
                                                    <option value="3">Internal</option>
                                                @endif
                                            @else
                                                <option value="1" {{ ($programdata->program_type == 1 ? "selected":"") }}>Public</option>
                                                <option value="2" {{ ($programdata->program_type == 2 ? "selected":"") }}>Custom</option>
                                                @if(Auth::user()->user_type == 2)
                                                    <option value="3" {{ ($programdata->program_type == 3 ? "selected":"") }}>Internal</option>
                                                @endif
                                            @endif
                                        @endif
                                    </select>
                                </div>
                            </div>

                        </div>

                        <div>
                            <div>
                                <label style="margin-top: 20px; font-size: 12px; word-wrap: break-word; width: 100%">In FitHabit there are two program types.</label>
                                <p style="margin:20px 0 10px; font-size: 16px; vertical-align: bottom"><b>Public:</b></p>
                                <label style="font-size: 12px; word-wrap: break-word; width: 100%">Public programs are available immediately to the users smart phone upon adding it through program finder or by anyone providing a link to them. Your public programs can be free or paid and will be listed upon publishing.</label>
                                <p style="margin:20px 0 10px; font-size: 16px; vertical-align: bottom"><b>Custom:</b></p>
                                <label style="font-size: 12px; word-wrap: break-word; width: 100%">Custom programs are created by you for single client use and are not available to the public in program finder. Custom programs can only be accessed through the link you provide to your client.</label>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script>
        window.onload = function() {
            paymethodselected();
        };

        function paymethodselected() {
            var result = document.querySelector('input[name="paymethod"]:checked').value;
            if(result=="free"){
                document.getElementById("programprice").setAttribute('disabled', true);
                document.getElementById("programprice").value = "";
            }
            else if(result == "paid"){
                document.getElementById("programprice").removeAttribute('disabled');
                document.getElementById("programprice").focus();
                document.getElementById("programprice").setAttribute('placeholder', "0.00");
            }
        }

        function pricevalidate(evt) {
            var theEvent = evt || window.event;
            var key = theEvent.keyCode || theEvent.which;
            key = String.fromCharCode( key );
            var regex = /[0-9]|\./;
            if( !regex.test(key) ) {
                theEvent.returnValue = false;
                if(theEvent.preventDefault) theEvent.preventDefault();
            }
        }

        $('#newProgramForm').submit(function(event) {
            var isNew = "<?php echo $newprogram;?>";
            var msgTitle = "";
            if(isNew == "1")
            {
                msgTitle = "Create Program?"
            }
            else
            {
                msgTitle = "Update Program?"
            }
            event.preventDefault();
            var box = bootbox.confirm({
                title: msgTitle,
                message: "Ready to continue? You can always come back and edit this information.",
                buttons: {
                    cancel: {
                        label: '<i class="fa fa-times"></i> Cancel'
                    },
                    confirm: {
                        label: '<i class="fa fa-check"></i> OK'
                    }
                },
                callback: function (result) {
                    if(result == true)
                    {
                        $("#newProgramForm")[0].submit();
                    }
                    else
                    {
                        event.preventDefault();
                    }
                }
            });
            box.find('.modal-content').css({'background-color': '#fff', 'text-align':'center', 'font-weight' : 'bold', color: '#333', 'font-size': '25px'} );
            box.find('.modal-footer').css({'text-align':'center', 'height':'70px'});
            box.find(".btn-default").removeClass("btn-default").css({'width':'120px', 'height':'40px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
            box.find(".btn-primary").removeClass("btn-primary").css({'width':'120px', 'height':'40px', 'margin-left':'50px', 'margin-top' : '-1px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
        });


        function readImgFromURL(input) {
            if (input.files && input.files[0]) {
                if(input.files[0].size / 1024 <= 2048)
                {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var selectedImage = new Image();

                        selectedImage.src =  e.target.result;
                        selectedImage.onload = function () {
                            if(this.width == 1280 && this.height == 960)
                            {
                                $('#imgPreview').attr('src', e.target.result);
                                $('#imgdiv').css({'border':'none'});
                                $('#btnName').text('Change');
                            }
                            else
                            {
                                showAlert("Image size should be 1280px by 960px.");
                                $('#imgPreview').attr('src', '');
                                $('#imageprogram').val('');
                            }
                        };
                    };
                    reader.readAsDataURL(input.files[0]);
                }
                else
                {
                    showAlert("Image size should be less than 2MB.");
                    $('#imgPreview').attr('src', '');
                    $('#imageprogram').val('');
                }
            }
        }

        function setTwoNumberDecimal(event) {
            var myPrice = $("#programprice").val();
            console.log(myPrice);
            $("#programprice").val(parseFloat(myPrice).toFixed(2));
        }

        $( document ).ready(function() {
            setTwoNumberDecimal();
        });
    </script>
@endsection
