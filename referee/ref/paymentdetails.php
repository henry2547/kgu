<?php 
 $paymentId = $_GET['id']; 
 require_once('dbconnect.php');
 include('header.php');

?>






<div class="container-fluid">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		
	
</div>

<div class="container-fluid">
	<?php include('menubar.php') ?>
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<a href="#" onClick="window_print()" class="btn btn-info" style="margin-bottom:20px"><i class="icon-print icon-large"></i> Print</a>

	
		
		</script>
		<div class="panel panel-success" id="outprint">
			<div class="panel panel-success">
			 	<div class="panel-heading">
			 		<h3 class="panel-title">Payment Details</h3>
			 	</div>
			<div class="panel-body">
			 <br />
			
			 <div class="panel panel-success">
			 	<div class="panel-heading">
			 		
			 		<h3 class="panel-title"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Golfer Details</h3>
			 	</div>
			 	<div class="panel-body">
			 		<?php
			 		$query=mysqli_query($dbcon,"SELECT payment.*, golfer.*
                     FROM payment
                     JOIN golfer ON payment.golferId = golfer.golferId
                     WHERE payment.paymentId = '$paymentId'");

		while($row = mysqli_fetch_array($query)){
			?>
			 			 <table class="table">
                            <tr>
                                    <td width="160px">Payment ID:</td><td> <input type="text" value="<?php echo $paymentId?>" readonly="" name="paymentId"> </td>
                                </tr>
                                <tr>
                                    <td>Firstname:</td><td><?php echo $row['FirstName']?></td>
                                </tr>
                                <tr>
                                    <td>Secondname:</td><td><?php echo $row['SecondName']?></td>
                                </tr>
                                <tr>
                                    <td>Email address:</td><td><?php echo $row['Email']?></td>
                                </tr>
                                
                                <tr>
                                    <td>Phone number:</td><td><?php echo $row['Phone']?></td>
                                </tr>
                                
                                <tr>
                                    <td>Registration Date </td><td><?php echo $row['RegistrationDate']?></td>
                                </tr>
			 			 	
			 			 	
			 			 	
			 			 <?php
			 			 }
			 			 ?>
			 			 	
			 			 </table>
			 			
			 	</div>
			 </div>

			 <div class="panel panel-success">
			 	<div class="panel-heading">
			 		<h3 class="panel-title">
			 			
			 		Payment Details</h3>
			 	</div>
			 	<div class="panel-body">
			 		<table id="myTable-party" class="table table-bordered table-hover" cellspacing="0" width="100%">
							<thead>
							    <tr>
							    	<th>
							        	<center>
							       			Payment code
							        	</center> 
							        </th>
							        
							        <th>
							        	<center>
							        		Tees booked
							        	</center>
						        	</th>
							        <th>
							        	<center>
							        		Statement
							        	</center>
						        	</th>
						        	 <th>
							        	<center>
							        		Status
							        	</center>
						        	</th>
							    </tr>
							</thead>
						    <tbody>
						    	<?php
						    	$sn=0;
			 		$query=mysqli_query($dbcon,"SELECT payment.*, golfer.*,
                     GROUP_CONCAT(teetime.TeeName) AS tees
                     FROM payment
                     JOIN golfer ON payment.golferId = golfer.golferId
                     JOIN booktee ON booktee.golferId= golfer.golferId
                     JOIN teetime ON booktee.teeId = teetime.teeId
                     WHERE payment.paymentId = '$paymentId'
                     GROUP BY payment.PaymentCode");

		while($row = mysqli_fetch_array($query)){
			$sn++;
			?>
						    	<tr>
                                    <td><?php echo $row['PaymentCode']?></td>
						    		<td><?php echo $row['tees']?></td>
						    		<td><?php echo $row['Statement']?></td>
                                    
						    		<td><?php echo $row['paymentStatus']?></td>
						    		
						    		
						    	</tr>
<?php }
?>
</tbody>
						</table>

</div>
			 </div>
				
			 	
			 	</div>
			 </div>
			</div>	
						    
						   <center>
							   <a href="index.php" class="btn btn-success">Return Home
								   <span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
							   </a>
						   </center>
				
			
		</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php include('scripts.php') ?>

<script type="text/javascript">

    function window_print(){
		var _head = $('head').clone();
		var _p = $('#outprint').clone();
		var _html = $('<div>')
		_html.append("<head>"+_head.html()+"</head>")
		_html.append("<h3 class='text-center'>KENYA GOLF UNION</h3>")
		_html.append(_p)
		console.log(_html.html())
		var nw = window.open("","_blank","width:900;height:800")
			nw.document.write(_html.html())
			nw.document.close()
			nw.print()
			setTimeout(() => {
				nw.close()
			}, 500);
	}
	</script>
</body>
</html>

