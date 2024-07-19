<?php

require ('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_user') {
        add_user();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'view_user') {
        view_user();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'emp_delete') {
        delete_user();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'fetch') {
        fetchData();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'update') {
        updateData();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'login_user') {
        login_user();
    }
}