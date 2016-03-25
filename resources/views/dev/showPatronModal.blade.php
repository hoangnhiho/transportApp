<html>
  <head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Remote file for Bootstrap Modal</title>  
  </head>
  <body>
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      <h4 class="modal-title">{{$patron->name}}</h4>
    </div><!-- /modal-header -->
    <div class="modal-body">
      <label>Address:</label> 
      <span>{{ucfirst($patron->suburb)}} </span>
    </div><!-- /modal-body -->
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div><!-- /modal-footer -->
  </body>
</html>