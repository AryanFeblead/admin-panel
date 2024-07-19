<?php

require ('conn.php');

session_start();
function add_event(){
    global $conn;
    
    $emp_id = $_SESSION['emp_id'];
    if (isset($_POST['eve_name'])) {

        $eve_name = $_POST['eve_name'];
        $eve_location = $_POST['eve_location'];
        $eve_to_date = $_POST['eve_date'];
        $eve_from_date = $_POST['eve_date1'];
        $eve_time = $_POST['eve_time'];
        $eve_amount = $_POST['eve_amount'];

        $sql = "INSERT INTO  event_tbl (emp_id,eve_name,eve_location,eve_to_date,eve_from_date,eve_time,eve_amount) values ('$emp_id','$eve_name','$eve_location','$eve_to_date','$eve_from_date','$eve_time','$eve_amount')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Event added successfully"]);
        } else {
            echo json_encode(["status" => "error"]);
        }
    }
}
function view_event()
{
    global $conn;
    $select = mysqli_query($conn, "SELECT * FROM event_tbl");
    $users = [];

    if (mysqli_num_rows($select) > 0) {
        while ($row = mysqli_fetch_assoc($select)) {
            $users[] = $row;
        }
    }

    echo json_encode($users);
}

function eve_delete(){
    global $conn;
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM event_tbl WHERE eve_id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success", "message" => "User deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error deleting user: " . $stmt->error]);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid request"]);
    }
}

function fetchData(){
    global $conn;
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "SELECT * FROM emp_tbl WHERE emp_id='$id'";
        $result = mysqli_query($conn, $query);
        $ajax_data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $ajax_data[] = $row['emp_name'];
            $ajax_data[] = $row['emp_email'];
            $ajax_data[] = $row['emp_phone'];
            $ajax_data[] = $row['emp_password'];
            $ajax_data[] = $row['emp_role'];
            $ajax_data[] = $row['emp_event'];
            $ajax_data[] = $row['emp_calendar'];
            $ajax_data[] = $row['emp_dashboard'];
        }
        echo json_encode($ajax_data);
    } else {
        echo json_encode(["error" => "UserID is not set in POST data"]);
    }
}

function updateData() {
    global $conn;

    $emp_name = $_POST['emp_name1'];
    $emp_email = $_POST['emp_email1'];
    $emp_phone = $_POST['emp_phone1'];
    $emp_password = $_POST['emp_password1'];
    $emp_role = $_POST['emp_role1'];
    $emp_event = $_POST['emp_event1'];
    $emp_calendar = $_POST['emp_calendar1'];
    $emp_dashboard = $_POST['emp_dashboard1'];

    $sql = "UPDATE emp_tbl SET emp_name=?, emp_email=?, emp_phone=?, emp_password=?, emp_role=?, emp_event=?, emp_calendar=?, emp_dashboard=? WHERE emp_id=?";
    
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssssi", $emp_name, $emp_email, $emp_phone, $emp_password, $emp_role, $emp_event, $emp_calendar, $emp_dashboard, $id);

    $id = $_POST['id']; // Assuming you're passing 'id' in your AJAX request
    $id = intval($id); // Convert id to integer if needed

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "User updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "User update failed"]);
    }

    mysqli_stmt_close($stmt);
}


