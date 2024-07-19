<?php

require ('conn.php');
function login_user() {
    global $conn;

    // Check if form submitted with method="post"
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve username (email) and password from POST data
        $useremail = $_POST["emp_email"];
        $password = $_POST["emp_password"];

        // Sanitize inputs to prevent SQL injection (optional but recommended)
        $useremail = mysqli_real_escape_string($conn, $useremail);
        $password = mysqli_real_escape_string($conn, $password);

        // Query to retrieve user information based on email
        $sql = "SELECT * FROM emp_tbl WHERE emp_email='$useremail'";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) == 1) {
          
                $row = mysqli_fetch_assoc($result);
               
                if ($password == $row['emp_password']) {
                    session_start();
                 
                    $_SESSION['emp_id'] = $row['emp_id'];
                    $_SESSION['emp_name'] = $row['emp_name'];
                    if($row['emp_role'] == 'admin'){
                        echo json_encode(["status" => "admin", "message" => "User login successfully"]);
                    }else{
                        echo json_encode(["status" => "staff", "message" => "User login successfully"]);
                    }
                    
                } else {
                    
                    echo json_encode(["status" => "emp_pass_error", "message" => "Invalid password"]);
                }
            } else {
              
                echo json_encode(["status" => "emp_error", "message" => "User not found"]);
            }
        } else {
       
            echo json_encode(["status" => "emp_db_error", "message" => "Database error"]);
        }
    }
}
login_user();