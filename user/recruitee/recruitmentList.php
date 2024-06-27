<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Sinh Viên") {
    redirect_to('../../home/login.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
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
                            <a class="nav-link active" href="recruitmentList.php">Trạng thái ứng tuyển</a>
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
    <center><h2>Danh sách ứng tuyển</h2></center>
    <br><br>

    <table class="list">
        <tr>
            <th>No.</th>
            <th>Tên bài đăng</th>
            <th>Tên nhà tuyển dụng</th>
            <th>Trạng thái</th>
            <th>Lựa chọn</th>
        </tr>

        <?php  
        if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['search'] != ""):
            $all_Recruitments = find_all_recruitment_by_userID_with_search($_SESSION['userID'], $_POST['search']);
            $count = mysqli_num_rows($all_Recruitments);
            for ($i = 0; $i < $count; $i++):
                $detail = mysqli_fetch_assoc($all_Recruitments);
                ?>
                <tr>
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo $detail['postName']; ?></td>
                    <td><?php echo $detail['recruiterName']; ?></td>
                    <td><?php echo $detail['status']; ?></td>
                    <?php if ($detail['status'] != "Bị loại" && $detail['status'] != "Được nhận" && $detail['status'] != "Đang chờ kết quả") ?>
                    <td><a href="<?php echo 'RemoveSubmission.php?id='.$detail['postID']; ?>" class="btn btn-danger"
                    onclick="return confirm('Are you sure to delete submission for this post?');">Xóa</a></td>
                </tr>
            <?php
            endfor;
            ?>
        <?php else:
        $all_Recruitments = find_all_recruitment_by_userID($_SESSION['userID']);
        $count = mysqli_num_rows($all_Recruitments);
        for ($i = 0; $i < $count; $i++):
            $detail = mysqli_fetch_assoc($all_Recruitments);
            ?>
            <tr>
                <td><?php echo $i + 1; ?></td>
                <td><?php echo $detail['postName']; ?></td>
                <td><?php echo $detail['recruiterName']; ?></td>
                <td><?php echo $detail['status']; ?></td>
                <td><a href="<?php echo 'RemoveSubmission.php?id='.$detail['postID']; ?>" class="btn btn-danger"
                onclick="return confirm('Are you sure to delete submission for this post?');">Xóa</a></td>
            </tr>
            <?php
            endfor;
            ?>
            <?php endif; ?>
        </table>
</body>
</html>

<?php
db_disconnect($db);
?>