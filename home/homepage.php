<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
                    <?php if($_SESSION['status'] == 0 ): ?>      <!-- Nếu chưa đăng nhập -->
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
                        <?php elseif ($_SESSION['accountRoles'] == 'Nhà Tuyển Dụng'): ?>     <!-- Nếu là tài khoản nhà tuyển dụng -->
                            <li class="nav-item">
                                <a class="nav-link" href="../user/recruiter/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php elseif ($_SESSION['accountRoles'] == 'Sinh Viên'): ?>     <!-- Nếu là tài khoản sinh viên -->
                            <li class="nav-item">
                                <a class="nav-link" href="../user/recruitee/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link" href="allPost.php">Bài đăng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <section id="billboard">
            <div class="main-slider">
                <div class="slider-item">
                    <figure>
                        <center><img src="../img/banner.png" width="70%"></center>
                    </figure>
                    <div class="text-overlay">
                        <div class="container">
                            <div class="col-md-8">
                                <div class="text-content">
                                    <span class="fs-6 text-muted">Vừa mới tốt nghiệp và không có việc làm?</span>
                                    <h2 class="colored padding-xsmall display-1 lh-1 py-2">Tìm kiếm việc làm phù hợp với bản thân <a href="allPost.php">tại đây</a>!</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
<?php
db_disconnect($db);
?>