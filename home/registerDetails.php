<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){ // Nhấn tạo tài khoản
    // Tạo thông tin tài khoản mới 
    $newAccount = [];
    $newAccount['roles'] = $_SESSION['newRoles'];
    $newAccount['username'] = $_SESSION['newUsername'];
    $newAccount['hashedPassword'] = sha1($_SESSION['newPassword']);
    $newAccount['findPassword'] = $_SESSION['newFindPassword'];
    insert_account($newAccount);    // Thêm tài khoản mới vào database
    $accountID = mysqli_insert_id($db);     // Lấy accountID của tài khoản mới

    //tài khoản mới là của Người Tìm Việc
    if ($_SESSION['newRoles'] == "Người Tìm Việc"){
        //tạo thông tin Người Tìm Việc
        $newRecruitee = [];
        $newRecruitee['name'] = $_POST['name'];
        $newRecruitee['dateOfBirth'] = $_POST['dateOfBirth'];
        $newRecruitee['address'] = $_POST['address'];
        $newRecruitee['phone'] = $_POST['phone'];
        $newRecruitee['email'] = $_POST['email'];
        if ($_POST['experience'] == ""){    // kinh nghiệm mà bỏ trống thì đặt là Không
            $newRecruitee['experience'] = "Không";
        }else {
            $newRecruitee['experience'] = $_POST['experience'];
        }
        $newRecruitee['major'] = $_POST['major'];
        $newRecruitee['accountID'] = $accountID;

        insert_recruitee($newRecruitee);    // Thêm thông tin Người Tìm Việc vào database
        redirect_to('login.php'); // Quay về đăng nhập

    //tài khoản mới là của nhà tuyển dụng
    } elseif ($_SESSION['newRoles'] == "Nhà Tuyển Dụng"){
        //tạo thông tin nhà tuyển dụng
        $newRecruiter = [];
        $newRecruiter['name'] = $_POST['name'];
        $newRecruiter['address'] = $_POST['address'];
        $newRecruiter['intro'] = $_POST['intro'];
        $newRecruiter['website'] = $_POST['website'];
        $newRecruiter['accountID'] = $accountID;

        insert_recruiter($newRecruiter); // Thêm thông tin nhà tuyển dụng vào database
        redirect_to('login.php');   // Quay về đăng nhập
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký thông tin người dùng</title>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
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
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="registerAccount.php">Đăng ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allPost.php">Bài đăng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <center><h2>Đăng ký thông tin người dùng</h2></center>
        <a href="registerAccount.php">Quay lại đăng ký tài khoản</a>
        <br>
            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
                <div class="error">
                    <ul>
                        <?php
                        foreach ($errors as $key => $value){
                            if (!empty($value)){
                                echo '<li>', $value, '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                <br><br>
            <?php endif; ?>
        <br>
        <!-- Vai trò tài khoản mới là Người Tìm Việc -->
        <?php if($_SESSION['newRoles'] == "Người Tìm Việc"): ?>
            <label>Tên Người Tìm Việc</label>
            <input type="text" name="name" value="<?php echo isFormValidated()? "": $_POST['name'] ?>" required>
            <br><br>
            <label>Ngày sinh</label>
            <input type="date" name="dateOfBirth" value="<?php echo isFormValidated()? "": $_POST['dateOfBirth'] ?>" required>
            <br><br>
            <label>Địa chỉ</label>
            <input type="text" name="address" value="<?php echo isFormValidated()? "": $_POST['address'] ?>" required>
            <br><br>
            <label>Số điện thoại</label>
            <input type="tel" name="phone" value="<?php echo isFormValidated()? "": $_POST['phone'] ?>" required>
            <br><br>
            <label>email</label>
            <input type="email" name="email" value="<?php echo isFormValidated()? "": $_POST['email'] ?>" required>
            <br><br>
            <label>Kinh nghiệm làm việc (bỏ trống nếu chưa có kinh nghiệm làm việc)</label>
            <input type="text" name="experience" value="<?php echo isFormValidated()? "": $_POST['experience'] ?>">
            <label>Chuyên nghành</label>
            <select name="major" value="<?php echo isFormValidated()? "": $_POST['major'] ?>">
                <option value="Công nghệ thông tin">Công nghệ thông tin</option>
                <option value="Công nghệ phần mềm">Công nghệ phần mềm</option>
                <option value="Hệ thống thông tin">Hệ thống thông tin</option>
                <option value="An toàn thông tin">An toàn thông tin</option>
                <option value="Mạng máy tính">Mạng máy tính</option>
                <option value="Truyền thông">Truyền thông</option>
            </select>

            <!-- Vai trò tài khoản mới là nhà tuyển dụng -->
        <?php elseif ($_SESSION['newRoles'] == "Nhà Tuyển Dụng"):?>
            <label>Tên doanh nghiệp: </label>
            <input type="text" name="name" value="<?php echo isFormValidated()? "": $_POST['name'] ?>" required>
            <br><br>
            <label>Địa chỉ: </label>
            <input type="text" name="address" value="<?php echo isFormValidated()? "": $_POST['address'] ?>" required> 
            <br><br>
            <label>Giới thiệu về công ty: </label>
            <input type="text" name="intro" value="<?php echo isFormValidated()? "": $_POST['intro'] ?>" required>
            <br><br>
            <label>website (nếu có): </label>
            <input type="text" name="website" value="<?php echo isFormValidated()? "": $_POST['website'] ?>">
            <br><br>
        <?php endif; ?>
            <input type="submit" value="Tạo tài khoản">
        </form>
</body>

</html>


<?php
db_disconnect($db);
?>