<?php

require ('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_event') {
        add_event();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'view_event') {
        view_event();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'eve_delete') {
        eve_delete();
    }
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'eve_fetch') {
        eve_fetch();
    }
}