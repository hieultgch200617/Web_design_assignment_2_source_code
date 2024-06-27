<?php
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Nhà Tuyển Dụng") {
    redirect_to('../../home/login.php');
}

if(!isset($_GET['id'])) {
    redirect_to('PostManagement.php');
}
$id = $_GET['id'];
$post = find_post_by_id($id);
$postDetails = mysqli_fetch_assoc($post);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            <a class="nav-link active" href="PostManagement.php">Quản lý bài đăng</a>
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
        <label>Tên bài đăng: </label>
        <label><?php echo $postDetails['postName']; ?></label>
        <br><br>

        <label>Lương tối thiểu: </label>
        <label><?php echo $postDetails['minSalary']; ?></label>
        <br><br>

        <label>Mô tả công việc: </label>
        <label><?php echo $postDetails['workDetails']; ?></label>
        <br><br>

        <label>Yêu cầu: </label>
        <label><?php echo $postDetails['major']; ?> với <?php echo $postDetails['experience']; ?></label>
        <br><br>

        <label>Hạn ứng tuyển: </label>
        <label><?php echo $postDetails['due']; ?></label>
        <br><br>
    </form>
</body>
</html>

<?php
db_disconnect($db);
?>