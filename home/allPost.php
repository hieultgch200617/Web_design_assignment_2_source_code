<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/postLayout.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="homepage.php">
                    <img src="../img/logo.png" style="width: 4rem"  alt="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="nav nav-tabs me-auto">
                    <?php if($_SESSION['status'] == 0): ?>      <!-- Nếu chưa đăng nhập -->
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registerAccount.php">Đăng ký</a>
                        </li>
                    <?php elseif ($_SESSION['status'] == 1): ?>     <!-- Đã đăng nhập -->
                        <?php if ($_SESSION['accountRoles'] == 'Admin'): ?>     <!-- Nếu là tài khoản admin -->
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/AccountManagement.php">Quản lý</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php elseif ($_SESSION['accountRoles'] == 'Nhà Tuyển Dụng'): ?> <!-- Nếu là tài khoản nhà tuyển dụng -->
                            <li class="nav-item">
                                <a class="nav-link" href="../user/Recruiter/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php elseif ($_SESSION['accountRoles'] == 'Sinh Viên'): ?> <!-- Nếu là tài khoản sinh viên -->
                            <li class="nav-item">
                                <a class="nav-link" href="../user/recruitee/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                    <li class="nav-item">
                            <a class="nav-link active" href="allPost.php">Bài đăng</a>
                        </li>
                    </ul>
                    <!-- TÌm kiếm -->
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex">
                        <input class="form-control me-2" type="text" name="search" placeholder="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main>
        
        <?php
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['search'] != ''):
            $all_post = find_all_post_with_search($_POST['search']);
            $count = mysqli_num_rows($all_post);
            for ($i = 0; $i < $count; $i++):
                $post = mysqli_fetch_assoc($all_post);
            ?>
            <div class="container">
                <img src="">
                <div class="card" style="width: 600px;">
                    <div class="card-header" style="font-weight: bold;"><?php echo $post['postName']; ?></div>
                    <div class="card-body">
                        <?php echo $post['recruiterName']; ?><br>
                        Hạn nộp: <?php echo $post['due']; ?><br>
                        Chuyên ngành: <?php echo $post['major']; ?><br>
                        Lương tối thiểu: <?php echo $post['minSalary']; ?> triệu VND<br>
                        Yêu cầu kinh nghiệm: <?php echo $post['experience']; ?>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo 'postDetails.php?id='.$post['postID']; ?>" class="btn btn-success">Chi tiết</a>
                    </div>
                </div>
            </div>
            
            <?php endfor; ?>

        <?php else:
            $all_post = find_all_post();
            $count = mysqli_num_rows($all_post);
            for ($i = 0; $i < $count; $i++):
                $post = mysqli_fetch_assoc($all_post);
            ?>
            <div class="container">
                <img src="">
                <div class="card" style="width: 600px;">
                    <div class="card-header" style="font-weight: bold;"><?php echo $post['postName']; ?></div>
                    <div class="card-body">
                        <?php echo $post['recruiterName']; ?><br>
                        Hạn nộp: <?php echo $post['due']; ?><br>
                        Chuyên ngành: <?php echo $post['major']; ?><br>
                        Lương tối thiểu: <?php echo $post['minSalary']; ?> triệu VND<br>
                        Yêu cầu kinh nghiệm: <?php echo $post['experience']; ?>
                    </div>
                    <div class="card-footer">
                        <a href="<?php echo 'postDetails.php?id='.$post['postID']; ?>" class="btn btn-success">Đến ứng tuyển</a>
                    </div>
                </div>
            </div>
            
            <?php endfor; ?>
        <?php endif; ?>

    </main>


</body>
</html>

<?php
db_disconnect($db);
?>