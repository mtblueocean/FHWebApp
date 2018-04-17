@extends('layouts.app')

@section('content')
    <div class="finderfirstBackgrounda">
        <div style="width:100%; display: table; vertical-align: bottom">
            <p style="font-size: 26px; width: 50%; color: #424242; float: left; font-weight: bold;">{{$programtype}} Programs</p>
        </div>
        <div class="row">
            @foreach($programs as $program)
                <form action='/purchaseprogram' method="POST">
                    {{csrf_field()}}
                    <input type="hidden" id="purchaseProgramid" name="purchaseProgramid" value="{{$program->program_id}}">
                <div class="cols-sm-2 col-md-2 col-lg-2" style="padding:10px; margin-bottom: 30px">
                    <div class="workoutPanel" style="padding: 0px">
                        <div style="display: block;
                                      width: 100%;
                                      height: auto;
                                      position: relative;
                                      overflow: hidden;
                                      padding: 75% 0 0 0; text-align: center">
                        <img style="width: 400px; height: 300px; display: block;
                                      max-width: 100%;
                                      max-height: 100%;
                                      position: absolute;
                                      top: 0;
                                      bottom: 0;
                                      left: 0;
                                      right: 0;"
                             @if($program->program_image == "")
                                src="{{asset('images/dashboard/default-image.jpg')}}"
                             @else
                                src="{{asset($program->program_image)}}"
                             @endif
                             alt=""/>
                        </div>
                        <div style="margin-top: 5px; padding-left: 10px; padding-right: 7px">
                            <p style="font-size: 15px; color: #424242; font-weight: bold;">{{$program->program_name}}</p>

                            @if ($program->user["user_profilepicurl"] == "")
                                <img class="img-circle" style="width: 15%;" src="{{asset('images/dashboard/emptyprofile.jpg')}}" alt="" />
                            @else
                                <img class="img-circle" style="width: 15%;" src="{{asset($program->user["user_profilepicurl"])}}" alt="" />
                            @endif

                            <label style="vertical-align: bottom; font-weight: bold; margin-left: 10px; font-size: 14px; margin-top: 5px; padding-top: 5px">{{$program->user["name"]}}</label>
                            <br>
                            <div style="width: 90%">
                            <label style="width:100%;word-break:break-all; vertical-align: bottom; overflow: auto; margin-left: 10px; margin-right:10px; font-size: 12px; height: 100px; margin-top: 15px; padding-top: 5px">{{$program->program_description}}</label>
                            </div>
                            <div style="width: 100%; display: table">
                                @if($program->program_kind == 3)
                                @else
                                    <p style="font-size: 11px; float:left; color: #424242; font-weight: bold; margin-top: 20px">Program Length: <?php echo $program->program_weeks*7;?>days</p>
                                @endif


                                    @if($program->program_purchased == 0)
                                        <button type="submit" style="float: right; margin-top: 16px; margin-right: 10px; margin-bottom: 20px" class="finder-but">
                                            @if ($program->program_isfree == 1)
                                                FREE
                                            @else
                                                $ {{$program->program_price}}
                                            @endif
                                        </button>
                                    @else
                                        <button type="button" style="float: right; margin-top: 16px; margin-right: 10px; margin-bottom: 20px" class="purchase-finish">
                                            Added
                                        </button>
                                    @endif

                            </div>
                        </div>
                    </div>
                </div>
                </form>
            @endforeach
        </div>
    </div>
@endsection
