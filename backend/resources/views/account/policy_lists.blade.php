
@extends('common.master')


@section('bodyContent')
<div id="wrapper">
    @include('common.navigation')

    <!-- Page Wrapper -->
    <div id="page-wrapper">		
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Policy Lists</h1>                    
            </div>
            <!-- /.col-lg-12 -->
        </div>

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

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Tables                            
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                                <tr>                                    	
                                    <th>Policy No.</th>
                                    <th>Valid From</th>
                                    <th>Valid Until</th>
                                    <th>Vehicle Type</th>
                                    <th>Name</th>
                                    <th>Phone</th>                                        
                                </tr>
                            </thead>
                            <tbody>
                                @if($records)
                                @foreach($records as $key => $record)
                                <tr row-id="{{ $record->id }}">											
                                    <td>{{ $record->policy_no }}</td>
                                    <td>{{ $record->date_from }}</td>
                                    <td>{{ $record->date_to }}</td>
                                    <td>{{ $record->vehicle_type }}</td>
                                    <td>{{ $record->firstname." ". $record->middlename.". ". $record->lastname }}</td>
                                    <td>{{ $record->phone }}</td>
                                </tr>
                                @endforeach
                                @endif	                                    	                                   
                            </tbody>
                        </table>
                    </div><!-- /.panel-body -->                        
                </div><!-- /.panel -->                    
            </div><!-- /.col-lg-12 -->                
        </div><!-- /.row -->

    </div><!-- /Page Wrapper -->        

</div>
<script>
    $(document).ready(function () {
        $('#dataTables-example').DataTable({
            responsive: true
        });
        
        // Table click
        $("table > tbody > tr").on("click", function(){
            var row_id = $(this).attr("row-id");
            var url = $("base").attr("href");
            
            location.href = url +"/policy/"+ row_id +"/edit";
        });
    });
</script>
@endsection