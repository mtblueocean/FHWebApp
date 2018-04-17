@extends('layouts.app')

@section('content')

    <div class="dashboardBackground">
        <div class="dashboardContent">
            <div><!--header-->
                <div class="row" style="text-align: center">
                    <p style="margin-bottom:10px;margin-top:20px;margin-left:40px;font-size: 30px; font-weight: bold"><b>{{$programName}}</b></p>
                </div>
            </div><!--header-->
            <form id="docContent" name="docContent">
                <div class="infodoceditor" style="  text-align: center;">
                    <textarea name="editor1" id="editor1" rows="10" cols="80" style="width: 80%">
                    </textarea>
                    <script>
                        // Replace the <textarea id="editor1"> with a CKEditor
                        // instance, using default configuration.
                        CKEDITOR.replace( 'editor1',
                                {
                                    toolbar : 'Basic', /* this does the magic */
                                });
                    </script>
                </div>
                <br>
                <div style="text-align: center">
                    <button type="submit" class="next-but">Next</button>
                </div>

            </form>
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
                    console.log(docdata);

 			        CKEDITOR.instances.editor1.setData(docdata);
                }
            });
        });

        $('#docContent').submit(function(event){
            event.preventDefault();

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            $data = $("#docContent").serialize()

            $.ajax({
                type: "POST",
                url: "/programbuilder/infodoc/<?php echo $userid;?>/<?php echo $programid;?>/savedoc",
                data: $data,
                dataType: "json",
                success: function (data) {
                    var docid = data['docid'];
                    window.location='{{ url($nexturl) }}'
                },
                error: function (result) {
                    showAlert("Error saving doc.");
                }
            });
        });
    </script>
@endsection