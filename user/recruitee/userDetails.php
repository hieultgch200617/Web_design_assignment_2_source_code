<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Sinh Viên") {
    redirect_to('../../home/login.php');
}

$id = $_SESSION['accountID'];
$account = find_recruitee_by_account_id($id);
$accDetails = mysqli_fetch_assoc($account);
$_SESSION['userID'] = $accDetails['recruiteeID'];
$user = find_recruitee_by_id($_SESSION['userID']);
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
                            <a class="nav-link" href="recruitmentList.php">Trạng thái ứng tuyển</a>
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
    <main>
        <form>
            <input type="hidden" name="recruiteeID" value="<?php echo $userDetails['recruiteeID'] ?>">
            <center><h2>Thông tin sinh viên</h2></center>
            <br><br>    
            <label>Tên sinh viên: </label> <!--required-->
            <label><?php echo $userDetails['name']; ?></label>
            <br><br>

            <label>Ngày sinh: </label>
            <label><?php echo $userDetails['dateOfBirth']; ?></label>
            <br><br>
                    
            <label>Địa chỉ: </label>
            <label><?php echo $userDetails['address']; ?></label>
            <br><br>

            <label>Số điện thoại: </label>
            <label><?php echo $userDetails['phone']; ?></label>
            <br><br>

            <label>Email: </label>
            <label><?php echo $userDetails['email']; ?></label>
            <br><br>

            <label>Kinh nghiệm làm việc: </label>
            <label><?php echo $userDetails['experience']; ?></label>
            <br><br>

            <label>Chuyên ngành: </label>
            <label><?php echo $userDetails['major']; ?></label>
            <br><br>
        </form>
    </main>
</body>
</html>

<?php
mysqli_free_result($user);
db_disconnect($db);
?>