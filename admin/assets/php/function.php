<?php

require ('conn.php');

function add_user()
{
    global $conn;

    if (isset($_POST['emp_name'])) {

        $emp_name = $_POST['emp_name'];
        $emp_email = $_POST['emp_email'];
        $emp_phone = $_POST['emp_phone'];
        $emp_password = $_POST['emp_password'];
        $emp_role = $_POST['emp_role'];
        $emp_event = $_POST['emp_event'];
        $emp_calendar = $_POST['emp_calendar'];
        $emp_dashboard = $_POST['emp_dashboard'];

        $sql = "INSERT INTO  emp_tbl (emp_name,emp_email,emp_phone,emp_password,emp_role,emp_event,emp_calendar,emp_dashboard) values ('$emp_name','$emp_email','$emp_phone','$emp_password','$emp_role','$emp_event','$emp_calendar','$emp_dashboard')";
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
    $select = mysqli_query($conn, "SELECT * FROM emp_tbl");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

