<?php 
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file

//load Form
    if(!isset($_GET['id'])) {
        redirect_to('AccountManagement.php');
    }
    $id = $_GET['id'];
    $acc = find_account_by_id($id);
    $account = mysqli_fetch_assoc($acc);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thông tin người dùng</title>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>    <!-- thanh công cụ -->
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../home/homepage.php">
                    <img src="../img/logo.png" style="width: 4rem"  alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="nav nav-tabs me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="AccountManagement.php" >Quản lý tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PostManagement.php">Quản lý bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../home/logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <br>
    <form>
        <center><h2>Thông tin người dùng </h2></center>
        <?php
        // hiện thị thông tin Người Tìm Việc
        if ($account['roles'] == "Người Tìm Việc")
        {
            $userDetails = find_recruitee_by_account_id($id);
            $userDetails = mysqli_fetch_assoc($userDetails);
            ?>
            <label>Tên người tìm ệc: </label>
            <lable><?php echo $userDetails['name']; ?></lable>
            <br><br>
            <label>Năm sinh: </label>
            <lable><?php echo $userDetails['dateOfBirth']; ?></lable>
            <br><br>
            <label>Địa chỉ: </label>
            <lable><?php echo $userDetails['address']; ?></lable>
            <br><br>
            <label>Số điện thoại: </label>
            <lable><?php echo $userDetails['phone']; ?></lable>
            <br><br>
            <label>Email: </label>
            <lable><?php echo $userDetails['email']; ?></lable>
            <br><br>
            <label>Kinh nghiệm làm việc: </label>
            <lable><?php echo $userDetails['experience']; ?></lable>
            <br><br>
            <label>Chuyên ngành: </label>
            <lable><?php echo $userDetails['major']; ?></lable>
            <br><br>
        <?php
        //hiển thị thông tin nhà tuyển dụng
        } else if ($account['roles'] == "Nhà Tuyển Dụng"){
            $userDetails = find_recruiter_by_account_id($id);
            $userDetails = mysqli_fetch_assoc($userDetails);
            ?>
            <label>Tên doanh nghiệp: </label>
            <label><?php echo $userDetails['name']; ?></label>
            <br><br>
            <label>Địa chỉ: </label>
            <label><?php echo $userDetails['address']; ?></label>
            <br><br>
            <label>Giới thiệu công ty: </label>
            <label><?php echo $userDetails['intro']; ?></label>
            <br><br>
            <label>Website công ty: </label>
            <label><?php echo $userDetails['website']; ?></label>
            <br><br>
            <?php
        }
        ?>
    </form>
</body>
</html>

<?php
db_disconnect($db);
?>