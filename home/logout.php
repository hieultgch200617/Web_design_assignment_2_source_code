<?php
require_once('../lib/initialize.php');

session_unset();    // Bỏ những thông tin đã lưu
$_SESSION['accountRoles'] = "";

$_SESSION['status'] = 0;    // Chuyển thành chưa đăng nhập
redirect_to('homepage.php');    // Quay về trang chủ



