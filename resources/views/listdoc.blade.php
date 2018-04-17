@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row" style="text-align: center">
                    <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>{{$programName}}</b></p>
                </div>
            </div><!--header-->
                <div class="infodoceditor" id="textdiv" name="textdiv" style="background-color: rgb(236,236,236); padding: 20px;">

                </div>
                <br>
                <div style="text-align: center; margin-bottom: 20px; margin-top: 20px">
                    <form action="{{url($nexturl)}}" method="POST">
                        {!! csrf_field() !!}
                        <button type="button" class="back-but" onclick="window.location='{{ url($backurl) }}'">Back</button>
                        <button type="submit" class="next-but">Next</button>
                    </form>

                </div>
        </div>
    </div>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function()
        {
            var data = {
                ProgramId: "<?php echo $programid;?>",
                ProgramType: "infodoc"
            }

            $.ajax({
                method: "GET",
                url: "/programbuilder/infodoc/<?php echo $userid;?>/<?php echo $programid;?>/data",
                data:data,
                success: function(data)
                {
                    console.log(data);
                    var docdata = data['docdata'];
                    $("#textdiv").html(docdata);
                }
            });
        });

        /*$('#docContent').submit(function(event){
            event.preventDefault();

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $data = $("#docContent").serialize()

            $.ajax({
                type: "POST",

                data: $data,
                dataType: "json",
                success: function (data) {
                    var docid = data['docid'];

                    window.location.replace(nexturl);
                },
                error: function (result) {
                    showAlert("Error saving doc.");
                }
            });
        });*/
    </script>
@endsection