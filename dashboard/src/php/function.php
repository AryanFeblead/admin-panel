<?php

require ('conn.php');

session_start();
function add_event()
{
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

function eve_delete()
{
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

function eve_fetch()
{
    global $conn;
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $query = "SELECT * FROM event_tbl WHERE eve_id='$id'";
        $result = mysqli_query($conn, $query);
        $ajax_data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $ajax_data[] = $row['eve_name'];
            $ajax_data[] = $row['eve_location'];
            $ajax_data[] = $row['eve_to_date'];
            $ajax_data[] = $row['eve_from_date'];
            $ajax_data[] = $row['eve_time'];
            $ajax_data[] = $row['eve_amount'];
        }
        echo json_encode($ajax_data);
    } else {
        echo json_encode(["error" => "UserID is not set in POST data"]);
    }
}

function eve_update()
{
    global $conn;

    $eve_name = $_POST['eve_name1'];
    $eve_location = $_POST['eve_location1'];
    $eve_to_date = $_POST['eve_date12'];
    $eve_from_date = $_POST['eve_date11'];
    $eve_time = $_POST['eve_time1'];
    $eve_amount = $_POST['eve_amount1'];
    $id = $_POST['id'];

    // Prepare SQL statement
    $sql = "UPDATE event_tbl SET eve_name=?, eve_location=?, eve_to_date=?, eve_from_date=?, eve_time=?, eve_amount=? WHERE eve_id=?";

    $stmt = mysqli_prepare($conn, $sql);

    // Check if prepare statement succeeded
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Prepare statement failed: " . mysqli_error($conn)]);
        return;
    }

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssi", $eve_name, $eve_location, $eve_to_date, $eve_from_date, $eve_time, $eve_amount, $id);

    // Execute statement
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(["status" => "success", "message" => "Event updated successfully"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Event update failed: " . mysqli_stmt_error($stmt)]);
    }

    // Close statement
    mysqli_stmt_close($stmt);
}
