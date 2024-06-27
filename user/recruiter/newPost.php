<?php
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SESSION['accountRoles'] != "Nhà Tuyển Dụng") {
    redirect_to('../../home/login.php');
}

$id = $_SESSION['userID'];
$recruiter = find_recruiter_by_id($id);
$detail = mysqli_fetch_assoc($recruiter);

if ($_SERVER['REQUEST_METHOD'] == "POST"){
    $post = [];
    $post['postName'] = $_SESSION['newPostName'];
    $post['recruiterName'] = $_SESSION['recruiterName'];
    $post['major'] = $_POST['major'];
    $post['minSalary'] = $_POST['minSalary'];
    $post['workDetails'] = $_POST['workDetails'];
    if($_POST['experience'] == ""){
        $post['experience'] = "Không yêu cầu về kinh nghiệm";
    } else{
        $post['experience'] = $_POST['experience'];
    }
    $post['due'] = $_SESSION['due'];
    $post['recruiterID'] = $_SESSION['userID'];
    insert_post($post);
    $postID = mysqli_insert_id($db);

    redirect_to('PostManagement.php');
}

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
                            <a class="nav-link" href="PostManagement.php">Quản lý bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="newPost.php">Thêm bài đăng</a>
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
    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <h2>Tạo bài đăng mới</h2>
        <label>Tên bài đăng: </label>
        <input type="text" name="postName" value="<?php echo isFormValidated()? "": $_POST['postName'] ?>" required>
        <br><br>

        <label>Tên doanh nghiệp:  </label>
        <label><?php echo $detail['name']; ?></label>
        <input type="hidden" name="recruiterName" value="<?php echo $detail['name'] ?>" required>
        <br><br>

        <label>Chuyên ngành cần có: </label>
        <select name="major" value="<?php echo isFormValidated()? "": $_POST['major'] ?>">
            <option value="Công nghệ thông tin">Công nghệ thông tin</option>
            <option value="Công nghệ phần mềm">Công nghệ phần mềm</option>
            <option value="Hệ thống thông tin">Hệ thống thông tin</option>
            <option value="An toàn thông tin">An toàn thông tin</option>
            <option value="Mạng máy tính">Mạng máy tính</option>
            <option value="Truyền thông">Truyền thông</option>
        </select>
        <br><br>

        <label>Lương tối thiểu (triệu đồng):  </label>
        <input type="number" name="minSalary" style="width: 100%; padding: 10px;margin-bottom: 20px; border: 1px solid #ccc;border-radius: 4px; box-sizing: border-box;" required>
        <br><br>

        <label>Chi tiết công việc:  </label>
        <input type="text" name="workDetails" required>
        <br><br>

        <label>Yêu cầu về kinh nghiệm (bỏ trống nếu không yêu cầu kinh nghiệm):  </label>
        <input type="text" name="experience">
        <br><br>

        <label>Hạn nộp CV</label>
        <input type="date" name="due" value="<?php echo isFormValidated()? "": $_POST['due'] ?>" required>
        <br><br>

        <input type="submit" value="Tạo bài đăng">
    </form>
</body>
</html> 

<?php
db_disconnect($db);
?>