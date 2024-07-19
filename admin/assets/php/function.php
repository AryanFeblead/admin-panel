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

function delete_user(){
    global $conn;
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM emp_tbl WHERE emp_id = ?");
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

function fetchData()
{
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

function login_user(){
    global $conn;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        // Get username and password from form POST data
        $username = $_POST["emp_email"];
        $password = $_POST["emp_password"];

        
        $sql = "SELECT * FROM emp_tbl WHERE emp_email=?";
        $stmt = mysqli_stmt_init($conn);
        
        // Bind parameters to the prepared statement
        mysqli_stmt_bind_param($stmt, "s", $username);
        // Execute SQL statement
        mysqli_stmt_execute($stmt);
        // Get result
        $result = mysqli_stmt_get_result($stmt);
        print_r($result);
        die;
    
                // Check if user exists in database
                if ($row = mysqli_fetch_assoc($result)) {
                    // Verify password
                    $passwordCheck = password_verify($password, $row['password']);
                    if ($passwordCheck == false) {
                        // Redirect back to login page with error message
                        echo json_encode(["status" => "pass_error", "message" => "Employee Password Incorrect"]);
                    } elseif ($passwordCheck == true) {
                        session_start();
                        $_SESSION['userId'] = $row['emp_id'];
                        $_SESSION['username'] = $row['emp_name'];
                        echo json_encode(["status" => "success", "message" => "User updated successfully"]);
                        exit();
                    }
                } else {
                    // Redirect back to login page with error message
                    echo json_encode(["status" => "emp_error", "message" => "Employee Email Not Found"]);
                }
        
    }

    
}

