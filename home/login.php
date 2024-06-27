<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

$_SESSION['status'] = 0;    //Mặc định là chưa đăng nhập

if ($_SERVER["REQUEST_METHOD"] == "POST"){  // Nếu bấm login

    if (isFormValidated()){     // Nếu không có lỗi 
        $all_Accounts = find_all_account();         // Tìm kiếm tất cả tài khoản
        $count = mysqli_num_rows($all_Accounts);
        for ($i = 0; $i < $count; $i++){
            $account = mysqli_fetch_assoc($all_Accounts);
            if ($_POST['username'] == $account['username']){    // Đúng tên đăng nhập
                if (sha1($_POST['password']) == $account['hashedPassword']){    //Đúng mật khẩu
                    $_SESSION['status'] = 1;    //Chuyển thành đã đăng nhập
                    $_SESSION['accountID'] = $account['accountID'];     //lưu lại accountID
                    $_SESSION['hashedPassword'] = $account['hashedPassword'];   //lưu lại mật khẩu
                    $_SESSION['accountRoles'] = $account['roles'];  //lưu lại vai trò
                    redirect_to('homepage.php');    //quay về trang chủ
                }
            }
        }
        if ($_SESSION['status'] ==  0){
            $errors[] = 'tài khoản hoặc mật khẩu không đúng !';
        }
        mysqli_free_result($all_Accounts);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
                        <a class="nav-link active" href="login.php">Đăng nhập</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="registerAccount.php">Đăng ký</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="allPost.php">Bài đăng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <section>
        <!-- Form đăng nhập -->
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post">
            <center><h2>Đăng nhập</h2></center>
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
            <input type="text" name="username" required>
            <br><br>
            <label>Mật khẩu</label>
            <input type="password" name="password" required>
            <br>
            <input type="submit" value="Login">

        </form>
    </section>
</body>

</html>


<?php
db_disconnect($db);
?>