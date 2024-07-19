<?php

require ('function.php');
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['actionName']) && $_POST['actionName'] == 'add_event') {
        add_event();
    }
}