<?php
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file

$id = $_GET['id'];  //lấy id từ đường dẫn
delete_all_recruitment_by_post_id($id); //xóa tất cả phần ứng tuyển của bài đăng
delete_post_by_id($id); //xóa bài đăng

db_disconnect($db);

redirect_to('PostManagement.php');  //quay về quản lý bài đăng
?>