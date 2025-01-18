<?php
//require_once('session_login.php');
include('../../dbconnect.php');
include('header.php');

?>
<br />
<div class="container-fluid">
    <?php include('menubar.php'); ?>
    <div class="col-md-1"></div>
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Receive my payment
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
                        <thead>
                            <tr>
                            <th>S/N</th>
                                <th>Golf kit</th>
                                <th>Quantity requested</th>
                                <th>Amount (each)</th>
                                <th>Total amounr</th>
                                <th>Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Database connection assumed to be $dbcon
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT requested_kit.*, golf_tools.*, saveSupply.* 
                            FROM requested_kit
                            JOIN golf_tools ON requested_kit.kitId = golf_tools.kitId
                            JOIN saveSupply ON saveSupply.requestId = requested_kit.requestId
                            WHERE requested_kit.isUpdated = 1
                            AND saveSupply.payment = 1
                            AND saveSupply.supPayment = 0");

                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['supplyId'];
                                $sn++;
                            ?>
                                <tr>
                                <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['tool_name']; ?></td>
									<td><?php echo $row['quantity']; ?></td>
                                    <td>Kshs <?php echo $row['quantity_each']; ?></td>
                                    <td>Kshs <?php echo number_format($row['amount'], 2) ?></td>
									<td><?php echo $row['date']; ?></td>
                                    <td>
                                        <button type="button" data-placement="left" title="Click to view" id="view<?php echo $id; ?>" data-id="<?php echo $id; ?>" class="btn btn-success receive-payment">Receive payment <i class="icon-pencil icon-large"></i></button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        <div class="col-md-1"></div>
    </div>


    <?php include('scripts.php'); ?>




    <script type="text/javascript">
        $(document).ready(function() {
            $('#myTable-trans').DataTable();
        });
    </script>

    <!-- Include jQuery library -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.receive-payment').on('click', function(e) {
                e.preventDefault();

                var id = $(this).data('id');

                $.ajax({
                    url: 'editPayment.php',
                    type: 'POST',
                    data: {
                        supplyId: id
                    },
                    success: function(response) {
                        
                        window.location.reload();
                        console.log('Payment received successfully.');
                        // Optionally, update the UI
                    },
                    error: function(xhr, status, error) {
                        console.error('Error receiving payment:', error);
                    }
                });
            });
        });
    </script>


    </body>

    </html>