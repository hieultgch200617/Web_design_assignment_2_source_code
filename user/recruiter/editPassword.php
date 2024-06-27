<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Nhà Tuyển Dụng") {
    redirect_to('../../home/login.php');
}

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $id = $_POST['recruiterID'];
    $account = find_account_by_recruiter_id($id);
    $accountDetails = mysqli_fetch_assoc($account);
    if(isFormValidated()){
        if ($accountDetails['hashedPassword'] != sha1($_POST["hashedPassword"])){
            $errors[] = 'Mật khẩu cũ không khớp';
        } else{
            if ($_POST['newPassword'] != $_POST['confirmPassword']){
                $errors[] = 'Mật khẩu mới không trùng nhau';
            }else {
                $accountID = $accountDetails['accountID'];
                $newPassword = sha1($_POST['newPassword']);
                update_account_password($accountID, $newPassword);
                redirect_to('userDetails.php');
            }
        }
    }
}else { //load Form
    $id = $_SESSION['userID'];
    $user = find_recruiter_by_id($id);
    $userDetails = mysqli_fetch_assoc($user);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đổi mật khẩu</title>
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
                            <a class="nav-link" href="userDetails.php">Thông tin người dùng</a>
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
                            <a class="nav-link active" href="editPassword.php">Thay đổi mật khẩu</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../home/logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <h2>Đổi mật khẩu</h2>
            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
                <div class="error">
                    <span> Please fix the following errors </span>
                    <ul>
                        <?php
                        foreach ($errors as $key => $value){
                            if (!empty($value)){
                                echo '<li>', $value, '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div><br><br>
            <?php endif; ?>

            <input type="hidden" name="recruiterID" 
            value="<?php echo isFormValidated()? $userDetails['recruiterID']: $_POST['recruiterID'] ?>" >

            <label>Mật khẩu cũ</label>
            <input type="password" id="hashedPassword" name="hashedPassword" required>
            <br><br>

            <label>Mật khẩu mới</label>
            <input type="password" id="newPassword" name="newPassword" required>
            <br><br>

            <label>Xác nhận mật khẩu</label>
            <input type="password" id="confirmPassword" name="confirmPassword" required>
            <br><br>

            <input type="submit" name="submit" value="Edit">
            <br><br>
        </form>
</body>
</html>

<?php
db_disconnect($db);
?>