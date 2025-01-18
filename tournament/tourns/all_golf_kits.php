<?php
//require_once('session_login.php');
include('dbconnect.php');
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
                        Golf Kits
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>S/N</th>

                                <th>
                                    <center>Golf kit</center>
                                </th>
                                <th>
                                    <center>Quantity</center>
                                </th>
                                <th>
                                    <center>Date</center>
                                </th>


                                <th>
                                    <center>Action</center>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The serial number variable
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT * FROM golf_tools");

                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['kitId'];
                                $sn++;
                            ?>
                                <tr>

                                    <td><?php echo $sn; ?></td>


                                    <td><?php echo $row['tool_name']; ?></td>
                                    <td><?php echo $row['kit_quantity']; ?></td>
                                    <td><?php echo $row['date']; ?></td>


                                    <td class="empty" width="">
                                        <a data-placement="left" title="Click to request" id="edit<?php echo $id; ?>" href="requestKit.php<?php echo '?edit=' . $id; ?>" class="btn btn-success">request</a>

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
    </body>

    </html>