<?php 
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

if ($_SERVER["REQUEST_METHOD"] == 'POST'){
    $id = $_POST['recruiteeID'];

    if(isFormValidated()){
        $userDetails = [];
        $userDetails['recruiteeID'] = $id;
        $userDetails['name'] = $_POST['name'];
        $userDetails['dateOfBirth'] = $_POST['dateOfBirth'];
        $userDetails['address'] = $_POST['address'];
        $userDetails['phone'] = $_POST['phone'];
        $userDetails['email'] = $_POST['email'];
        if (empty($_POST['experience'])){
            $userDetails['experience'] = "Không";
        }else {
            $userDetails['experience'] = $_POST['experience'];
        }
        $userDetails['major'] = $_POST['major'];

        update_recruitee($userDetails);
        redirect_to('userDetails.php');
    }
}else { //load Form
    $id = $_SESSION['userID'];
    $user = find_recruitee_by_id($id);
    $userDetails = mysqli_fetch_assoc($user);
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa thông tin người dùng</title>
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
                            <a class="nav-link" href="recruitmentList.php">Trạng thái ứng tuyển</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="editDetails.php">Thay đổi thông tin</a>
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
    <main>
        <form action="<?php echo $_SERVER["PHP_SELF"];?>" method="post">
        <center><h2>Đổi thông tin người dùng</h2></center>
            <?php if ($_SERVER["REQUEST_METHOD"] == 'POST' && !isFormValidated()): ?> 
                <div class="error">
                    <span> Vui lòng sửa những lỗi sau:  </span>
                    <ul>
                        <?php
                        foreach ($errors as $key => $value){
                            if (!empty($value)){
                                echo '<li>', $value, '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div><br><br>
            <?php endif; ?>

            <input type="hidden" name="recruiteeID" 
            value="<?php echo isFormValidated()? $userDetails['recruiteeID']: $_POST['recruiteeID'] ?>" required >

            <label>Tên Người Tìm Việc</label> <!--required-->
            <input type="text" name="name"  
            value="<?php echo isFormValidated()? $userDetails['name']: $_POST['name'] ?>" required>
            <br><br>

            <label>Năm sinh</label>
            <input type="date" name="dateOfBirth"
            value="<?php echo isFormValidated()? $userDetails['dateOfBirth']: $_POST['dateOfBirth'] ?>" required>
            <br><br>
            
            <label>Địa chỉ</label>
            <input type="text" name="address"
            value="<?php echo isFormValidated()? $userDetails['address']: $_POST['address'] ?>" required> 
            <br><br>

            <label>Số điện thoại</label>
            <input type="text" name="phone"
            value="<?php echo isFormValidated()? $userDetails['phone']: $_POST['phone'] ?>" required>
            <br><br>

            <label>Email</label>
            <input type="email" name="email"
            value="<?php echo isFormValidated()? $userDetails['email']: $_POST['email'] ?>" required>
            <br><br>

            <label>Kinh nghiệm làm việc</label>
            <input type="text" name="experience"
            value="<?php echo isFormValidated()? $userDetails['experience']: $_POST['experience'] ?>" required>
            <br><br>

            <label>Chuyên ngành</label>
            <select name="major" value="<?php echo isFormValidated()? "": $_POST['major'] ?>">
                <option value="Công nghệ thông tin">Công nghệ thông tin</option>
                <option value="Công nghệ phần mềm">Công nghệ phần mềm</option>
                <option value="Hệ thống thông tin">Hệ thống thông tin</option>
                <option value="An toàn thông tin">An toàn thông tin</option>
                <option value="Mạng máy tính">Mạng máy tính</option>
                <option value="Truyền thông">Truyền thông</option>
            </select>
            <br><br>
            <input type="submit" name="submit" value="Edit">
            <br><br>
        </form>
    </main>
</body>
</html>

<?php
db_disconnect($db);
?>