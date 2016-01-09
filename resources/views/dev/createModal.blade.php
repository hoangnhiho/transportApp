<!-- Modal -->
<div class="modal fade" id="createPatronModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Patron</h4>
      </div>
      <div class="modal-body">

        <form class="form-horizontal" role="form" method="POST" action="{{ url('/createPatron/'.$eventID) }}">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">

          <div class="form-group">
            <label class="col-md-4 control-label">Full Name</label>
            <div class="col-md-6">
              <input type="name" class="form-control" name="name">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label">URL of Fb Pic</label>
            <div class="col-md-6">
              <input type="text" class="form-control" name="picurl" placeholder="https://fbcdn-profile-a.akamaihd.net/hprofile.....">
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-4 control-label">Address</label>
            <div class="col-md-6">
              <input type="text" class="form-control" name="address">
            </div>
          </div>


          <div class="form-group">
            <label class="col-md-4 control-label">Suburb/city</label>
            <div class="col-md-6">
                      <select class="form-control" name="suburb">
                          <option>St Lucia</option>
                          <option>Toowong</option>
                          <option>Taringa</option>
                          <option>Auchenflower</option>
                          <option>Indooroopilly</option>
                          <option>Chapelhill</option>
                          <option>Kelvingrove</option>
                          <option>Woolongabba</option>
                          <option>Duttonpark</option>
                          <option>Fairfield</option>
                          <option>oxley</option>
                          <option>Sherwood</option>
                          <option>Corinda</option>
                          <option>Sunnybank</option>
                          <option>Willawong</option>
                          <option>Logan</option>
                          <option>Other</option>
                      </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-md-4 control-label">PostCode</label>
            <div class="col-md-6">
              <input type="text" class="form-control" name="postcode">
            </div>
          </div>

          <div class="form-group">
            <div class="col-md-6 col-md-offset-4">
              <button type="submit" class="btn btn-primary">Create Patron</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="patronModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div> <!-- /.modal-content -->
    </div> <!-- /.modal-dialog -->
</div> <!-- /.modal -->