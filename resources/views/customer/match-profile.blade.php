@extends('layouts.app')

@section('content')



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Matched Profile</div>

                <div class="card-body">
                	<div class="row">
                		@if(count($matchData)>0)
                		@foreach($matchData as $data)
                    		<div class="col-md-12">
                    			<div class="row" style="border: 1px solid gray;">
                    				<div class="col-md-4" style="text-align: center;">
                    					<i class="fa fa-user" style="font-size: 32px;"></i><br>
                    					{{$data['name']}}<br>{{$data['email']}}
                    				</div>
                    				<div class="col-md-8">
                    					<b>Matching Criteria</b>:<br>
                    					
                    					@if(@$data['partner_expected_income'])
                    					<p><b>Partner Expected Income</b>: {{$data['partner_expected_income']}}</p>
                    					@endif
                    					@if(@$data['partner_occupation'])
                    					<p><b>Partner Occupation</b>: {{$data['partner_occupation']}}</p>
                    					@endif
                    					@if(@$data['partner_family_type'])
                    					<p><b>Partner Family Type</b>: {{$data['partner_family_type']}}</p>
                    					@endif
                    					@if(@$data['partner_manglik'])
                    					<p><b>Partner Manglik</b>: {{$data['partner_manglik']}}</p>
                    					@endif
                    					@if(@$data['occupation'])
                    					<p><b>Occupation</b>: {{$data['occupation']}}</p>
                    					@endif
                    					@if(@$data['family_type'])
                    					<p><b>Family Type</b>: {{$data['family_type']}}</p>
                    					@endif
                    					@if(@$data['manglik'])
                    					<p><b>Manglik</b>: {{$data['manglik']}}</p>
                    					@endif
                    				</div>
                    			</div>
                    		</div>
                    	@endforeach
                    	@else
                    	<p>No Match Found</p>
                    	@endif
                	</div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection