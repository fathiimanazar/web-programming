<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'college');


$create_table_qry = 'CREATE TABLE IF NOT EXISTS `railway` (
    `ticket_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `full_name` varchar(20) NOT NULL,
    `address` varchar(50) NOT NULL,
    `train_no` varchar(10) NOT NULL,
    `train_name` varchar(15) NOT NULL,
    `date_of_journey` date NOT NULL,
    `boarding_time` time NOT NULL
  )';

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['book_ticket'])) {
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $train_no = $_POST['train_no'];
    $train_name = $_POST['train_name'];
    $date_of_journey = $_POST['date_of_journey'];
    $boarding_time = $_POST['boarding_time'];

    $err_msg .= (empty($full_name)) ? '<p>Please enter  full name</p>' : '';
    $err_msg .= (empty($address)) ? '<p>Please enter  address</p>' : '';
    $err_msg .= (empty($train_no)) ? '<p>Please enter  train name</p>' : '';
    $err_msg .= (empty($train_name)) ? '<p>Please enter train name</p>' : '';
    $err_msg .= (empty($date_of_journey)) ? '<p>Please enter date of journey</p>' : '';
    $err_msg .= (empty($boarding_time)) ? '<p>Please enter  boarding time</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_ticket = "INSERT INTO railway (full_name, address,train_no, train_name,date_of_journey,boarding_time) VALUES ('$full_name','$address','$train_no','$train_name','$date_of_journey','$boarding_time')";
        $insert_result = mysqli_query($db, $insert_ticket);

        if ($insert_result)
            $succ_msg = "<p>Successfully booked ticket</p>";
        else
            $err_msg = "<p>Could not book ticket</p>";
    }
}



$tickets_qry = 'SELECT * from railway';
$tickets_records = mysqli_query($db, $tickets_qry);



?>

<title>Railway ticket booking</title>

<body>

<center><h3 class="header">Railway Ticket Booking</h3></center>

    <div class="container">

        <div>
            <table>
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Name</th>
                        <th>Train No</th>
                        <th>Boarding time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($tickets = mysqli_fetch_array($tickets_records)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $tickets['full_name'] ?></td>
                            <td><?= $tickets['train_name'] ?></td>
                            <td><?= $tickets['boarding_time'] ?></td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>


        <div>



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



            <form method="post">
                <label for="fname">Full Name</label>
                <input type="text" id="full_name" name="full_name" placeholder="Your name.." required>

                <label for="lname">Address</label>
                <textarea name="address" id="address" cols="10" rows="5" required>
                </textarea>


                <label for="lname">Train No</label>
                <input type="text" id="train_no" name="train_no" placeholder="Train no.." oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">


                <label for="lname">Train Name</label>
                <input type="text" id="train_name" name="train_name" placeholder="Train name.." required>


                <label for="lname">Date of journey</label>
                <input type="date" id="date_of_journey" name="date_of_journey" placeholder="Date of journey.." required>


                <label for="lname">Time of boarding</label>
                <input type="time" id="boarding_time" name="boarding_time" placeholder="Time of boarding.." required>



                <input type="submit" name="book_ticket" value="Book ticket">
                <!-- <input type="submit" name="show_tickets" value="Show tickets"> -->
            </form>
        </div>



    </div>
</body>



<style>

table {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

table td, table th {
  border: 1px solid #ddd;
  padding: 8px;
}


table tr:hover {background-color: #ddd;}

table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #778e8c;
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

    input[name=show_tickets] {
        background-color: #46a7f5 !important;
    }

    input[type=submit] {
        width: 30%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #5c6c5d;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        font-size: 20px;
        color: #4b5a4b;
    }

    .col-3 {
        width: 50%;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: #fff;
        margin-bottom: 2%;
    }

    .alert-error {
        background-color: #f44336;
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
    .header{
        width: 100%;
       height: 20px;
       padding-top: 15px;
       font-size: 28px;
       color: #483232;
    }
</style>