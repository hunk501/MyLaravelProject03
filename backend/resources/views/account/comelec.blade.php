
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><i class="fa fa-search fa-fw"></i> Comelec</h1>
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
                        Find registered relatives in comelec records.
                    </div>
                    <div class="panel-body">                       
                        <div class="row">
                            <div class="col-lg-12">
                                {!! Form::open(['url'=>'upload','files'=>true,'id'=>'myform']) !!}         
                                <div class="form-group input-group">
                                    <input type="text" id="search_text" class="form-control" value="{{ $borrower_name }}" readonly="true">
                                    <input type="hidden" id="record_id" value="{{ $application_id }}"/>
                                    <span class="input-group-btn">
                                        <button id="auto_link_btn" class="btn btn-primary" type="button">
                                            <i class="fa fa-refresh"></i> Reload
                                        </button>
                                    </span>
                                </div>
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
        $("#auto_link_btn").attr('disabled','disabled');
        $("#results").html('<center><img src="<?php echo asset('/assets/icons/loading.gif'); ?>" style="margin: auto;"/></center>');
        
        // auto link Btn
        $("#auto_link_btn").on("click", function(){
            callAutoLink();
        }); 
        
        setTimeout(function(){
            callAutoLink();
        }, 1600);
    });
    
    function callAutoLink() {
        $("#msg_error").hide();
        $("#msg_success").hide();        
        var base_url = $("base").attr("href");
        //var co_borrower = $("#co_borrower").val();
        //var character_reference   = $("#character_reference").val();
        var record_id = $("#record_id").val();
        var _token = $("input[name='_token']").val();
        var _data = {"_token":_token, 'record_id':record_id };
        $.ajax({                
            type: "GET",
            url: base_url +"/search/comelec/"+ record_id,
            data: _data,
            dataType: "json",
            beforeSend: function(){
                $("#auto_link_btn").attr('disabled','disabled');
                $("#results").html('<center><img src="<?php echo asset('/assets/icons/loading.gif'); ?>" style="margin: auto;"/></center>');
            },
            success: function(result){
                console.log(result);
                var cls = (parseInt(result.total) > 0) ? 'btn-success':'btn-danger';                
                var _div = "<div><h4>Result: <span class='btn "+ cls +" btn-circle'>"+ result.total +"</span></h4></div><table class='table' style='font-size: 10pt;'>";                
                if(result && result.total) {
                    _div += "<thead><tr><th>No.</th><th>Voters Name</th><th>Address</th><th>Birthday</th><th>Barangay</th><th>City</th></tr></thead><tbody>";
                    var application = result.records;                    
                    var lop = 1;
                    for(var x in application) {                    	
                    	_div += "<tr><td style='width: 60px;'>"+ lop +".</td>";
                        _div += "<td>"+ application[x]['voters_name'] +"</td>";
                        _div += "<td>"+ application[x]['voters_address'] +"</td>";
                        _div += "<td>"+ application[x]['bday'] +"</td>";
                        _div += "<td>"+ application[x]['baranggay'] +"</td>";                        
                        _div += "<td>"+ application[x]['city'] +"</td>";
                        lop++; 
                    }                    
                    _div += "</tbody></table>";
                } 
                else {
                    var _m = "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><p>No match result</p>";
                    $("#msg_error").html(_m).show();
                }
                $("#results").html(_div);                                        
                $("#auto_link_btn").removeAttr('disabled');
                console.log("result", result);

                // View Moddal
                $("table > tbody > tr > td > a").on("click", function(){
                    var app_id = $(this).attr("app_id");
                    console.log("APP: "+ app_id);    
                    // Call Ajax
                    callAjax(app_id);
                });
            },
            error: function(err) {
                console.log("error", err.responseText);
                $("#auto_link_btn").removeAttr('disabled');
            }
        });
    }
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
                    var _table = "<table><tbody>";
                    var records = result.records;
                    for(var x=0; x < records.length; x++) {                        
                        _table += "<tr><td><b>Branch:</b><td><td>"+ records[x]['branch'] +"</td></tr>";
                        _table += "<tr><td><b>PNNO:</b><td><td>"+ records[x]['pnno'] +"</td></tr>";
                        _table += "<tr><td><b>Type:</b><td><td>"+ records[x]['type'] +"</td></tr>";
                        _table += "<tr><td><b>Name:</b><td><td>"+ records[x]['borrower_name'] +"</td></tr>";
                        _table += "<tr><td><b>Address:</b><td><td>"+ records[x]['borrower_address'] +"</td></tr>";
                        _table += "<tr><td><b>Contact:</b><td><td>"+ records[x]['tel_no'] +"</td></tr>";
                        _table += "<tr><td><b>Birthdate:</b><td><td>"+ records[x]['bday'] +"</td></tr>";
                        _table += "<tr><td><b>Spouse:</b><td><td>"+ records[x]['spouse'] +"</td></tr>";
                        _table += "<tr><td><b>TIN:</b><td><td>"+ records[x]['tin'] +"</td></tr>";
                        _table += "<tr><td><b>SSS:</b><td><td>"+ records[x]['sss'] +"</td></tr>";
                        _table += "<tr><td><b>Email Address:</b><td><td>"+ records[x]['email_address'] +"</td></tr>";
                        _table += "<tr><td><b>Business Name:</b><td><td>"+ records[x]['business_name'] +"</td></tr>";
                        _table += "<tr><td><b>Business Contact:</b><td><td>"+ records[x]['business_contact'] +"</td></tr>";
                        _table += "<tr><td><b>Business Address:</b><td><td>"+ records[x]['business_address'] +"</td></tr>"; 

                        _table += "<tr><td><b>Co-Maker:</b><td><td>"+ records[x]['comaker'] +"</td></tr>";
                        _table += "<tr><td><b>Co-Maker Contact:</b><td><td>"+ records[x]['comaker_contact'] +"</td></tr>";
                        _table += "<tr><td><b>Co-Maker Social Media:</b><td><td>"+ records[x]['comaker_social_media'] +"</td></tr>";
                        _table += "<tr><td><b>Co-Maker Address:</b><td><td>"+ records[x]['comaker_address'] +"</td></tr>";
                                               
                        _table += "<tr><td><b>Co-Borrower:</b><td><td>"+ records[x]['co_borrower'] +"</td></tr>";
                        _table += "<tr><td><b>Co-Borrower Contact:</b><td><td>"+ records[x]['co_borrower_contact'] +"</td></tr>";
                        _table += "<tr><td><b>Co-Borrower Address:</b><td><td>"+ records[x]['co_borrower_address'] +"</td></tr>";
                        _table += "<tr><td><b>Character Reference:</b><td><td>"+ records[x]['character_reference'] +"</td></tr>";
                        _table += "<tr><td><b>Character Contact:</b><td><td>"+ records[x]['character_contact'] +"</td></tr>";
                        _table += "<tr><td><b>Character Address:</b><td><td>"+ records[x]['reference_address'] +"</td></tr>";                        
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
    function showRecModal() {
        $(".modal-body").html("");
        $("#myModal").modal();
    }
</script>
@endsection