<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db = mysqli_connect('localhost', 'root', '', 'college');


$create_table_qry = 'CREATE TABLE IF NOT EXISTS `books` (
    `book_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `accession_no` varchar(20) NOT NULL,
    `book_title` varchar(50) NOT NULL,
    `book_author` varchar(20) NOT NULL,
    `edition` varchar(20) NOT NULL,
    `publisher` varchar(20) NOT NULL
  )';

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_book'])) {
    $accession_no = $_POST['accession_no'];
    $book_title = $_POST['book_title'];
    $book_author = $_POST['book_author'];
    $edition = $_POST['edition'];
    $publisher = $_POST['publisher'];

    $err_msg .= (empty($accession_no)) ? '<p>Please enter  accession no</p>' : '';
    $err_msg .= (empty($book_title)) ? '<p>Please enter  book title</p>' : '';
    $err_msg .= (empty($book_author)) ? '<p>Please enter  author</p>' : '';
    $err_msg .= (empty($edition)) ? '<p>Please enter edition</p>' : '';
    $err_msg .= (empty($publisher)) ? '<p>Please enter publisher</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_book = "INSERT INTO books (accession_no, book_title,book_author, edition,publisher) VALUES ('$accession_no','$book_title','$book_author','$edition','$publisher')";
        $insert_result = mysqli_query($db, $insert_book);

        if ($insert_result)
            $succ_msg = "<p>Successfully added book</p>";
        else
            $err_msg = "<p>Could not add book</p>";
    }
}


if (isset($_POST['search_book'])) {
    $book_title = '%'. $_POST['book_title'] . '%';
    $books_qry = "SELECT * from books where book_title LIKE '$book_title'";
    $books_records = mysqli_query($db, $books_qry);
}


?>

<title>Book store</title>

<body>

    <center>
        <h3 class="header">Book Details</h3>
    </center>

    <div class="container">

        <div>

            <form method="post">
                <input type="text" name="book_title" id="book_title" placeholder="Enter bookname to search ...">
                <input type="submit" name="search_book" value="Search">
            </form>

            <?php if (isset($_POST['search_book'])) {
            ?>
                <table>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Accession no</th>
                            <th>Book title</th>
                            <th>Author</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1;
                         while ($books = mysqli_fetch_array($books_records)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $books['accession_no'] ?></td>
                            <td><?= $books['book_title'] ?></td>
                            <td><?= $books['book_author'] ?></td>

                        </tr>
                    <?php }  ?>
                    </tbody>
                </table>
            <?php } ?>
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
                <label for="fname">Accession no</label>
                <input type="text" id="accession_no" name="accession_no" required>



                <label for="lname">Book title</label>
                <input type="text" id="book_title" name="book_title" required>


                <label for="lname">Book author</label>
                <input type="text" id="book_author" name="book_author" required>


                <label for="lname">Edition</label>
                <input type="text" id="edition" name="edition" required>


                <label for="lname">Publisher name</label>
                <input type="text" id="publisher" name="publisher" required>




                <input type="submit" name="add_book" value="Add book">
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

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }


    table tr:hover {
        background-color: #ddd;
    }

    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #007bf;
        color: #521111;
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
        font-size: 15px;
    }

    input[name=search_book] {
        background-color:#a2bab6 !important;
        font-size: 15px;
    }

    input[type=submit] {
        width: 30%;
        background-color: #799e85;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 15px;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
        color: #4b4f56;
        font-size: 18px;
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
    }
</style>