<html>
    <head>
        <title>Upload File</title>
        <script src="{{ asset('/assets/vendor/jquery/jquery.min.js') }}"></script>
        <script type="text/javascript">
        $(document).ready(function(){
            var files;
            // Input Files
            $("input[type=file]").on('change', function(evt){
                files = evt.target.files;
            });
            
            // Form Submit
            $("form").on("submit", function(evt){
                
                $("#submit_btn").attr('disabled','disabled');
                $("#myfile").attr('disabled','disabled');
                
                evt.stopPropagation(); // Stop stuff happening
                evt.preventDefault();
                                
                var _data = new FormData();
                if(files) {
                    for(var x=0; x < files.length; x++) {
                        var file = files[x];
                        _data.append("myfiles", file); 
                    }
                    _data.append("_token", $("input[name='_token']").val());
                                        
                    $.ajax({
                        url:"<?php echo url().'/upload' ?>",
                        type: "POST",
                        data: _data,
                        cache: false,
                        dataType: "json",
                        processData: false,
                        contentType: false,
                        success: function(result){
                            console.log("Success", result); 
                            
                            document.getElementById("myform").reset();
                            $("#submit_btn").removeAttr('disabled');
                            $("#myfile").removeAttr('disabled');
                        },
                        error: function(err){
                            console.log("Error", err.responseText);
                        }
                    });
                
                }                               
            });
        });
        </script>
    </head>
    <body>
        <div id="result"></div>
        <hr>
        <br>
        <div>
            {!! Form::open(['url'=>'pr','files'=>true,'id'=>'myform']) !!}
                <div>
                    <input type="file" id="myfile">
                </div>
                <br><br>
                <div>
                    <input type="submit" id="submit_btn" value="Upload File">
                </div>
            {!! Form::close() !!}
        </div>
    </body>
</html>
