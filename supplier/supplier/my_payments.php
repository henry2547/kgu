<?php
//require_once('session_login.php');
include('dbconnect.php');
include('header.php');
include('session.php');

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
                        Available Raw materails
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Golf kit</th>
                                <th>Quantity requested</th>
                                <th>Amount(each)</th>
                                <th>Total</th>
                                <th>Date</th>
                                <th>Action</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The serial number variable
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT requested_kit.*, golf_tools.*, saveSupply.* 
                            FROM requested_kit
                            JOIN golf_tools ON requested_kit.kitId = golf_tools.kitId
                            JOIN saveSupply ON saveSupply.requestId = requested_kit.requestId
                            WHERE requested_kit.isUpdated = 1
                            AND saveSupply.payment = 1
                            AND saveSupply.supPayment = 1");

                            while ($row = mysqli_fetch_array($query)) {

                                $id = $row['supplyId'];

                                $quantity = $row['quantity'];
                                $quantity_each = $row['quantity_each'];

                                $amount = $row['amount'];


                                $sn++;
                            ?>
                                <tr>

                                    <td><?php echo $sn; ?></td>
                                    <td><?php echo $row['tool_name']; ?></td>
                                    <td><?php echo $quantity ?></td>
                                    <td>Kshs <?php echo $quantity_each ?></td>
                                    <td>Kshs <?php echo number_format($amount, 2) ?></td>
                                    <td><?php echo $row['date']; ?></td>

                                    <td>
                                        <?php
                                        echo "<button class='btn btn-success' onclick='downloadReceipt(\"$id\")'>Print receipt</button>";
                                        ?>
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

    <script>
        var sessionVars = {
            session_id: '<?php echo $session_id ?>'
        }

        function downloadReceipt(id) {
            var url = 'receipt.php?id=' + id +
                '&session_id=' + encodeURIComponent(sessionVars.session_id);

            // Open the default browser with the URL
            window.open(url, '_system');
        }
    </script>
    </body>

    </html>