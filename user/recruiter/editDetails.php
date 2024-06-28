<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $id = $_POST['recruiterID'];

    if(isFormValidated()){
        $userDetails = [];
        $userDetails['recruiterID'] = $id;
        $userDetails['name'] = $_POST['name'];
        $userDetails['address'] = $_POST['address'];
        $userDetails['intro'] = $_POST['intro'];
        $userDetails['website'] = $_POST['website'];

        update_recruiter($userDetails);
        redirect_to('userDetails.php');
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
    <title>Sửa thông tin người dùng</title>
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
                            <a class="nav-link active" href="editDetails.php">Thay đổi thông tin</a>
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
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <center><h2>Thay đổi thông tin người dùng</h2></center>
            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
                <div class="error">
                    <span> Vui lòng sửa những lỗi sau:  </span>
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

            
            <label>Tên doanh nghiệp: </label>
            <input type="text" name="name" value="<?php echo isFormValidated()? $userDetails['name']: $_POST['name'] ?>" required>
            <br><br>
            
            <label>Địa chỉ: </label>
            <input type="text" name="address" value="<?php echo isFormValidated()? $userDetails['address']: $_POST['address'] ?>" required>
            <br><br>

            <label>Giới thiệu về công ty</label>
            <input type="text" name="intro" value="<?php echo isFormValidated()? $userDetails['intro']: $_POST['intro'] ?>" required>
            <br><br>

            <label>Website</label>
            <input type="text" name="website" value="<?php echo isFormValidated()? $userDetails['website']: $_POST['website'] ?>" required>
            <br><br>


            <input type="submit" name="submit" value="Sửa">
            <input type="hidden" name="recruiterID" value="<?php echo isFormValidated()? $userDetails['recruiterID']: $_POST['recruiterID'] ?>">
            <br>
            <br><br>
        </form>
    </main>
</body>
</html>

<?php
db_disconnect($db);
?>