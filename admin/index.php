<?php
session_start();

if (!isset($_SESSION['emp_id'])) {
    header("Location: ../login/dist/"); 
    exit(); 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="./assets/img/favicon.png">

    <title>Admin cPanel</title>

    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <!-- Nucleo Icons -->
    <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <!-- CSS Files -->



    <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.1.0" rel="stylesheet" />

    <link rel="stylesheet" href="./assets/css/custome.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js" integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="./assets/js/custom.js"></script>

</head>


<body class="g-sidenav-show  bg-gray-100">





    <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark" id="sidenav-main">

        <div class="sidenav-header">
            <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
            <a class="navbar-brand m-0" href="">
                <img src="./assets/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
                <span class="ms-1 font-weight-bold text-white">Admin cPanel</span>
            </a>
        </div>


        <hr class="horizontal light mt-0 mb-2">

        <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
            <ul class="navbar-nav">

                <li class="nav-item">
                    <a class="nav-link text-white" id="create_user" href="">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">dashboard</i>
                        </div>

                        <span class="nav-link-text ms-1">Create User</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white" id="view_user" href="">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>

                        <span class="nav-link-text ms-1">View Users</span>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link text-white " href="logout.php">

                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>

                        <span class="nav-link-text ms-1">Logout</span>
                    </a>
                </li>
            </ul>
        </div>

    </aside>

    <main class="main-content border-radius-lg ">
        <div class="container-fluid py-4">
            <h1 class="text-center">Welcome To Admin Panel</h1>
            <div class="alert alert-success" id="success" role="alert">
                A simple success alert—check it out!
            </div>
            <div class="alert alert-danger" id="notsuccess" role="alert">
                A simple danger alert—check it out!
            </div>
            <div id="create_user1">
                <div class="container" style="width: 70%;">
                    <form id="create_user_form" method="post">
                        <div class="mb-3">
                            <label for="" class="form-label">Username</label>
                            <input type="text" name="emp_name" class="form-control" id="emp_name">
                            <div id="val_name">
                                Please provide a valid Username.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" name="emp_email" class="form-control" id="emp_email" aria-describedby="emailHelp">
                            <div id="val_email">
                                Please provide a valid email.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Phone no.</label>
                            <input type="number" name="emp_phone" class="form-control" id="emp_phone">
                            <div id="val_phone">
                                Please provide a valid Phone no.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputPassword1" class="form-label">Password</label>
                            <input type="password" name="emp_password" class="form-control" id="emp_password">
                            <div id="val_password">
                                Please provide a valid password.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Role -:</label>
                            <label for="" class="form-label">Admin</label>
                            <input type="radio" class="emp_role" name="emp_role" id="emp_admin" value="admin">
                            <label for="" class="form-label">Staff</label>
                            <input type="radio" class="emp_role" name="emp_role" id="emp_staff" value="staff">
                            <div id="val_role">
                                Please provide a Employee Role.
                            </div>
                        </div>
                        <div class="container" style="width: 50%;">
                            <div class="mb-3 d-flex justify-content-between">
                                <label for="" class="form-label">Permission -:</label>
                                <label for="" class="form-label">View</label>
                                <label for="" class="form-label">Edit</label>
                                <label for="" class="form-label">Delete</label>
                                <label for="" class="form-label">All</label>
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <label for="" class="form-label">Event -:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                                <input type="radio" class="emp_event" name="emp_event" id="emp_event1" value="view">
                                <input type="radio" class="emp_event" name="emp_event" id="emp_event2" value="edit">
                                <input type="radio" class="emp_event" name="emp_event" id="emp_event3" value="delete">
                                <input type="radio" class="emp_event" name="emp_event" id="emp_event4" value="all">
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <label for="" class="form-label">Calendar -:&nbsp;&nbsp;&nbsp;</label>
                                <input type="radio" class="emp_calendar" name="emp_calendar" id="emp_calendar1" value="view">
                                <input type="radio" class="emp_calendar" name="emp_calendar" id="emp_calendar2" value="edit">
                                <input type="radio" class="emp_calendar" name="emp_calendar" id="emp_calendar3" value="delete">
                                <input type="radio" class="emp_calendar" name="emp_calendar" id="emp_calendar4" value="all">
                            </div>
                            <div class="mb-3 d-flex justify-content-between">
                                <label for="" class="form-label">Dashboard -:</label>
                                <input type="radio" class="emp_dashboard" name="emp_dashboard" id="emp_dashboard1" value="view">
                                <input type="radio" class="emp_dashboard" name="emp_dashboard" id="emp_dashboard2" value="edit">
                                <input type="radio" class="emp_dashboard" name="emp_dashboard" id="emp_dashboard3" value="delete">
                                <input type="radio" class="emp_dashboard" name="emp_dashboard" id="emp_dashboard4" value="all">
                            </div>
                            <div id="val_permission">
                                Please provide a Permission.
                            </div>
                        </div>
                        <button id="add_user" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
            <div id="view_user1">
                <div class="container" style="width: 90%;">
                    <table id="emp_tbl" class="table">
                        <thead>
                            <tr>
                                <th scope="col">Employee ID</th>
                                <th scope="col">Employee Name</th>
                                <th scope="col">Employee Email</th>
                                <th scope="col">Employee Phone no.</th>
                                <th scope="col">Employee Role</th>
                                <th scope="col">Employee Event</th>
                                <th scope="col">Employee Calendar</th>
                                <th scope="col">Employee Dashboard</th>
                                <th scope="col">Action</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody id="result">

                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </main>
    <div class="modal fade" id="Update">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="UpdateLabel">Update Form</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p id="up-messages-error"></p>
              <form id="create_user_form1" method="post">
                <div class="mb-3">
                    <label for="" class="form-label">Username</label>
                    <input type="text" name="emp_name1" class="form-control" id="emp_name1">
                    <div id="val_name1">
                        Please provide a valid Username.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Email address</label>
                    <input type="email" name="emp_email1" class="form-control" id="emp_email1" aria-describedby="emailHelp">
                    <div id="val_email1">
                        Please provide a valid email.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Phone no.</label>
                    <input type="number" name="emp_phone1" class="form-control" id="emp_phone1">
                    <div id="val_phone1">
                        Please provide a valid Phone no.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Password</label>
                    <input type="password" name="emp_password1" class="form-control" id="emp_password1">
                    <div id="val_password1">
                        Please provide a valid password.
                    </div>
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Role -:</label>
                    <label for="" class="form-label">Admin</label>
                    <input type="radio" class="emp_role" name="emp_role1" id="emp_admin1" value="admin">
                    <label for="" class="form-label">Staff</label>
                    <input type="radio" class="emp_role" name="emp_role1" id="emp_staff1" value="staff">
                    <div id="val_role1">
                        Please provide a Employee Role.
                    </div>
                </div>
                <div class="container" style="width: 50%;">
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="" class="form-label">Permission -:</label>
                        <label for="" class="form-label">View</label>
                        <label for="" class="form-label">Edit</label>
                        <label for="" class="form-label">Detail</label>
                        <label for="" class="form-label">All</label>
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="" class="form-label">Event -:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" class="emp_event" name="emp_event1" id="emp_event11" value="view">
                        <input type="radio" class="emp_event" name="emp_event1" id="emp_event21" value="edit">
                        <input type="radio" class="emp_event" name="emp_event1" id="emp_event31" value="detail">
                        <input type="radio" class="emp_event" name="emp_event1" id="emp_event41" value="all">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="" class="form-label">Calendar -:&nbsp;&nbsp;&nbsp;</label>
                        <input type="radio" class="emp_calendar" name="emp_calendar1" id="emp_calendar11" value="view">
                        <input type="radio" class="emp_calendar" name="emp_calendar1" id="emp_calendar21" value="edit">
                        <input type="radio" class="emp_calendar" name="emp_calendar1" id="emp_calendar31" value="detail">
                        <input type="radio" class="emp_calendar" name="emp_calendar1" id="emp_calendar41" value="all">
                    </div>
                    <div class="mb-3 d-flex justify-content-between">
                        <label for="" class="form-label">Dashboard -:</label>
                        <input type="radio" class="emp_dashboard" name="emp_dashboard1" id="emp_dashboard11" value="view">
                        <input type="radio" class="emp_dashboard" name="emp_dashboard1" id="emp_dashboard21" value="edit">
                        <input type="radio" class="emp_dashboard" name="emp_dashboard1" id="emp_dashboard31" value="detail">
                        <input type="radio" class="emp_dashboard" name="emp_dashboard1" id="emp_dashboard41" value="all">
                    </div>
                    <div id="val_permission1">
                        Please provide a Permission.
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" id="btn_update">Update Now</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn_close">Close</button>
            </div>
          </div>
        </div>
      </div>
    <!--   Core JS Files   -->
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>











































































    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>


    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/material-dashboard.min.js?v=3.1.0"></script>
</body>

</html>