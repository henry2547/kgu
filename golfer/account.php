<?php
include("sessions.php");
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

                <h3 class="panel-title">My account info</h3>
            </div>

            <div class="form-row">
                <?php
                $query = mysqli_query($dbcon, "SELECT golfer.*, clubs.* 
                FROM golfer
                JOIN clubs ON golfer.clubId = clubs.clubId
                WHERE golfer.golferId = '$golferId'");

                while ($row = mysqli_fetch_array($query)) {
                ?>
                    <table class="table">
                        <tr>
                            <td width="160px">Golfer Number:</td>
                            <td> <?php echo $golferId ?> </td>
                        </tr>
                        <tr>
                            <td>Firstname:</td>
                            <td><?php echo $row['FirstName'] ?></td>
                        </tr>
                        <tr>
                            <td>Secondname:</td>
                            <td><?php echo $row['SecondName'] ?></td>
                        </tr>
                        <tr>
                            <td>Email address:</td>
                            <td><?php echo $row['Email'] ?></td>
                        </tr>

                        <tr>
                            <td>Phone number:</td>
                            <td><?php echo $row['Phone'] ?></td>
                        </tr>

                        <tr>
                            <td>Registration Date </td>
                            <td><?php echo $row['RegistrationDate'] ?></td>
                        </tr>

                        <tr>
                            <td>Club member </td>
                            <td><?php echo $row['ClubName'] ?></td>
                        </tr>


                    <?php
                }

                    ?>

                    </table>

            </div>

        </div>
    </div>


</div>
</div>
<div class="col-md-2"></div>
</div>