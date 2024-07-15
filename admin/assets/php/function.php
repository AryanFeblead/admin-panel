<?php

require ('conn.php');

function add_user()
{
    global $conn;

    if (isset($_POST['emp_name'])) {

        
        $prod_name = $_POST['prod_name'];
        $prod_qun = $_POST['prod_qun'];
        $prod_price = $_POST['prod_price'];
        $prod_detail = $_POST['prod_detail'];

        $sql = "INSERT INTO  product_tbl (prod_name,prod_img,prod_quantity,prod_price,prod_detail) values ('$prod_name','$prod_qun','$prod_price','$prod_detail')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "User added successfully"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
}
function view_user()
{
    global $conn;
    $select = mysqli_query($conn, "SELECT * FROM product_tbl");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

