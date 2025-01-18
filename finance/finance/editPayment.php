<?php

include('header.php');
include('../../dbconnect.php');

?>


<div class="container-fluid">


    <?php include('menubar.php') ?>
    <?php

    $supplyId = $_GET['id'];


    ?>

    <div class="container-fluid">

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <ul class="list-group" id="myinfo">

                <li class="list-group-item" id="mylist"></li>

            </ul>
            <div class="panel panel-success">
                <div class="panel-heading">

                    <h3 class="panel-title">Request and payment details</h3>
                </div>

                <div class="panel-body">

                    <div class="container-fluid">
                        <form class="form-horizontal" method="post" id="paySupplier" role="form">


                            <div class="form-row">
                                <?php
                                $query = mysqli_query($dbcon, "SELECT requested_kit.*, golf_tools.*, saveSupply.* 
                                FROM requested_kit
                                JOIN golf_tools ON requested_kit.kitId = golf_tools.kitId
                                JOIN saveSupply ON saveSupply.requestId = requested_kit.requestId
                                WHERE requested_kit.isUpdated = 1
                                AND saveSupply.payment = 0
                                AND saveSupply.supplyId = '$supplyId'");

                                while ($row = mysqli_fetch_array($query)) {
                                ?>
                                    <table class="table">
                                        <tr>
                                            <td>ID:</td>
                                            <td> <input type="text" value="<?php echo $supplyId ?>" class="form-control" readonly="" name="supplyId"> </td>
                                        </tr>
                                        <tr>
                                            <td>Product name:</td>
                                            <td><?php echo $row['tool_name'] ?></td>
                                        </tr>

                                        
                                        <tr>
                                            <td>Quantity:</td>
                                            <td><?php echo $row['quantity'] ?></td>
                                        </tr>

                                        <tr>
                                            <td>Amount (each):</td>
                                            <td>Kshs <?php echo number_format($row['quantity_each'], 2) ?></td>
                                        </tr>

                                        <tr>
                                            <td>Total amount:</td>
                                            <td>Kshs <?php echo number_format($row['amount'], 2) ?></td>
                                        </tr>



                                    <?php
                                }

                                    ?>

                                    </table>

                            </div>



                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">Mode of payment:</label>
                                    <select class="form-control" name="mode_payment" required="">
                                        <option disabled selected></option>
                                        <option value="Mpesa">Mpesa</option>
                                        <option value="Bank">Bank</option>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="code">Transaction code:</label>
                                    <input type="text" name="code" class="form-control" minlength="10" maxlength="10" id="">

                                </div>

                                <div class="form-group">
                                    <label for="">Statement:</label>
                                    <textarea name="comments" class="form-control" id=""></textarea>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('paySupplier');

        form.addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Collect form data
            const formData = new FormData(form);

            // Perform AJAX submission
            fetch('pay_supplier.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // If payment successful, show success message
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: 'Paid!',
                            text: data.message, // Display message from PHP script
                            confirmButtonText: 'Continue'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Optionally redirect to another page after success
                                window.location.href = 'supplier_payment.php';
                            }
                        });
                    } else {
                        // If payment failed, show error message
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: 'Failed to pay',
                            text: data.error, // Display error message from PHP script
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle fetch request errors
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Error',
                        text: 'An unexpected error occurred. Please try again later.',
                        confirmButtonText: 'OK'
                    });
                });
        });
    });
</script>


</body>

</html>