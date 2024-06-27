<?php 
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file

$accountID = $_GET['id'];   //lấy id từ đường dẫn
$roles = $_GET['roles'];    //lấy vai trò từ đường dẫn

// xóa sinh viên
if ($roles == "Sinh Viên"){
    $user = find_recruitee_by_account_id($accountID);   // dùng accountID để tìm kiếm thông tin sinh viên
    $recruitee = mysqli_fetch_assoc($user);
    delete_all_recruitment_by_recruitee_id($recruitee['recruiteeID']);  // xóa tất phần ứng tuyển của sinh viên
    delete_recruitee_by_id($recruitee['recruiteeID']);  // xóa thông tin sinh viên
    delete_account_by_id($accountID);   // xóa tài khoản sinh viên
//xóa nhà tuyển dụng
}elseif ($roles == "Nhà Tuyển Dụng"){
    $user = find_recruiter_by_account_id($accountID);   // dùng accountID để tìm kiếm thông tin nhà tuyển dụng
    $recruiter = mysqli_fetch_assoc($user);
    delete_all_recruitment_by_recruiter_name($recruiter['name']);   // xóa tất cả phần ứng tuyển từ nhà tuyển dụng
    $all_post = find_all_post_by_userID($recruiter['recruiterID']); // tìm kiếm tất cả bài đăng của nhà tuyển dụng
    $count = mysqli_num_rows($all_post);
    // nếu có bài đăng
    if ($count != 0){
        for ($i = 0; $i < $count; $i++){
            $post = mysqli_fetch_assoc($all_post);
            delete_post_by_id($post['postID']);     //xóa bài đăng
        }
    }
    delete_recruiter_by_id($recruiter['recruiterID']);  //xóa nhà tuyển dụng
    delete_account_by_id($accountID);   //xóa tài khoản nhà tuyển dụng
}

db_disconnect($db);

redirect_to('AccountManagement.php');   //quay về quản lý tài khoản
?>