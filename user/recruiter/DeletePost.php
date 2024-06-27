<?php
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Nhà Tuyển Dụng") {
    redirect_to('../../home/login.php');
}

$id = $_GET['id'];
delete_all_recruitment_by_post_id($id);
delete_post_by_id($id);

db_disconnect($db);

redirect_to('PostManagement.php');
?>