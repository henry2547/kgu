<?php
include("header.php");
include("menubar.php");
include("dbconnect.php");
?>

<div class="container-fluid">

    



            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="list-group" id="myinfo">

                    <li class="list-group-item" id="mylist"></li>

                </ul>
                <div class="panel panel-success">
                    <div class="panel-heading">

                        <h3 class="panel-title">Replies</h3>
                    </div>

                    <div id="trans-table">
                        <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>

                                    <th>From</th>
                                    <th>To</th>
                                    <th>
                                       Golfer message
                                    </th>
                                    <th>
                                       Reply
                                    </th>
                                    

                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // The serial number variable
                                require("dbconnect.php");
                                $sn = 0;
                                $query = mysqli_query($dbcon, "SELECT replies.*, feedback.*, golfer.*
                                FROM replies
                                JOIN feedback ON replies.feedbackId = feedback.feedbackId
                                JOIN golfer ON feedback.golferId = golfer.golferId
                                ");

                                while ($row = mysqli_fetch_array($query)) {
                                    
                                    $sn++;
                                ?>
                                    <tr>

                                        <td><?php echo $sn; ?></td>
                                        <td>
                                            <?php
                                            if($row['message_to'] == 'finance_manager'){
                                                echo "Finance manager";
                                            }
                                            elseif($row['message_to'] == 'tee_manager'){
                                                echo "Tee manager";
                                            }elseif($row['message_to'] == 'tournament_manager'){
                                                echo "Tournament manager";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
                                        <td><?php echo $row['Message']; ?></td>
                                        <td><?php echo $row['message_reply']; ?></td>

                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>
    <div class="col-md-2"></div>
    </div>