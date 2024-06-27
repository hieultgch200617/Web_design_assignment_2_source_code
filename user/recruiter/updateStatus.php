<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Nhà Tuyển Dụng") {
    redirect_to('../../home/login.php');
}

$postID = $_GET['id'];
$recruiteeID = $_GET['svID'];
if ($_GET['status'] == "1"){
    $status = "Đang chờ phỏng vấn";
    update_recruitment_status_with_post_and_recruiteeID($postID, $recruiteeID, $status);
} elseif ($_GET['status'] == "2"){
    $status = "Đang chờ kết quả";
    update_recruitment_status_with_post_and_recruiteeID($postID, $recruiteeID, $status);
} elseif ($_GET['status'] == "3"){
    $status = "Được nhận";
    update_recruitment_status_with_post_and_recruiteeID($postID, $recruiteeID, $status);
} else {
    $status = "Bị loại";
    update_recruitment_status_with_post_and_recruiteeID($postID, $recruiteeID, $status);
}
redirect_to('recruiteeList.php?id='.$postID);
?>