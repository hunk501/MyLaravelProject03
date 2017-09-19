
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-search fa-fw"></i> Search</h1>
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
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        Form
                    </div>
                    <div class="panel-body">                       
                        <div class="row">
                            <div class="col-lg-12">
                                {!! Form::open(['url'=>'search','files'=>true,'id'=>'myform']) !!}         
                                <table style="width: 100%;">
                                    <tr>
                                        <td>
                                            <div class="form-group">
                                                <select id="search_column" class="form-control">
                                                    <option value="borrower_name">Borrower Name</option>
                                                    <option value="sss">SSS</option>
                                                    <option value="tin">TIN</option>
                                                    <option value="borrower_address">Borrower Address</option>
                                                    <option value="email_address">Email Address</option>
                                                    <option value="spouse">Spouse</option>
                                                    <option value="co_borrower">Co-Borrower</option>
                                                    <option value="character_reference">Character Reference</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group input-group" style="margin-left: 10px;">
                                                <input type="text" id="search_text" class="form-control" placeholder="Please enter search text..." style="width: 100%;">
                                                <span class="input-group-btn">
                                                    <button id="search_btn" class="btn btn-primary" type="button">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                </span>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <div class="row">
                            <div id="results" class="col-lg-12"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

    </div><!-- /Page Wrapper -->        

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Account Details</h4>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
    $(document).ready(function(){
        
        var base_url = $("base").attr("href");
        
        // Search Btn
        $("#search_btn").on("click", function(){            
            $("#msg_error").hide();
            $("#msg_success").hide();
            var search_column = $("#search_column").val();
            var search_text   = $("#search_text").val();
            var _token = $("input[name='_token']").val();
            var _data = {"search_column":search_column, "search_text":search_text, "_token":_token};
            if(search_text == "") {
                var _m = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><p>Please enter search text.</p>";
                $("#msg_error").html(_m).show();
                return false;
            }
            
            $.ajax({                
                type: "POST",
                url: "<?php echo url('/search/filter'); ?>",
                data: _data,
                dataType: "json",
                beforeSend: function(){
                    $("#results").html('<center><img src="<?php echo asset('/assets/icons/loading.gif'); ?>" style="margin: auto;"/></center>');
                },
                success: function(result){
                    var cls = (parseInt(result.total) > 0) ? 'btn-success':'btn-danger';
                    var _div = "<div><h4>Result: <span class='btn "+ cls +" btn-circle'>"+ result.total +"</span></h4></div><table id='tbl_results' class='table table-hover'>";                    
                    if(result && result.total) {
                        _div += "<thead><tr><th>No.</th><th>Name</th><th>Action</th></tr></thead><tbody>";
                        var application = result.application
                        var lop = 1;
                        for(var x=0; x < application.length; x++) {                            
                            _div += "<tr id='row_"+ application[x]['id'] +"'><td style='width: 60px;'>"+ lop +".</td>";
                            _div += "<td>"+ application[x]['borrower_name'] +"</td>";
                            _div += "<td><a href='"+ base_url +"/search/"+ application[x]['id'] +"' class='btn btn-success btn-xs' target='_blank'><i class='fa fa-chain'></i> Auto Link</a> &nbsp;&nbsp; ";
                            _div += "<a href='#' app_id='"+ application[x]['id'] +"' class='btn btn-primary btn-xs view_rec_modal'><i class='fa fa-info-circle'></i> View</a> &nbsp;&nbsp; ";
                            _div += "<a href='#' app_id='"+ application[x]['id'] +"' class='btn btn-danger btn-xs remv_rec'><i class='fa fa-trash-o'></i> Delete</a> &nbsp;&nbsp; ";
                            _div += "<a href='"+ base_url +"/encode/"+ application[x]['id'] +"/edit' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Edit</a></td></tr>";
                            lop++;
                        }
                        _div += "</tbody></table>";
                    }
                    else {
                        var _m = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><p>No match result</p>";
                        $("#msg_error").html(_m).show();
                    }
                    $("#results").html(_div);
                    console.log("success", result);
                    // View Modal
                    $("table > tbody > tr > td > a.view_rec_modal").on("click", function(e){
                        e.preventDefault();
                        var app_id = $(this).attr("app_id");                        
                        // Call Ajax                        
                        callAjax(app_id);
                    });
                    // Remove
                    $("table > tbody > tr > td > a.remv_rec").on("click", function(e){
                        e.preventDefault();
                        var app_id = $(this).attr("app_id");                        
                        // Call Ajax
                        if(confirm("Are you sure this will be remove permanently, Continue anyway.?")) {
                          callAjaxRemove(app_id);                           
                        }                                                
                    });
                },
                error: function(err) {
                    console.log("error", err.responseText);
                }
            });
        });
    });
    
    function callAjax(app_id) {
        var base_url = $("base").attr("href");
        var _token = $("input[name='_token']").val();
        var _data = {"app_id":app_id,"_token":_token};
        $.ajax({
            type: "POST",
            url: base_url +"/search/viewAppDetails",
            data: _data,
            dataType: "json",
            beforeSend: function(){                
                showRecModal();
            },
            success: function(result){
                console.log(result);
                if(result) {
                    var _table = "<table class='table'><tbody>";
                    var records = result.records;
                    for(var x=0; x < records.length; x++) {                        
                        _table += "<tr><td><b>Branch:</b><td><td><input type='text' class='form-control' value='"+ records[x]['branch'] +"'/></td></tr>";
                        _table += "<tr><td><b>PNNO:</b><td><td><input type='text' class='form-control' value='"+ records[x]['pnno'] +"'/></td></tr>";
                        _table += "<tr><td><b>Type:</b><td><td><input type='text' class='form-control' value='"+ records[x]['type'] +"'/></td></tr>";
                        _table += "<tr><td><b>Name:</b><td><td><input type='text' class='form-control' value='"+ records[x]['borrower_name'] +"'/></td></tr>";
                        _table += "<tr><td><b>Address:</b><td><td><textarea class='form-control'>"+ records[x]['borrower_address'] +"</textarea></td></tr>";
                        _table += "<tr><td><b>Contact:</b><td><td><input type='text' class='form-control' value='"+ records[x]['tel_no'] +"'/></td></tr>";
                        _table += "<tr><td><b>Birthdate:</b><td><td><input type='text' class='form-control' value='"+ records[x]['bday'] +"'></td></tr>";
                        _table += "<tr><td><b>Spouse:</b><td><td><input type='text' class='form-control' value='"+ records[x]['spouse'] +"'/></td></tr>";
                        _table += "<tr><td><b>TIN:</b><td><td><input type='text' class='form-control' value='"+ records[x]['tin'] +"'/></td></tr>";
                        _table += "<tr><td><b>SSS:</b><td><td><input type='text' class='form-control' value='"+ records[x]['sss'] +"'/></td></tr>";
                        _table += "<tr><td><b>Email Address:</b><td><td><input type='text' class='form-control' value='"+ records[x]['email_address'] +"'/></td></tr>";
                        _table += "<tr><td><b>Business Name:</b><td><td><input type='text' class='form-control' value='"+ records[x]['business_name'] +"'/></td></tr>";
                        _table += "<tr><td><b>Business Contact:</b><td><td><input type='text' class='form-control' value='"+ records[x]['business_contact'] +"'/></td></tr>";
                        _table += "<tr><td><b>Business Address:</b><td><td><input type='text' class='form-control' value='"+ records[x]['business_address'] +"'/></td></tr>";

                        _table += "<tr><td><b>Co-Maker:</b><td><td><input type='text' class='form-control' value='"+ records[x]['comaker'] +"'/></td></tr>";
                        _table += "<tr><td><b>Co-Maker Contact:</b><td><td><input type='text' class='form-control' value='"+ records[x]['comaker_contact'] +"'/></td></tr>";
                        _table += "<tr><td><b>Co-Maker Social Media:</b><td><td><input type='text' class='form-control' value='"+ records[x]['comaker_social_media'] +"'/></td></tr>";
                        _table += "<tr><td><b>Co-Maker Address:</b><td><td><textarea class='form-control'>"+ records[x]['comaker_address'] +"</textarea></td></tr>";
                                            
                        _table += "<tr><td><b>Co-Borrower:</b><td><td><input type='text' class='form-control' value='"+ records[x]['co_borrower'] +"'/></td></tr>";
                        _table += "<tr><td><b>Co-Borrower Contact:</b><td><td><input type='text' class='form-control' value='"+ records[x]['co_borrower_contact'] +"'/></td></tr>";
                        _table += "<tr><td><b>Co-Borrower Address:</b><td><td><textarea class='form-control'>"+ records[x]['co_borrower_address'] +"</textarea></td></tr>";
                        _table += "<tr><td><b>Character Reference:</b><td><td><textarea class='form-control'>"+ records[x]['character_reference'] +"</textarea></td></tr>";
                        _table += "<tr><td><b>Character Contact:</b><td><td><textarea class='form-control'>"+ records[x]['character_contact'] +"</textarea></td></tr>";
                        _table += "<tr><td><b>Character Address:</b><td><td><textarea class='form-control'>"+ records[x]['reference_address'] +"</textarea></td></tr>";                        
                    }
                    _table += "</tbody></table>";
                    $(".modal-body").html(_table);
                }                
            },
            error: function(){
                console.log("ERROR");
            }
        });
    }

    function callAjaxRemove(app_id) {
    	var base_url = $("base").attr("href");
        var _token = $("input[name='_token']").val();
        var _data = {"app_id":app_id,"_token":_token};
        $.ajax({
            type: "POST",
            url: base_url +"/search/deleteRecord",
            data: _data,
            dataType: "json",
            beforeSend: function(){                
                
            },
            success: function(result){
                console.log(result);
                $("input[name='_token']").val(result['_token']); // Update token          
                if(result['status']) {
                	$("#row_"+ app_id).remove();
                } else {
                    alert('Unable to delete please try again later.');
                }
            },
            error: function(){
            	alert('Ajax Error');
            }
        });
    }
    
    function showRecModal() {
        $(".modal-body").html("");
        $("#myModal").modal();
    }
</script>
@endsection