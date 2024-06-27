<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){  //  nhấn tiếp theo
    $all_account = find_all_account();  //tìm kiếm tất cả tài khoản
    $count = mysqli_num_rows($all_account);
    for ($i = 0; $i < $count; $i++){
        $account = mysqli_fetch_assoc($all_account);
        if ($_POST['username'] == $account['username']){    // tên đăng nhập đã tồn tại thì báo lỗi
            $errors[] = 'tên đăng nhập đã tồn tại';
            break;
        }
    }
    if (isFormValidated()){     // nếu không có lỗi thì lưu lại thông tin tài khoản và chuyển sang đăng ký thông tin
        $_SESSION['newUsername'] = $_POST['username'];
        $_SESSION['newPassword'] = ($_POST['password']);
        $_SESSION['newRoles'] = $_POST['roles'];
        $_SESSION['newFindPassword'] = $_POST['findPassword'];
        redirect_to('registerDetails.php');
    }
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký tài khoản</title>
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

    <main>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
        <center><h2>Đăng ký tài khoản</h2></center>
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
                <label>Tên đăng nhập</label>
                <input type="text" name="username" value="<?php echo isFormValidated()? "": $_POST['username'] ?>" required>
                <br><br>
                <label>Mật khẩu</label>
                <input type="password" name="password" required>
                <br><br>
                <label>Vai trò</label>
                <select name="roles">
                    <option value="Sinh Viên">Sinh viên</option>
                    <option value="Nhà Tuyển Dụng">Nhà tuyển dụng</option>
                </select>
                <br><br>
                <input type="submit" value="Tiếp theo">
        </form>
    </main>

</body>

</html>


<?php
db_disconnect($db);
?>