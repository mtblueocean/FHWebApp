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
    </style>

    <div class="dashboardBackground">
        <div class="dashboardContent">
                <div class="row" style="padding-left: 20px; padding-right: 20px; padding-top: 20px; padding-bottom: 20px">
                    <div class="col-sm-2 col-md-2 col-lg-2">                        
                        <div style="text-align:center;margin:16px 0 20px;">

                            <div id="imgdiv" style="display: block;
                                                                          width: 100%;
                                                                          height: auto;
                                                                          position: relative;
                                                                          overflow: hidden;
                                                                          padding: 75% 0 0 0; text-align: center">
                                <img class="product-image" style="width: 400px; height: 300px; display: block;
                                                                          max-width: 100%;
                                                                          max-height: 100%;
                                                                          position: absolute;
                                                                          top: 0;
                                                                          bottom: 0;
                                                                          left: 0;
                                                                          right: 0; margin-right: auto; margin-left: auto" src="{{asset($program->program_image)}}" alt="" />

                            </div>
                        </div>
                        <!--<div style="text-align:center;margin-bottom:20px;">
                            <p style="margin-top:20px;font-size: 20px; font-weight: bold"><b>upload</b></p>                           
                        </div>-->
                    </div>

                    <div class="col-sm-7 col-md-7 col-lg-7">                        
                        <div class="col-sm-12 col-md-12 col-lg-12">                            
                            <div class="col-sm-7 col-md-7 col-lg-7">                                
                                <p style="margin:10px; font-size: 20px">Program Name</p>
                                <p style="margin:0 10px 20px; font-size: 24px">{{$program->program_name}}</p>                                
                                <div>   
                                    <div class="col-sm-2 col-md-2 col-lg-2">                                        
                                        <p style="font-size: 16px; margin-top: 7px">Price</p>
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">                                        
                                        <p style="font-size: 16px" class="btn dashboard-btn">{{($program->program_isfree == 1 ? "Free": "$ ".$program->program_price)}}</p>
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">                                        
                                        
                                    </div>
                                    <div class="col-sm-2 col-md-2 col-lg-2">
                                        <p style="font-size: 16px; margin-top: 7px">Type</p>                                     
                                    </div>
                                    <div class="col-sm-3 col-md-3 col-lg-3">
                                        <p style="font-size: 16px" class="btn dashboard-btn">{{($program->program_type == 1 ? "Public": ($program->program_type == 2 ? "Custom":"Internal"))}}</p>                                    
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-5 col-md-5 col-lg-5">                                
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <form id="publishForm" action="{{url($publishurl)}}" method="post">
                                        {!! csrf_field() !!}
                                        <button type="submit" id="btnPublish" class="product-but publish-but">Publish</button>
                                    </form>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <button type="button" class="product-but edit-but" onclick="window.location='{{ url($backurl) }}'">Edit</button>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <form id="DeleteForm" action="{{url($deleteurl)}}" method="post">
                                        {!! csrf_field() !!}
                                        <button type="submit" name="btnDelete" id="btnDelete" class="product-but delete-but">Delete</button>
                                    </form>
                                </div>                                
                            </div>                            
                        </div>
                        <div class="col-sm-8 col-md-8 col-lg-8">                            
                            <p style="margin:20px; font-size: 20px">Product Description</p>
                            <p style="margin:10px 20px 20px; font-size: 16px">{{$program->program_description}}</p>                            
                        </div>
                    </div>

                    <div class="col-sm-3 col-md-3 col-lg-3" style="margin-top: 16px">
                        <iframe width="100%" height="auto" src="https://www.youtube.com/embed/e55jQCk5-PY?rel=0&amp;contols=0&amp;showinfo=0" frameborder="0" allowfullscreen class=""></iframe>
                        <p style="margin: 20px 0 ; font-size:16px; font-weight: 900">Availability & Seller Responsibility</p>
                        <p style="font-size: 12px; word-wrap: break-word;">By making your program available through FitHabit's mobile app. Clients will have instant access to your program once it is received.<br><br>
                            Program previews have been set by you during the program creation setup. If a client requests a refund, you may go to the fithabit app on your smartphone device and click disable access.<br><br>
                            Your client will receive an email from FitHabit stating that their program has been cancelled and their order will be refunded.<br><br>
                            It is responsibility of the seller to process refunds to clients once funds have been disbursed to a vendor. FitHabit claims no responsibility in processing client orders or refundsafter disbursement.
                        </p>                       
                    </div>
                </div>
        </div>
    </div>
    <script>
        $('#publishForm').submit(function(event) {
            var publishable = "<?php echo $publishable;?>";
            var programtype = "<?php echo $programtype;?>";

            event.preventDefault();
            var box = bootbox.confirm({
                title: "Publish Program?",
                message: "Do you want to publish program?",
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
                        console.log(publishable);
                        if(publishable == "yes")
                        {
                            $("#publishForm")[0].submit();
                        }
                        else
                        {
                            event.preventDefault();
                            var errmessage = "No Info yet!"
                            if(programtype == "workout")
                            {
                                errmessage = "No Exercise Info yet!"
                            }
                            else if(programtype == "nutrition")
                            {
                                errmessage = "No Meal Info yet!"
                            }
                            else if(programtype == "infodoc")
                            {
                                errmessage = "No Doc Info yet!"
                            }
                            showAlert(errmessage);

                        }
                    }
                    else
                    {
                        event.preventDefault();
                    }
                }
            });
            box.find('.modal-content').css({'background-color': '#fff', 'text-align':'center', 'font-weight' : 'bold', color: '#333', 'font-size': '25px'} );
            box.find('.modal-footer').css({'text-align':'center', 'height':'70px'});
            box.find(".btn-default").removeClass("btn-default").css({'width':'100px', 'height':'40px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
            box.find(".btn-primary").removeClass("btn-primary").css({'width':'100px', 'height':'40px', 'margin-left':'50px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
        });


        $('#DeleteForm').submit(function(event) {
            var publishable = "<?php echo $publishable;?>";
            event.preventDefault();
            var box = bootbox.confirm({
                title: "Remove Program?",
                message: "Do you want to delete program?",
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
                        $("#DeleteForm")[0].submit();
                    }
                    else
                    {
                        event.preventDefault();
                    }
                }
            });

            box.find('.modal-content').css({'background-color': '#fff', 'text-align':'center', 'font-weight' : 'bold', color: '#333', 'font-size': '25px'} );
            box.find('.modal-footer').css({'text-align':'center', 'height':'70px'});
                box.find(".btn-default").removeClass("btn-default").css({'width':'100px', 'height':'40px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
            box.find(".btn-primary").removeClass("btn-primary").css({'width':'100px', 'height':'40px', 'margin-left':'50px', 'background-color': '#fff', 'font-weight' : 'bold', color: '#333', 'font-size': '20px'});
        });

    </script>
@endsection
