
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h3 class="page-header">Edit Borrower</h3>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- /.row -->
        
        @if(Session::has('success'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session::get('success') }}
                </div>
            </div>
        </div>
        @endif
        @if(Session::has('error'))
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">x</button>
                    {{ Session::get('error') }}
                </div>
            </div>
        </div>
        @endif
        
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Form
                    </div>
                    <div class="panel-body">
                    	{!! Form::open(['method'=>'PUT', 'url'=>'encode/'.$records['id'], 'files'=>true ]) !!}
                    	<div class="panel-group" id="accordion">
                    		
                    		<!-- Borrower -->
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">Form #1 Borrower</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse">
                                    <div class="panel-body">                                        
                                        <div class="form-group">
	                                        <label>Branch</label>
	                                        <input type="text" name="branch" class="form-control" value="{{ $records['branch'] }}"/>
	                                        @if($errors->has('branch'))
	                                        <p class="help-block">{{ $errors->first('branch') }}</p>
	                                        @endif
	                                    </div>
	                                    <div class="form-group">
	                                        <label>PNNO</label>
	                                        <input type="text" name="pnno" class="form-control" value="{{ $records['pnno'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Type</label>
	                                        <input type="text" name="type" class="form-control" value="{{ $records['type'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Borrower's Name</label>
	                                        <input type="text" name="borrower_name" placeholder="Lastname, Firstname Middlename" class="form-control" value="{{ $records['borrower_name'] }}"/>
	                                        @if($errors->has('borrower_name'))
	                                        <p class="help-block">{{ $errors->first('borrower_name') }}</p>
	                                        @endif
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Borrower Address</label>
	                                        <textarea name="borrower_address" class="form-control">{{ $records['borrower_address'] }}</textarea>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Character URL</label>
	                                        <input type="text" name="character_url" class="form-control" value="{{ $records['character_url'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Contact</label>
	                                        <input type="text" name="tel_no" class="form-control" value="{{ $records['tel_no'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Birthday</label>
	                                        <input type="text" name="bday" value="{{ $records['bday'] }}"  class="datepicker form-control" placeholder="YYYY-MM-DD" readonly="true" style="cursor: pointer;background-color: rgba(255, 255, 255, 0.15);"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Spouse</label>
	                                        <input type="text" name="spouse" class="form-control" value="{{ $records['spouse'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>TIN</label>
	                                        <input type="text" name="tin" class="form-control" value="{{ $records['tin'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>SSS</label>
	                                        <input type="text" name="sss" class="form-control" value="{{ $records['sss'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Email Address</label>
	                                        <input type="text" name="email_address" class="form-control" value="{{ $records['email_address'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Business Name</label>
	                                        <input type="text" name="business_name" class="form-control" value="{{ $records['business_name'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Business Contact</label>
	                                        <input type="text" name="business_contact" class="form-control" value="{{ $records['business_contact'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Business Address</label>
	                                        <textarea name="business_address" class="form-control">{{ $records['business_address'] }}</textarea>
	                                    </div>                                        
                                    </div> <!-- /panel-body -->                                
                                </div> <!-- /collapseOne -->
                            </div>
                    		<!-- /Borrower -->
                    		
                    		<!-- Co-Maker -->
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">Form #2 Co-Maker</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    	<div class="form-group">
	                                        <label>Co-Maker</label>
	                                        <input type="text" name="comaker" class="form-control" value="{{ $records['comaker'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Co-Maker Contact</label>
	                                        <input type="text" name="comaker_contact" class="form-control" value="{{ $records['comaker_contact'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Co-Maker Social Media</label>
	                                        <input type="text" name="comaker_social_media" class="form-control" value="{{ $records['comaker_social_media'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Co-Maker Address</label>
	                                        <textarea name="comaker_address" class="form-control">{{ $records['comaker_address'] }}</textarea>
	                                    </div>
                                    </div> <!-- /panel-body -->                                
                                </div> <!-- /collapseTwo -->
                            </div>
                    		<!-- /Co-Maker -->
                    		
                    		<!-- Co-Borrower -->
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">Form #3 Co-Borrower</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    	<div class="form-group">
	                                        <label>Co-Borrower</label>
	                                        <input type="text" name="co_borrower" class="form-control" value="{{ $records['co_borrower'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Co-Borrower Contact</label>
	                                        <input type="text" name="co_borrower_contact" class="form-control" value="{{ $records['co_borrower_contact'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Co-Borrower Address</label>
	                                        <textarea name="co_borrower_address" class="form-control">{{ $records['co_borrower_address'] }}</textarea>
	                                    </div>
                                    </div> <!-- /panel-body -->                                
                                </div> <!-- /collapseTwo -->
                            </div>
                    		<!-- /Co-Borrower -->
                    		
                    		<!-- Character Reference -->
                    		<div class="panel panel-primary">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour">Form #4 Character Reference</a>
                                    </h4>
                                </div>
                                <div id="collapseFour" class="panel-collapse collapse">
                                    <div class="panel-body">
                                    	<div class="form-group">
	                                        <label>Character Reference</label>
	                                        <textarea name="character_reference" class="form-control">{{ $records['character_reference'] }}</textarea>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Character Reference Contact</label>
	                                        <textarea name="character_contact" class="form-control">{{ $records['character_contact'] }}</textarea>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Character Reference Address</label>
	                                        <textarea name="reference_address" class="form-control">{{ $records['reference_address'] }}</textarea>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Character Reference URL</label>
	                                        <input type="text" name="reference_url" class="form-control" value="{{ $records['reference_url'] }}"/>
	                                    </div>
	                                    <div class="form-group">
	                                        <label>Character Reference Relation</label>
	                                        <input type="text" name="relation" class="form-control" value="{{ $records['relation'] }}"/>
	                                    </div>
                                    </div> <!-- /panel-body -->                                
                                </div> <!-- /collapseFour -->
                            </div>
                    		<!-- /Character Reference -->
                    		
                    		<br><br>
                    		<div class="form-group">                                        
                            	<input type="submit" name="submit_form" id="submit_btn" class="btn btn-outline btn-success" value="Update Change"/>                                        
                            </div>
                    	</div>
                    	{!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div><!-- /.row -->

    </div><!-- /Page Wrapper -->        

</div>
<script>
$(document).ready(function(){
	
	// Date Picker
	$('.datepicker').datepicker({
		format: "yyyy-mm-dd"
	})
	.on('changeDate', function(){
		$(this).datepicker('hide');
	});

});
</script>
@endsection