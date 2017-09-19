
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-upload fa-fw"></i> Upload</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        <div class="row">
            <div class="col-lg-12">
                <div id="msg_success" class="alert alert-success alert-dismissable" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                                
                </div>
                <div id="msg_error" class="alert alert-danger alert-dismissable" style="display: none;">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                  
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        Form
                    </div>
                    <div class="panel-body">                       
                        <div class="row">
                            <div class="col-lg-6">
                                {!! Form::open(['url'=>'upload','files'=>true,'id'=>'myform']) !!}
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select name="select_upload_file" id="select_upload_file" class="form-control">
                                            <option value="borrower">Borrower's</option>
                                            <option value="comelec">Comelec</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>File input</label>
                                        <input type="file" id="myfile">
                                    </div>
                                    <div class="form-group">                                        
                                        <input type="submit" id="submit_btn" class="btn btn-outline btn-primary" value="Upload File"/>
                                        <span id="upload_lbl" style="margin-left: 50px;display: none;"><img src="{{ asset('/assets/icons/loading.gif') }}" style="width: 100px;"/> Uploading please wait...</span>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

    </div><!-- /Page Wrapper -->        

</div>
<script>
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
            $("#select_upload_file").attr('disabled','disabled');
            $("#msg_success").hide();
            $("#msg_error").hide();

            evt.stopPropagation(); // Stop stuff happening
            evt.preventDefault();

            var _data = new FormData();           
            if(files) {
                for(var x=0; x < files.length; x++) {
                    var file = files[x];
                    _data.append("myfiles", file); 
                }
                _data.append("_token", $("input[name='_token']").val());
                _data.append("select_upload_file", $("select[name='select_upload_file']").val());
                
                $.ajax({
                    url:"<?php echo url().'/upload' ?>",
                    type: "POST",
                    data: _data,
                    cache: false,
                    dataType: "json",
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        $("#upload_lbl").show();
                    },
                    success: function(result){
                        console.log("Success", result); 
                        resetForm();
                        if(result.total_rows_affected > 0) {
                            $("#msg_success").show().html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><p>Successful, Total records saved <b>"+ result.total_rows_affected +"</b></p>");
                        } else {
                            $("#msg_error").show().html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><p>An error was encountered, Total records saved <b>"+ result.total_rows_affected +"</b></p>");
                        }
                        
                        files = null;
                    },
                    error: function(err){
                        console.log("Error", err);
                        alert("Error: " + err.responseText);
                        resetForm();
                    },
                    complete: function(){
                        $("#upload_lbl").hide();
                    }
                });

            } else {
                alert("No file selected.");
                resetForm();
            }
        });
    });
    
    function resetForm() {
        document.getElementById("myform").reset();        
        $("#submit_btn").removeAttr('disabled');
        $("#myfile").removeAttr('disabled');
        $("#select_upload_file").removeAttr('disabled');
    }
</script>
@endsection