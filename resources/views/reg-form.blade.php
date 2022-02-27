<script type="text/javascript" src="{{ asset('js/form-validation.js?v='.date('his')) }}"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>
<link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/css/select2.min.css" rel="stylesheet" />

   
<div class="row" style="margin: 25px;">
    <div class="col-md-12">
        <form method="POST" action="{{url('/profile_store')}}" autocomplete="off">
            @csrf
            <input type="hidden" name="formType" value="{{$action}}">
            <p><b>Basic Information Section</b></p>
            
            <div class="row">
                <div class="col-md-6">
                    <label for="name">First Name<small style="color:red">*</small></label>
                    <input type="text" class="form-control required" name="first_name" value="{{ $getUser->first_name ?? old('first_name') }}">
                </div>

                <div class="col-md-6">
                    <label for="name">Last Name @if(@$getUser->provider!="google")<small style="color:red">*</small>@endif</label>
                    <input type="text" class="form-control @if(@$getUser->provider!="google") required @endif" name="last_name" value="{{ $getUser->last_name ?? old('last_name') }}">
                </div>

                @if($action=="Add")
                <div class="col-md-6">
                    <label for="email">Email<small style="color:red">*</small></label>
                    <input type="text" class="form-control email required" name="email" value="">
                    @if($errors->has('email'))
                        <span class="error">{{ $errors->first('email') }}</span>
                    @endif
                </div>

                <div class="col-md-6">
                    <label for="password">Password<small style="color:red">*</small></label>
                    <input type="password" class="form-control password required" name="password">
                </div>
                @endif

                <div class="col-md-6">
                    <label for="password">DOB<small style="color:red">*</small></label>
                    <input type="date" value="{{ @$getUser->dob ? date('Y-m-d', strtotime($getUser->dob)) : old('dob') }}" class="form-control required" id="dob" name="dob">
                </div>

                <div class="col-md-6">
                    <label>Gender<small style="color:red">*</small></label><br>
                    <input type="radio" class="required mn only-one gender" data-target-class="gender" name="gender" value="Male" @if(isset($getUser->gender) && $getUser->gender=="Male") checked @endif> Male 
                    <input type="radio" class="required mn only-one gender" data-target-class="gender" name="gender" value="Female" @if(isset($getUser->gender) && $getUser->gender=="Female") checked @endif> Female
                    <span class="gender-error"></span>
                </div>

                <div class="col-md-6">
                    <label>Annual income<small style="color:red">*</small></label>
                    <input type="number" class="required form-control" name="annual_income" min="1" value="{{ $getUser->annual_income ?? old('annual_income') }}">
                </div>

                <div class="col-md-6">
                    <label for="password">Occupation</label>
                    <select class="form-control" name="occupation">
                        <option value="">Select</option>
                        <option value="Private Job" @if(isset($getUser->occupation) && $getUser->occupation=="Private Job") selected @endif>Private Job</option>
                        <option value="Government Job" @if(isset($getUser->occupation) && $getUser->occupation=="Government Job") selected @endif>Government Job</option>
                        <option value="Business" @if(isset($getUser->occupation) && $getUser->occupation=="Business") selected @endif>Business</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="password">Family Type</label>
                    <select class="form-control" name="family_type">
                        <option value="">Select</option>
                        <option value="Joint Family" @if(isset($getUser->family_type) && $getUser->family_type=="Joint Family") selected @endif>Joint Family</option>
                        <option value="Nuclear Family" @if(isset($getUser->family_type) && $getUser->family_type=="Nuclear Family") selected @endif>Nuclear Family</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="password">Manglik</label>
                    <select class="form-control" name="manglik">
                        <option value="">Select</option>
                        <option value="Yes" @if(isset($getUser->manglik) && $getUser->manglik=="Yes") selected @endif>Yes</option>
                        <option value="No" @if(isset($getUser->manglik) && $getUser->manglik=="No") selected @endif>No</option>
                        <option value="Both" @if(isset($getUser->manglik) && $getUser->manglik=="Both") selected @endif>Both</option>
                    </select>
                </div>
            </div>
            <hr>
            <p><b>Partner Preference</b></p>
            <div class="row">
                <div class="col-md-6">
                    <label>Expected Income</label>
                    <div id="slider-range"></div>
                    <input type="text" id="amount" name="partner_expected_income" readonly style="border:0; color:#f6931f; font-weight:bold;">
                </div>
                <div class="col-md-6">
                    @php
                    $po = [];
                    if(isset($getUser->partner_occupation) && $getUser->partner_occupation){
                        $po = json_decode($getUser->partner_occupation, true);
                    }
                    @endphp
                    <label>Partner Occupation</label>
                    <select class="select2 form-control" name="partner_occupation[]" multiple> 
                        <option value="Private job" @if(in_array("Private job", $po)) selected @endif>Private job</option>
                        <option value="Government Job" @if(in_array("Government Job", $po)) selected @endif>Government Job</option>
                        <option value="Business" @if(in_array("Business", $po)) selected @endif>Business</option>
                    </select>
                </div>
                <div class="col-md-6">
                    @php
                    $ft = [];
                    if(isset($getUser->partner_family_type) && $getUser->partner_family_type){
                        $ft = json_decode($getUser->partner_family_type, true);
                    }
                    @endphp
                    <label>Family Type</label>
                    <select class="select2 form-control" name="partner_family_type[]" multiple> 
                        <option value="Joint Family" @if(in_array("Joint Family", $ft)) selected @endif>Joint Family</option>
                        <option value="Nuclear Family" @if(in_array("Nuclear Family", $ft)) selected @endif>Nuclear Family</option> 
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="password">Manglik</label>
                    <select class="form-control" name="partner_manglik">
                        <option value="">Select</option>
                        <option value="Yes" @if(isset($getUser->partner_manglik) && $getUser->manglik=="Yes") selected @endif>Yes</option>
                        <option value="No" @if(isset($getUser->partner_manglik) && $getUser->manglik=="No") selected @endif>No</option>
                        <option value="Both" @if(isset($getUser->partner_manglik) && $getUser->manglik=="Both") selected @endif>Both</option>
                    </select>
                </div>
            </div>

            <div class="col-md-12"> 
                <button type="submit" class="btn btn-primary">
                   @if($action=="Add") Register @else Update @endif
                </button>
                @if($action=="Add") <br><br><a href="{{url('login')}}">Already have account, Sign In ?</a>@endif 
            </div>
        </form> 
    </div>
</div>

 <script>
  $( function() {

    var ranges = "{{ $getUser->partner_expected_income ?? '1000 - 100000' }}";
    var rangeData = ranges.split(' - ');

    if(rangeData){
        minV = rangeData['0'];
        maxV = rangeData['1'];
    }

    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 1000000,
      values: [ minV, maxV ],
      slide: function( event, ui ) {
        $( "#amount" ).val( ui.values[ 0 ] + " - " + ui.values[ 1 ] );
      }
    });
    $( "#amount" ).val( $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
  } );

  
  $(document).ready(function() {
    $('.select2').select2({
      placeholder: 'Select',
      allowClear: true,
    });
  });
    
$(document).ready( function() {
    var datestring = $('#dob').val(); 
    var dateobj    = new Date(datestring);
    var formattedstring = dateobj.getUTCDate()+"/"+dateobj.getUTCMonth()+"/"+dateobj.getUTCFullYear();
    $(this).val(formattedstring);
});

  </script>
