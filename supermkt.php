<?php

$db = mysqli_connect('localhost', 'root', '', 'college');


$create_table_qry = 'CREATE TABLE IF NOT EXISTS `supermarket` (
    `item_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `item_name` varchar(50) NOT NULL,
    `item_quantity` int(11) NOT NULL,
    `unit_price` int(11) NOT NULL,
    `total` int(11) NOT NULL
  )';

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_supermarket'])) {
    $item_name = $_POST['item_name'];
    $item_quantity = $_POST['item_quantity'];
    $unit_price = $_POST['unit_price'];

    $err_msg .= (empty($item_name)) ? '<p>Please enter  product name</p>' : '';
    $err_msg .= (empty($item_quantity)) ? '<p>Please enter  item quantity</p>' : '';
    $err_msg .= (empty($unit_price)) ? '<p>Please enter  unit price</p>' : '';

    $err_msg .= (!is_numeric($unit_price)) ? '<p>Please enter an integer value for unit price</p>' : '';
    $err_msg .= (!is_numeric($item_quantity)) ? '<p>Please enter an integer value for item quantity</p>' : '';


    if (strlen($err_msg) == 0) {
        $total = $unit_price * $item_quantity;
        $insert_supermarket = "INSERT INTO supermarket (item_name, item_quantity,unit_price, total) VALUES ('$item_name',$item_quantity,$unit_price,$total)";
        $insert_result = mysqli_query($db, $insert_supermarket);

        if ($insert_result)
            $succ_msg = "<p>Successfully added supermarket</p>";
        else
            $err_msg = "<p>Could not add supermarket</p>";
    }
}


$supermarkets_qry = "SELECT * from supermarket";
$supermarkets_records = mysqli_query($db, $supermarkets_qry);



?>

<title>supermarket</title>

<body>

    <center>
        <h3 class="header">Supermarket Management</h3>
    </center>

    <div class="container">

        <div>

            <button id="view_supermarket" name="view_supermarket" onclick="show_list()">View supermarket List</button>


            <table id="table_list" style="display: none;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Item name</th>
                        <th>item quantity</th>
                        <th>Unit price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($supermarkets = mysqli_fetch_array($supermarkets_records)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $supermarkets['item_name'] ?></td>
                            <td><?= $supermarkets['item_quantity'] ?></td>
                            <td><?= $supermarkets['unit_price'] ?></td>
                            <td><?= $supermarkets['total'] ?></td>

                        </tr>
                    <?php }  ?>
                </tbody>
            </table>

        </div>


        <div>

            <div class="alert alert-error" id="error_message" style="display: none;">
            </div>

            <?php if (strlen($err_msg > 0)) : ?>


                <div class="alert alert-error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $err_msg ?>
                </div>




            <?php endif; ?>

            <?php if (strlen($succ_msg > 0)) : ?>


                <div class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $succ_msg ?>
                </div>



            <?php endif; ?>



            <form method="post" onsubmit="return check_validation()">
                <label for="fname">Item name</label>
                <input type="text" id="item_name" name="item_name" >



                <label for="lname">Item quantity</label>
                <input type="text" id="item_quantity" name="item_quantity">


                <label for="lname">Unit price</label>
                <input type="text" id="unit_price" name="unit_price">





                <input type="submit" name="add_supermarket" value="Add supermarket">
            </form>
        </div>



    </div>
</body>

<script>
    function show_list() {
        var x = document.getElementById("table_list");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }

    function check_validation() {
        var item_name = document.getElementById("item_name").value;
        var item_quantity = document.getElementById("item_quantity").value;
        var unit_price = document.getElementById("unit_price").value;


        var error_message = document.getElementById("error_message");

        var err_msg = "";
        if (item_name == "")
            err_msg += "<p>Item name cannot be empty!</p>";

        if (item_quantity == "" || isNaN(item_quantity))
            err_msg += "<p>Item quantity cannot be empty and must be an integer!</p>";

        if (unit_price == "" || isNaN(unit_price))
            err_msg += "<p>Unit price cannot be empty and must be an integer!</p>";

       
        if (err_msg.length == 0)
            return true;



        error_message.style.display = 'block';
        error_message.innerHTML = err_msg;
        return false;
    }
</script>


<style>
    form{
        display: inline-block;
        padding-left: 200px;
    }
    
    table {
        border-collapse: collapse;
        width: 100%;
        margin-left: 200px;
        padding-top: 25px;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }


    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #59ca86;
        color: white;
    }



    input[type=text],
    input[type=date],
    input[type=time],
    textarea,
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[name=view_supermarket] {
        width: 20%;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        background-color:  #72ce90  !important;
        font-size: 15px;
        margin-left: 200px;
    }

    input[type=submit] {
        width: 28%;
        background-color:#72ce90 ;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 15px;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #d0edda;;
        padding: 20px;
        color: #4b4f56;
        font-size: 18px;
    }

    .header{
       width: 100%;
       height: 20px;
       padding-top: 15px;
       font-size: 28px;
       color: green;
    }

    .col-3 {
        width: 50%;
    }

    .alert {
        padding: 20px;
        background-color: #f;
        color: #fff;
        margin-bottom: 2%;
    }

    .alert-error {
        background-color: #305032;
    }

    .alert-success {
        background-color: #2eb885;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>