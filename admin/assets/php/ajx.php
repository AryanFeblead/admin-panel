<?php

require ('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_user') {
        add_user();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'view_user') {
        view_user();
    }
}