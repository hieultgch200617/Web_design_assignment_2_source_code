<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

$id = $_SESSION['accountID'];
$account = find_recruiter_by_account_id($id);
$accDetails = mysqli_fetch_assoc($account);
$_SESSION['userID'] = $accDetails['recruiterID'];
$user = find_recruiter_by_id($_SESSION['userID']);
$userDetails = mysqli_fetch_assoc($user);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" type="text/css" href="../../css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../../home/homepage.php">
                    <img src="../../img/logo.png" style="width: 4rem"  alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="nav nav-tabs me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="userDetails.php">Thông tin người dùng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PostManagement.php">Quản lý bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="newPost.php">Thêm bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="editDetails.php">Thay đổi thông tin</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="editPassword.php">Thay đổi mật khẩu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../home/logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <form>
        <label>Tên doanh nghiệp</label>
        <label><?php echo $userDetails['name']; ?></label>
        <br><br>

        <label>Địa chỉ</label>
        <label><?php echo $userDetails['address']; ?></label>
        <br><br>

        <label>Giới thiệu về công ty</label>
        <label><?php echo $userDetails['intro']; ?></label>
        <br><br>

        <label>Website</label>
        <label><?php echo $userDetails['website']; ?></label>
        <br><br>
    </form>
</body>
</html>

<?php
mysqli_free_result($user);
db_disconnect($db);
?>