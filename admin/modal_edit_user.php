<div class="modal fade" id="edit<?php echo $id;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Golfer</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     
     
          <?php

            $userid=$row['golferId'];
              
              $query2=mysqli_query($dbcon,"SELECT * FROM golfer where golferId = '$userid'");
              $row1 = mysqli_fetch_array($query2);
              //$statement=$row1['statement'];
              //$casetype=$row1['case_type'];

              

          ?>

          <div class="row">
          <form class="form-horizontal" action="saveuseredit.php"  method="post" role="form">
          <div class="form-row">
            <div class="col-md-7">
                <div class="form-group">
                  <label for="">Firstname:</label>
                  <input type="text" name="fname" value="<?php echo $row1['FirstName']?>" class="form-control" id="golferId"  >
                </div>
              </div>
            </div>

            <div class="form-row">
            <div class="col-md-7">
              <div class="form-group">
                <label for="">Secondname:</label>
                <input type="text" name="oname" value="<?php echo $row1['SecondName']?>" class="form-control" id="golferId"  >
              </div>
            </div>
          </div>

          

        <div class="form-row" style="">
          <div class="col-md-7">
            <div class="form-group">
              <label for="">Staff Number:</label>
              <input type="text" readonly="" name="username" value="<?php echo $row1['golferId']?>" class="form-control" id="staffid" >
            </div>
          </div>
        </div>
                      
          <div class="form-row" >
            <div class="col-md-7">
              <div class="form-group">

                
                <label for="">Status:</label>
                    <select class="form-control" name="status" id ="sdcrime">

                      <option selected="selected" value="">Select</option>
                      <option value="pending"> Pending </option>
                      <option value="approved"> Approved </option>

                    </select>
                </div>
            </div>
          </div>

        
        </div>
           
			</div>
        
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="icon-remove icon-large"></i>Close</button>
        <button type="submit" class="btn btn-success"> <i class="icon-check icon-large"></i>Update</button>
        </form>
      </div>

    </div>
  </div>
</div>
