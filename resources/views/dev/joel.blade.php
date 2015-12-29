<!DOCTYPE html>
<html lang="en">
<head>
    <title>Transport App</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.0/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.0/js/bootstrap-toggle.min.js"></script>
    <style>
.col-sm-2, .col-sm-4{
	padding-left: 5px;
	padding-right: 5px;
	padding-top: 5px;
}
</style>
    <link href="{{ asset('/css/style.css') }}" rel="stylesheet">
</head>
<body> 
<div class="container" style="width:100%">
	<div class="row">
		<div class="col-sm-2">
			<div id="panelOne" class="panel panel-default">
				<div id="panelHeading" class="panel-heading text-center">
					Events 
				</div>
                <div id="eventOne" class="panel-body">
                    <div class="panel-body row">
                        <div class="col-sm-4"><img src="{{ asset('/img/christmas.jpg') }}" class="img-responsive img-circle" alt="christmas" width="50" height="50">
                        </div> 

                        <div class="col-sm-8 text-center"><p>UQ7 New Year's Eve Party 2015</p></div>
                    </div>
                    <div class="panel-body row">
                        <div class="col-sm-6 text-center">time</div>
                        <div class="col-sm-6 text-center">date</div>
                    </div>
                    <div class="panel-body row">
                        <div class="col-sm-12 text-center"><button type="button" class="btn btn-primary">Select</button></div>
                    </div>
                </div>
                 <div id="eventTwo" class="panel-body">
                    <div class="panel-body row">
                        <div class="col-sm-4"><img src="{{ asset('/img/christmas.jpg') }}" class="img-responsive img-circle" alt="christmas" width="50" height="50">
                        </div> 

                        <div class="col-sm-8 text-center"><p>Adeline's 28th birthday</p></div>
                    </div>
                    <div class="panel-body row">
                        <div class="col-sm-6 text-center">time</div>
                        <div class="col-sm-6 text-center">date</div>
                    </div>
                    <div class="panel-body row">
                        <div class="col-sm-12 text-center"><button type="button" class="btn btn-primary">Select</button></div>
                    </div>
                </div>
            </div>
		</div>
		<div class="col-sm-2">
			<div class="panel panel-default">
				<div id="panelHeading" class="panel-heading text-center">
					Patrons
				</div>
				<div id="menuInfo" class="panel-body row text-center">
					<div class="col-sm-3">Users</div>
					<div class="col-sm-3">Going?</div>
					<div class="col-sm-3">to Venue</div>
					<div class="col-sm-3">to Home</div>
				</div>
				<div id="patron1" class="panel-body row text-center">
					<div class="col-sm-3"><img src="{{ asset('/img/joel.jpg') }}" class="img-responsive img-circle" alt="dp" width="50" height="50"></div>
					<div class="col-sm-3">radio button</div>
					<div class="col-sm-3 dropdown">
					  <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">there
					  <span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Driving</a></li>
					    <li><a href="#">Any</a></li>
					    <li><a href="#">Adeline</a></li>
					  </ul>
					</div>
					<div class="col-sm-3 dropdown">
					  <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown">back
					  <span class="caret"></span></button>
					  <ul class="dropdown-menu">
					    <li><a href="#">Driving</a></li>
					    <li><a href="#">Any</a></li>
					    <li><a href="#">Adeline</a></li>
					  </ul>
					</div>
				</div>
				<div id="patron2" class="panel-body row">
					<div class="col-sm-3"><img src="{{ asset('/img/adrian.jpg') }}" class="img-responsive img-circle" alt="dp" width="50" height="50"></div>
					<div class="col-sm-3">there</div>
					<div class="col-sm-3">back</div>
					<div class="col-sm-3">radio button</div>
				</div>
				<div id="patron3" class="panel-body row">
					<div class="col-sm-3"><img src="{{ asset('/img/nhi.jpg') }}" class="img-responsive img-circle" alt="dp" width="50" height="50"></div>
					<div class="col-sm-3">there</div>
					<div class="col-sm-3">back</div>
					<div class="col-sm-3">radio button</div>
				</div>
				<div id="patron4" class="panel-body row">
					<div class="col-sm-3"><img src="{{ asset('/img/adeline.jpg') }}" class="img-responsive img-circle" alt="dp" width="50" height="50"></div>
					<div class="col-sm-3">there</div>
					<div class="col-sm-3">back</div>
					<div class="col-sm-3">radio button</div>
				</div>
				
			</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div id="panelHeading" class="panel-heading text-center">
					To Venue
				</div>
				<div class="panel-body">A Basic Panel</div>
				
				</div>
		</div>
		<div class="col-sm-4">
			<div class="panel panel-default">
				<div id="panelHeading" class="panel-heading text-center">
					To Home
				</div>
				<div class="panel-body">A Basic Panel</div>
				
				</div>
		</div>
	</div>
</div>

 <!--
<div class="container">
  <div class="row">
    <div class="col-sm-4">
      <h3>Column 1</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Column 2</h3>
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
    <div class="col-sm-4">
      <h3>Column 3</h3> 
      <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit...</p>
      <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris...</p>
    </div>
  </div>
</div>
-->
</body>
</html>
