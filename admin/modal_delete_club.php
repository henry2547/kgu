<div class="modal fade" id="<?php echo $golferId;?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-golferIdden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Delete Golfer from the club</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <form action="deletemember.php" method="post">
      <div class="alert alert-danger">
					<p>Are you sure you want to remove this User from the club?.</p>
					</div>
        
         
      <input  type="hidden" hidden="true" name="deleted" value="<?php echo $golferId;?>"/>
      
      <h3> Golfer ID: <?php echo $golferId;?></h3>
     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="icon-remove icon-large"></i>Close</button>
        <button type="submit" name="delete" class="btn btn-danger"> <i class="icon-check icon-large"></i>Remove</button>
        </form>
      </div>
    </div>
  </div>
</div>
