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

            $clubId = $row['clubId'];
              
              $query2=mysqli_query($dbcon,"SELECT * FROM clubs where clubId = '$clubId'");
              $row1 = mysqli_fetch_array($query2);
              //$statement=$row1['statement'];
              //$casetype=$row1['case_type'];

              

          ?>

          <div class="row">
          <form class="form-horizontal" action="saveclubedit.php"  method="post" role="form">
          <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="">Club name:</label>
                        <input type="text" name="cname" value="<?php echo $row1['ClubName']?>" class="form-control" id="golferId"  >
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Region:</label>
                            <script type="text/javascript" src="js/regions.js"></script>
                        <select class="form-control" required="" onchange="print_state('state',this.selectedIndex);" id="country" name ="region">
                    
                        </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">District/Municipal:</label>
                            <select required="" class="form-control" name ="district" id ="state"></select>
                        <script language="javascript">print_country("country");</script>
                        </div>
                    </div>
                </div>
            </div>

          

        <div class="form-row" style="">
          <div class="col-md-7">
            <div class="form-group">
              <label for="">Club Number:</label>
              <input type="text" readonly="" name="username" value="<?php echo $row1['clubId']?>" class="form-control" id="staffid" >
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
