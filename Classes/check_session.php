<?php
session_start();
echo json_encode(array('isLoggedIn' => isset($_SESSION['YOUBOOK_userid'])));