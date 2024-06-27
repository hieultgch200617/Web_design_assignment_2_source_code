<?php 
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý post</title>
    <link rel="stylesheet" href="../css/table.css">
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
                    <!-- tìm kiếm -->
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex">
                        <input class="form-control me-2" type="text" name="search" placeholder="Search">
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <br><br>
        <center><h2>Quản lý bài đăng</h2></center>
        <br><br>
        <!-- Bảng quản lý bài đăng -->
        <table class="list">
            <tr>
                <th>Post Name</th>
                <th>Recruiter Name</th>
                <th>Due</th>
                <th>Options</th>
            </tr>

            <?php  
            // Ấn tìm kiếm và có nội dung tìm kiếm
            if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['search'] != ""):
                $all_Posts = find_all_post_with_search($_POST['search']);
                $count = mysqli_num_rows($all_Posts);
                for ($i = 0; $i < $count; $i++):
                    $post = mysqli_fetch_assoc($all_Posts);
                    ?>
                    <tr>
                        <td><?php echo $post['postName']; ?></td>
                        <td><?php echo $post['recruiterName']; ?></td>
                        <td><?php echo $post['due']; ?></td>
                        <td><a href="<?php echo 'PostDetails.php?id='.$post['postID']; ?>"
                            class="btn btn-success">Chi tiết</a><br>
                            <a href="<?php echo 'DeletePost.php?id='.$post['postID']; ?>" class="btn btn-danger"
                            onclick="return confirm('Are you sure to delete this post ?');">Xóa</a>
                        </td>
                    </tr>
                    <?php
                    endfor;
                    ?>
            <!-- Hiện thị mặc định hoặc không có nội dung tìm kiếm -->
            <?php else:
                $all_Posts = find_all_post();
                $count = mysqli_num_rows($all_Posts);
                for ($i = 0; $i < $count; $i++):
                    $post = mysqli_fetch_assoc($all_Posts);
                    ?>
                    <tr>
                        <td><?php echo $post['postName']; ?></td>
                        <td><?php echo $post['recruiterName']; ?></td>
                        <td><?php echo $post['due']; ?></td>
                        <td><a href="<?php echo 'PostDetails.php?id='.$post['postID']; ?>"
                            class="btn btn-success">Chi tiết</a><br>
                            <a href="<?php echo 'DeletePost.php?id='.$post['postID']; ?>" class="btn btn-danger"
                            onclick="return confirm('Are you sure to delete this post ?');">Xóa</a>
                        </td>
                    </tr>
                    <?php
                endfor;
                ?>
            <?php endif; ?>
        </table>
    </main>
</body>
</html>

<?php
db_disconnect($db);
?>