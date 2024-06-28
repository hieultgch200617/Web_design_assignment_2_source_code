<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $_SESSION['postID'] = $_GET['id'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý post</title>
    <link rel="stylesheet" href="../../css/table.css">
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
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex">
                        <input class="form-control me-2" type="text" name="search" placeholder="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <br><br>
    <center><h2>Danh sách Người Tìm Việc đăng ký</h2></center>
    <br><br>
    <table class="list">
        <tr>
            <th>Tên Người Tìm Việc</th>
            <th>CV</th>
            <th>Trạng thái</th>
            <th>Lựa chọn</th>
        </tr>

        <?php 
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['search'] != ""):
            $all_recruitee = find_all_recruitment_by_postID_with_search($_SESSION['postID'], $_POST['search']);
            $count = mysqli_num_rows($all_recruitee);
            for ($i = 0; $i < $count; $i++):
                $recruitee = mysqli_fetch_assoc($all_recruitee);
                ?>
                <tr>
                    <td><?php echo $recruitee['recruiteeName']; ?></td>
                    <td><a href="<?php echo '../../CV/'.$recruitee['CV']; ?>" download>tải về</a></td>
                    <td><?php echo $recruitee['status']; ?></td>
                    <td><?php if ($recruitee['status'] == "Đang chờ phê duyệt"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=1'; ?>" 
                        class="btn btn-success">Đồng ý phỏng vấn</a><br>
                        <a href="<?php echo 'updateStatus.php?id'.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=0'; ?>" 
                        class="btn btn-danger">Loại</a>

                        <?php elseif ($recruitee['status'] == "Đang chờ phỏng vấn"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=2'; ?>" 
                        class="btn btn-success">Đã phỏng vấn</a>
                        <?php elseif ($recruitee['status'] == "Đang chờ kết quả"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=3'; ?>" 
                        class="btn btn-success">Nhận</a>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=0'; ?>" 
                        class="btn btn-danger">Loại</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endfor; ?>
        <?php else:
            $all_recruitee = find_all_recruitment_by_postID($_SESSION['postID']);
            $count = mysqli_num_rows($all_recruitee);
            for ($i = 0; $i < $count; $i++):
                $recruitee = mysqli_fetch_assoc($all_recruitee);
                ?>
                <tr>
                    <td><?php echo $recruitee['recruiteeName']; ?></td>
                    <td><a href="<?php echo '../../CV/'.$recruitee['CV']; ?>" download>tải về</a></td>
                    <td><?php echo $recruitee['status']; ?></td>
                    <td><?php if ($recruitee['status'] == "Đang chờ phê duyệt"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=1'; ?>" 
                        class="btn btn-success">Đồng ý phỏng vấn</a><br>
                        <a href="<?php echo 'updateStatus.php?id'.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=0'; ?>" 
                        class="btn btn-danger">Loại</a>

                        <?php elseif ($recruitee['status'] == "Đang chờ phỏng vấn"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=2'; ?>" 
                        class="btn btn-success">Đã phỏng vấn</a>
                        <?php elseif ($recruitee['status'] == "Đang chờ kết quả"): ?>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=3'; ?>" 
                        class="btn btn-success">Nhận</a>
                        <a href="<?php echo 'updateStatus.php?id='.$_SESSION['postID'].'&svID='.$recruitee['recruiteeID'].'&status=0'; ?>" 
                        class="btn btn-danger">Loại</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endfor; ?>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
db_disconnect($db);
?>