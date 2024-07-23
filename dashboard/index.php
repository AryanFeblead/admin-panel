<?php

require ('conn.php');
session_start();

if (!isset($_SESSION['emp_id'])) {
	header("Location: ../login/dist/");
	exit();
}
$emp_id = $_SESSION['emp_id'];
$select = mysqli_query($conn, "SELECT * FROM emp_tbl where emp_id = '$emp_id'");
if (mysqli_num_rows($select) > 0) {
	while ($row = mysqli_fetch_assoc($select)) {
		$emp_name = $row['emp_name'];
		$emp_event = $row['emp_event'];
		$emp_calendar = $row['emp_calendar'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Dashboard</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="vendors/images/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="vendors/images/favicon-16x16.png">

	<!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

	<!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
		rel="stylesheet">
	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="vendors/styles/core.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/icon-font.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="src/plugins/datatables/css/responsive.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="vendors/styles/style.css">
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.css'>
	<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.3.0/main.min.css'>
	<link rel="stylesheet" href="calendar.css">

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119386393-1"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
		integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
		crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>

	<script>
		$(document).ready(function () {

			var chart = new CanvasJS.Chart("chartContainer", {
				animationEnabled: true,
				exportEnabled: true,
				theme: "light1", // "light1", "light2", "dark1", "dark2"
				title: {
					text: "Simple Column Chart with Index Labels"
				},
				axisY: {
					includeZero: true
				},
				data: [{
					type: "column", //change type to bar, line, area, pie, etc
					//indexLabel: "{y}", //Shows y value on all Data Points
					indexLabelFontColor: "#5A5757",
					indexLabelFontSize: 16,
					indexLabelPlacement: "outside",
					dataPoints: [
						{ x: 10, y: 71 },
						{ x: 20, y: 55 },
						{ x: 30, y: 50 },
						{ x: 40, y: 65 },
						{ x: 50, y: 92, indexLabel: "\u2605 Highest" },
						{ x: 60, y: 68 },
						{ x: 70, y: 38 },
						{ x: 80, y: 71 },
						{ x: 90, y: 54 },
						{ x: 100, y: 60 },
						{ x: 110, y: 36 },
						{ x: 120, y: 49 },
						{ x: 130, y: 21, indexLabel: "\u2691 Lowest" }
					]
				}]
			});

			chart.render();

		});

	</script>
	<script src="index.js"></script>

</head>

<body>
	<div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="vendors/images/deskapp-logo.svg" alt=""></div>
			<div class='loader-progress' id="progress_div">
				<div class='bar' id='bar1'></div>
			</div>
			<div class='percent' id='percent1'>0%</div>
			<div class="loading-text">
				Loading...
			</div>
		</div>
	</div>

	<div class="header">
		<h1>
			Welcome
			<?php echo $emp_name ?>
		</h1>
	</div>

	<div class="right-sidebar">
		<div class="sidebar-title">
			<h3 class="weight-600 font-16 text-blue">
				Layout Settings
				<span class="btn-block font-weight-400 font-12">User Interface Settings</span>
			</h3>
			<div class="close-sidebar" data-toggle="right-sidebar-close">
				<i class="icon-copy ion-close-round"></i>
			</div>
		</div>
		<div class="right-sidebar-body customscroll">
			<div class="right-sidebar-body-content">
				<h4 class="weight-600 font-18 pb-10">Header Background</h4>
				<div class="sidebar-btn-group pb-30 mb-10">
					<a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
					<a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
				</div>

				<h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
				<div class="sidebar-btn-group pb-30 mb-10">
					<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light ">White</a>
					<a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
				</div>

				<h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
				<div class="sidebar-radio-group pb-10 mb-10">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
							value="icon-style-1" checked="">
						<label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
							value="icon-style-2">
						<label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input"
							value="icon-style-3">
						<label class="custom-control-label" for="sidebaricon-3"><i
								class="fa fa-angle-double-right"></i></label>
					</div>
				</div>

				<h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
				<div class="sidebar-radio-group pb-30 mb-10">
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-1" checked="">
						<label class="custom-control-label" for="sidebariconlist-1"><i
								class="ion-minus-round"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-2">
						<label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
								aria-hidden="true"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-3">
						<label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-4" checked="">
						<label class="custom-control-label" for="sidebariconlist-4"><i
								class="icon-copy dw dw-next-2"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-5">
						<label class="custom-control-label" for="sidebariconlist-5"><i
								class="dw dw-fast-forward-1"></i></label>
					</div>
					<div class="custom-control custom-radio custom-control-inline">
						<input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input"
							value="icon-list-style-6">
						<label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
					</div>
				</div>

				<div class="reset-options pt-30 text-center">
					<button class="btn btn-danger" id="reset-settings">Reset Settings</button>
				</div>
			</div>
		</div>
	</div>

	<div class="left-side-bar">
		<div class="brand-logo">
			<a href="index.html">
				<img src="vendors/images/deskapp-logo.svg" alt="" class="dark-logo">
				<img src="vendors/images/deskapp-logo-white.svg" alt="" class="light-logo">
			</a>
			<div class="close-sidebar" data-toggle="left-sidebar-close">
				<i class="ion-close-round"></i>
			</div>
		</div>
		<div class="menu-block customscroll">
			<div class="sidebar-menu">
				<ul id="accordion-menu">
					<li class="dropdown" id="dashboard">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
						</a>
					</li>
					<li class="dropdown">
						<a href="javascript:;" class="dropdown-toggle">
							<span class="micon dw dw-edit2"></span><span class="mtext">Event</span>
						</a>
						<ul class="submenu">
							<li id="add_event"><a>Add Event</a></li>
							<li id="view_event"><a>View Event</a></li>
						</ul>
					</li>
					<li class="dropdown" id="">
						<a href="./calendar07.php" class="dropdown-toggle">
							<span class="micon dw dw-calendar1"></span><span class="mtext">Calendar</span>
						</a>
					</li>
					<li>
						<a href="logout.php" class="dropdown-toggle no-arrow">
							<span class="micon dw dw-library"></span><span class="mtext">Logout</span>
						</a>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div class="mobile-menu-overlay"></div>

	<div class="main-container">
		<div class="alert alert-success" id="success" role="alert">
			A simple success alert—check it out!
		</div>
		<div class="alert alert-danger" id="notsuccess" role="alert">
			A simple danger alert—check it out!
		</div>
		<div id="dashboard1">
			<div id="chartContainer" style="height: 80vh; width: 100%;"></div>
		</div>
		<div id="add_event1">
			<div class="container" style="width: 70%;">
				<form id="event_form" method="post">
					<div class="mb-3">
						<label for="" class="form-label">Event Name</label>
						<input type="text" name="eve_name" class="form-control" id="eve_name">
						<div id="val_name">
							Please provide a valid event name.
						</div>
					</div>
					<div class="mb-3">
						<label for="" class="form-label">Event Location</label>
						<input type="text" name="eve_location" class="form-control" id="eve_location">
						<div id="val_location">
							Please provide a valid location.
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Event To Date</label>
						<input type="date" name="eve_date" class="form-control" id="eve_date">
						<div id="val_date">
							Please provide a valid date.
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Event From Date</label>
						<input type="date" name="eve_date1" class="form-control" id="eve_date1">
						<div id="val_date1">
							Please provide a valid date.
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Event Time</label>
						<input type="time" name="eve_time" class="form-control" id="eve_time">
						<div id="val_time">
							Please provide a valid time.
						</div>
					</div>
					<div class="mb-3">
						<label for="exampleInputPassword1" class="form-label">Event Amount</label>
						<input type="number" name="eve_amount" class="form-control" id="eve_amount">
						<div id="val_amount">
							Please provide a valid amount.
						</div>
					</div>

					<button id="add_user" class="btn btn-primary">Add Event</button>
				</form>
			</div>
		</div>
		<div id="view_event1">
			<div class="container" style="width: 90%;">
				<table id="emp_tbl" class="table">
					<thead>
						<tr>
							<th scope="col">Event ID</th>
							<th scope="col">Event Name</th>
							<th scope="col">Event Location</th>
							<th scope="col">Event To Date</th>
							<th scope="col">Event From Date</th>
							<th scope="col">Event Time</th>
							<th scope="col">Event Amount</th>
							<?php
							if ($emp_event == "edit" || $emp_event == "all") {
								echo "<th scope='col'>Action</th>";
							}
							if ($emp_event == "delete" || $emp_event == "all") {
								echo "<th scope='col'>Action</th>";
							}
							?>

						</tr>
					</thead>
					<tbody id="result">
						<?php
						$select1 = mysqli_query($conn, "SELECT * FROM event_tbl");

						if (mysqli_num_rows($select1) > 0) {
							while ($row = mysqli_fetch_assoc($select1)) {
								echo "<tr>";
								echo "<td>" . $row['eve_id'] . "</td>";
								echo "<td>" . $row['eve_name'] . "</td>";
								echo "<td>" . $row['eve_location'] . "</td>";
								echo "<td>" . $row['eve_to_date'] . "</td>";
								echo "<td>" . $row['eve_from_date'] . "</td>";
								echo "<td>" . $row['eve_time'] . "</td>";
								echo "<td>" . $row['eve_amount'] . "</td>";
								if ($emp_event == "edit" || $emp_event == "all") {
									echo "<td><a data-id=" . $row['eve_id'] . " class='btn btn-primary text-white edit'>Edit</a></td>";
								}
								if ($emp_event == "delete" || $emp_event == "all") {
									echo "<td><a data-id=" . $row['eve_id'] . " class='btn btn-danger text-white delete'>Delete</a></td>";
								}
								echo "</tr>";
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal fade" id="Update">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h1 class="modal-title fs-5" id="UpdateLabel">Update Form</h1>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<p id="up-messages-error"></p>
						<form id="event_form" method="post">
							<div class="mb-3">
								<label for="" class="form-label">Event Name</label>
								<input type="text" name="eve_name1" class="form-control" id="eve_name1">
								<div id="val_name1">
									Please provide a valid event name.
								</div>
							</div>
							<div class="mb-3">
								<label for="" class="form-label">Event Location</label>
								<input type="text" name="eve_location1" class="form-control" id="eve_location1">
								<div id="val_location1">
									Please provide a valid location.
								</div>
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Event To Date</label>
								<input type="date" name="eve_date12" class="form-control" id="eve_date12">
								<div id="val_date12">
									Please provide a valid date.
								</div>
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Event From Date</label>
								<input type="date" name="eve_date11" class="form-control" id="eve_date11">
								<div id="val_date11">
									Please provide a valid date.
								</div>
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Event Time</label>
								<input type="time" name="eve_time1" class="form-control" id="eve_time1">
								<div id="val_time1">
									Please provide a valid time.
								</div>
							</div>
							<div class="mb-3">
								<label for="exampleInputPassword1" class="form-label">Event Amount</label>
								<input type="number" name="eve_amount1" class="form-control" id="eve_amount1">
								<div id="val_amount1">
									Please provide a valid amount.
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary" id="btn_update">Update Now</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
							id="btn_close">Close</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script src="vendors/scripts/core.js"></script>
	<script src="vendors/scripts/script.min.js"></script>
	<script src="vendors/scripts/process.js"></script>
	<script src="vendors/scripts/layout-settings.js"></script>
	<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.2.0/main.min.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/daygrid@4.2.0/main.js'></script>
	<script src='https://cdn.jsdelivr.net/npm/@fullcalendar/interaction@4.2.0/main.js'></script>
	<script src="src/plugins/datatables/js/jquery.dataTables.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="src/plugins/datatables/js/dataTables.responsive.min.js"></script>
	<script src="src/plugins/datatables/js/responsive.bootstrap4.min.js"></script>
	<script>
		$("#emp_tbl").DataTable();
	</script>
</body>

</html>