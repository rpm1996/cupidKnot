<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {
  font-family: "Lato", sans-serif;
}

.sidenav {
  height: 100%;
  width: 160px;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  background-color: #111;
  overflow-x: hidden;
  padding-top: 20px;
}

.sidenav a {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: #818181;
  display: block;
}

.sidenav a:hover {
  color: #f1f1f1;
}

.main {
  margin-left: 160px; /* Same as the width of the sidenav */
  /*font-size: 28px;*/ /* Increased text to enable scrolling */
  padding: 0px 10px;
}

tr {
  font-size: 15px;
}

td {
  font-size: 15px !important;
}

@media screen and (max-height: 450px) {
  .sidenav {padding-top: 15px;}
  .sidenav a {font-size: 18px;}
}
</style>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" />
<link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>  
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
</head>
<body>


<div class="sidenav">
  <p style="color: white;">Hi {{ session()->get('admin_login') }}</p>
  <a href="{{url('all-users')}}">All Users</a>
  <a href="{{url('admin-logout')}}">Logout</a>
</div>

<div class="main">
    <div class="row" style="padding: 20px 20px;">
      <div class="col-md-12">

        <form action="{{url('all-users')}}" method="get">
          <div class="row">
            <div class="col-md-2">
              <label>Gender</label>
              <select name="gender" class="form-control">
                <option value=''>Select</option>
                <option value='Male' @if(Request::get('gender')=="Male") selected @endif>Male</option>
                <option value='Female' @if(Request::get('gender')=="Female") selected @endif>Female</option>
              </select>
            </div>
            <div class="col-md-2">
              <label>Income Range</label>
              <select name="incomeRange" class="form-control">
                <option value=''>Select</option>
                <option value='1000-100000' @if(Request::get('incomeRange')=="1000-100000") selected @endif>1000 - 10000</option>
                <option value='10000-100000' @if(Request::get('incomeRange')=="10000-100000") selected @endif>10000 - 100000</option>
                <option value='100000-100000000000000' @if(Request::get('incomeRange')=="100000-100000000000000") selected @endif>100000 - above</option>
              </select>
            </div>
            <div class="col-md-2">
              <label>Family Type</label>
              <select name="familytype" class="form-control">
                <option value=''>Select</option>
                <option value='Joint Family' @if(Request::get('familytype')=="Joint Family") selected @endif>Joint Family</option>
                <option value='Nuclear Family' @if(Request::get('familytype')=="Nuclear Family") selected @endif>Nuclear Family</option>
              </select>
            </div>
            <div class="col-md-2">
              <label>Manglik</label>
              <select name="manglik" class="form-control">
                <option value=''>Select</option>
                <option value='Yes' @if(Request::get('manglik')=="Yes") selected @endif>Yes</option>
                <option value='No' @if(Request::get('manglik')=="No") selected @endif>No</option>
                <option value='Both' @if(Request::get('manglik')=="Both") selected @endif>Both</option>
              </select>
            </div>
            <div class="col-md-2">
              <br>
              <button type="submit" class="btn btn-primary">Go</button>
              <a href="{{url('all-users')}}" class="btn btn-default">Reset</a>
            </div>
          </div> 
        </form>
        <br><br>
        <table id="example" class="table table-striped table-bordered" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Login as</th>
              <th>DOB</th>
              <th>Gender</th>
              <th>Annual Income (In INR)</th>
              <th>Occupation</th>
              <th>Family Type</th>
              <th>Manglik</th>
              <th>Partner Expected Income (In INR)</th>
              <th>Partner Occupation</th>
              <th>Partner Family Type</th>
              <th>Partner Manglik</th>
              <th>Created At</th> 
            </tr>
          </thead>
          <tbody>
            @php
            $count = 1;
            @endphp
            @foreach($getData as $data)
            @php
              $po = '';
              if($data->partner_occupation){
                $po = implode(', ', json_decode($data->partner_occupation, true));
              }
              $pft = '';
              if($data->partner_family_type){
                $pft = implode(', ', json_decode($data->partner_family_type, true));
              }

            @endphp
            <tr>
              <td>{{ $count }}</td>
              <td>{{ $data->first_name }} {{ $data->last_name }} </td>
              <td>{{ $data->email }}</td>
              <td>{{ $data->provider ?? "Web Register" }}</td>
              <td>{{ date('d-m-Y', strtotime($data->dob)) }}</td>
              <td>{{ $data->gender }}</td>
              <td>{{ $data->annual_income }}</td>
              <td>{{ $data->occupation }}</td>
              <td>{{ $data->family_type }}</td>
              <td>{{ $data->manglik }}</td>
              <td>{{ $data->partner_expected_income }}</td>
              <td>{{ $po }}</td>
              <td>{{ $pft }}</td>
              <td>{{ $data->partner_manglik }}</td>
              <td>{{ date('d-m-Y', strtotime($data->created_at)) }}</td>
            </tr>
            @php
            $count++;
            @endphp
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
</div>
   
</body>
<script>
  $(document).ready(function() {
    $('#example').DataTable();
} );
</script>
</html> 
