<?php
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file

if(!isset($_GET['id'])) {
    redirect_to('PostManagement.php');
}
$id = $_GET['id'];  //  lấy id từ đường dẫn
$post = find_post_by_id($id);  //  tìm bài đăng bằng postID
$postDetails = mysqli_fetch_assoc($post);   // lấy thông tin bài đăng
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
                            <a class="nav-link" href="AccountManagement.php" >Quản lý tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="PostManagement.php">Quản lý bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../home/logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <br>
        <!-- Hiển thị thông tin bài đăng -->
        <form>
            <center><h2>Thông tin Bài đăng </h2></center>
            <br><br>
            <label>Chuyên ngành: </label>
            <lable><?php echo $postDetails['major']; ?></lable>
            <br><br>
            <label>Lương tối thiểu: </label>
            <lable><?php echo $postDetails['minSalary']; ?> triệu VND</lable>
            <br><br>
            <label>Chi tiết công việc: </label>
            <lable><?php echo $postDetails['workDetails']; ?></lable>
            <br><br>
            <label>Yêu cầu: </label>
            <lable><?php echo $postDetails['experience']; ?></lable>
            <br><br>
        </form>
    </main>

</body>
</html>

<?php
db_disconnect($db);
?>