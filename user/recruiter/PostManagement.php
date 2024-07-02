<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');
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
    <br>
    <center><h2>Quản Lý bài đăng</h2></center>
    <br><br>
    <table class="list">
        <tr>
            <th>No.</th>
            <th>Tên bài đăng</th>
            <th>Điều kiện</th>
            <th>Lựa chọn</th>
        </tr>

        <?php  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['search'] != ""):
            $all_Posts = find_all_post_by_userID_with_search($_SESSION['userID'], $_POST['search']);
            $count = mysqli_num_rows($all_Posts);
            for ($i = 0; $i < $count; $i++):
                $post = mysqli_fetch_assoc($all_Posts);
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $post['postName']; ?></td>
                    <td><?php echo $post['major']; ?> với <?php echo $post['experience']; ?></td>
                    <td><a href="<?php echo 'PostDetails.php?id='.$post['postID']; ?>" class="btn btn-success">Chi Tiết</a><br>
                        <a href="<?php echo 'recruiteeList.php?id='.$post['postID']; ?>" class="btn btn-success">Người Tìm Việc đăng ký</a><br>
                        <a href="<?php echo 'DeletePost.php?id='.$post['postID']; ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure to delete this post ?');">Xóa</a>
                    </td>
                </tr>
            <?php
            endfor;
            ?>
        <?php else:
            $all_Posts = find_all_post_by_userID($_SESSION['userID']);
            $count = mysqli_num_rows($all_Posts);
                for ($i = 0; $i < $count; $i++):
                    $post = mysqli_fetch_assoc($all_Posts);
                    ?>
                    <tr>
                        <td><?php echo $i + 1; ?></td>
                        <td><?php echo $post['postName']; ?></td>
                        <td><?php echo $post['major']; ?> với <?php echo $post['experience']; ?></td>
                        <td><a href="<?php echo 'PostDetails.php?id='.$post['postID']; ?>" class="btn btn-success">Chi Tiết</a><br>
                            <a href="<?php echo 'recruiteeList.php?id='.$post['postID']; ?>" class="btn btn-success">Người Tìm Việc đăng ký</a><br>
                            <a href="<?php echo 'DeletePost.php?id='.$post['postID']; ?>" class="btn btn-danger"
                            onclick="return confirm('Are you sure to delete this post ?');">Xóa</a>
                        </td>
                    </tr>
                <?php
                endfor;
        endif;
        if ($count == 0):
            ?>
            <tr>
                <td colspan="4"><center>Chưa có bài đăng nào được đăng</center></td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>

<?php
db_disconnect($db);
?>