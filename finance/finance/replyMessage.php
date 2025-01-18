<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


    <?php include('menubar.php') ?>
    <?php
    $feedbackId = $_GET['edit'];
    $statement = '';

    ?>

    <div class="container-fluid">

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <ul class="list-group" id="myinfo">

                <li class="list-group-item" id="mylist"></li>

            </ul>
            <div class="panel panel-success">
                <div class="panel-heading">

                    <h3 class="panel-title">User Details and Message</h3>
                </div>
                <div class="panel-body">

                    <div class="container-fluid">
                        <form class="form-horizontal" action="send_reply.php" id="replyMesage" method="post" role="form">


                            <div class="form-row">
                                <?php
                                $query = mysqli_query($dbcon, "SELECT feedback.*, golfer.*
								FROM feedback
								JOIN golfer ON feedback.golferId = golfer.golferId
								WHERE feedback.feedbackId = '$feedbackId'
                                AND feedback.message_to = 'finance_manager'");

                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <table class="table">
                                        <tr>
                                            <td width="160px">Payment ID:</td>
                                            <td> <input type="text" value="<?php echo $feedbackId ?>" readonly="" name="feedbackId"> </td>
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
                                            <td>Message:</td>
                                            <td> <textarea name="message" id="" class="form-control" readonly> <?php echo $row['Message'] ?></textarea> </td>
                                        </tr>


                                    <?php
                                }



                                $query = mysqli_query($dbcon, "SELECT feedback.*, golfer.*
								FROM feedback
								JOIN golfer ON feedback.golferId = golfer.golferId
                                WHERE feedback.feedbackId = '$feedbackId'
                                AND feedback.message_to = 'finance_manager'");

                                while ($row = mysqli_fetch_array($query)) {
                                }
                                    ?>

                                    </table>

                            </div>

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="reply">Reply message</label>
                                        <textarea class="ckeditor" name="reply" id="ckeditor" rows="60" cols="100">

										</textarea>
                                        <script>
                                            // Replace the <textarea id="editor1"> with a CKEditor 4
                                            // instance, using default configuration.
                                            CKEDITOR.replace('editor1');
                                        </script>
                                    </div>
                                </div>







                            </div>

                            <div class="form-group">
                                <button type="submit" name="savecidstatement" class="btn btn-success form-control">Save
                                    <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-2"></div>
    </div>

    <?php include('scripts.php'); ?>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>

    <script type="text/javascript">
        $(document).on('submit', '#replyMesage', function(event) {
            event.preventDefault();

            // Remove existing error messages
            $(".list-group-item").remove();

            var formData = $(this).serialize();

            $.ajax({
                url: 'send_reply.php',
                type: 'post',
                data: formData,
                dataType: 'json',

                success: function(response) {
                    if (response.error) {
                        // Display validation errors
                        var errors = response[0];
                        var len = errors.length;
                        for (var i = 0; i < len; i++) {
                            $('#myinfo').append('<li class="list-group-item alert alert-danger">' + errors[i] + '</li>');
                        }
                    } else {
                        // Payment saved successfully
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Reply Saved!',
                            showConfirmButton: false,
                            timer: 3000
                        });

                        // Clear form input after success
                        $('input[name=statement]').val('');

                        // Redirect to index.php after a delay
                        setTimeout(function() {
                            window.location.href = 'index.php';
                        }, 3000);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle AJAX errors if any
                    console.error('AJAX Error:', status, error);
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong! Please try again later.',
                    });
                }
            });
        });
    </script>


    </body>

    </html>