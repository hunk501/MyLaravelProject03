
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Policy Edit</h1>                    
            </div>                
        </div><!-- /.col-lg-12 -->

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Basic Forms</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                {!! Form::open(['method'=>'PUT', 'url'=>'policy/'.$records['id'] ]) !!}
                                <div class="form-group">
                                    <label>Policy No.</label>
                                    <input type="text" name="policy_no" class="form-control" value="{{ $records['policy_no'] }}">
                                    @if($errors->has('product_name'))
                                    <p class="help-block">{{ $errors->first('product_name') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Firstname</label>
                                    <input type="text" name="firstname" class="form-control" value="{{ $records['firstname'] }}">                                            
                                    @if($errors->has('firstname'))
                                    <p class="help-block">{{ $errors->first('firstname') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>MI</label>
                                    <input type="text" name="middlename" class="form-control" value="{{ $records['middlename'] }}">                                            
                                    @if($errors->has('middlename'))
                                    <p class="help-block">{{ $errors->first('middlename') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Lastname</label>
                                    <input type="text" name="lastname" class="form-control" value="{{ $records['lastname'] }}">                                            
                                    @if($errors->has('lastname'))
                                    <p class="help-block">{{ $errors->first('lastname') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Address</label>
                                    <input type="text" name="address" class="form-control" value="{{ $records['address'] }}">                                            
                                    @if($errors->has('address'))
                                    <p class="help-block">{{ $errors->first('address') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $records['phone'] }}">                                            
                                    @if($errors->has('phone'))
                                    <p class="help-block">{{ $errors->first('phone') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Type</label>
                                    <input type="text" name="vehicle_type" class="form-control" value="{{ $records['vehicle_type'] }}">                                            
                                    @if($errors->has('vehicle_type'))
                                    <p class="help-block">{{ $errors->first('vehicle_type') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Color</label>
                                    <input type="text" name="vehicle_color" class="form-control" value="{{ $records['vehicle_color'] }}">                                            
                                    @if($errors->has('vehicle_color'))
                                    <p class="help-block">{{ $errors->first('vehicle_color') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Plate Number</label>
                                    <input type="text" name="vehicle_platenumber" class="form-control" value="{{ $records['vehicle_platenumber'] }}">                                            
                                    @if($errors->has('vehicle_platenumber'))
                                    <p class="help-block">{{ $errors->first('vehicle_platenumber') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Vehicle ORCR</label>
                                    <input type="text" name="vehicle_orcr" class="form-control" value="{{ $records['vehicle_orcr'] }}">                                            
                                    @if($errors->has('vehicle_orcr'))
                                    <p class="help-block">{{ $errors->first('vehicle_orcr') }}</p>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label>Vehicle Seats</label>
                                    <input type="text" name="vehicle_seats" class="form-control" value="{{ $records['vehicle_seats'] }}">                                            
                                    @if($errors->has('vehicle_seats'))
                                    <p class="help-block">{{ $errors->first('vehicle_seats') }}</p>
                                    @endif
                                </div>
                                <input type="submit" name="submit" value="Submit value" class="btn btn-primary">                                                                               
                                {!! Form:: close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div><!-- /Page Wrapper -->        

</div>
<script>
    
</script>
@endsection
