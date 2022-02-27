@extends('layouts.app')
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card"> 

                <div class="card-body">
                	<br>
					<center>
						<a style="color: #fff" href="{{ url('/login/google?source=register') }}" class="social_google">
						<i class="fa fa-google" aria-hidden="true" style="font-size:21px;margin-right:10px"></i>  {{ __('Sign up with Gmail') }}
						</a>
					</center>
					<br>
					<hr>
					<br>

                    @include('reg-form')
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
