<?php 
require_once('../lib/database.php');    //yêu cầu file database.php để chạy file
require_once('../lib/initialize.php');  //yêu cầu file initialize.php để chạy file
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý người dùng</title>
    <link rel="stylesheet" type="text/css" href="../css/table.css">     <!--link file css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">  <!--link boostaps -->
</head>
<body>
    
    <header>    <!-- thanh công cụ -->
        <nav class="navbar navbar-expand-sm navbar-dark bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="../home/homepage.php">    <!-- chuyển về homepage khi nhấn vào log -->
                    <img src="../img/logo.png" style="width: 4rem"  alt="logo">     <!-- website logo -->
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mynavbar">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="mynavbar">
                    <ul class="nav nav-tabs me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" href="AccountManagement.php" >Quản lý tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="PostManagement.php">Quản lý bài đăng</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../home/logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                        </li>
                    </ul>

                    <!-- tìm kiếm -->
                    <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" class="d-flex input-group w-auto">
                        <!-- nội dung tìm kiếm -->
                        <input class="form-control me-2" type="text" name="search" placeholder="Search">
                        <!-- lựa chọn nội dung tìm kiếm -->
                        <select name="category">
                            <?php if($_SERVER['REQUEST_METHOD'] == 'POST'): ?>
                                <option value="roles" <?php if ($_POST['category'] == "roles") echo 'selected'?>>Vai trò</option>
                                <option value="name" <?php if ($_POST['category'] == "name") echo 'selected'?>>Tên chủ tài khoản</option>
                            <?php else: ?>
                                <option value="roles">Vai trò</option>
                                <option value="name">Tên chủ tài khoản</option>
                            <?php endif; ?>
                        </select>&nbsp;&nbsp;
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>
            </div>
        </nav>
    </header>
    <main>

        <br><br>
        <center><h2>Quản lý người dùng</h2></center>
        <!-- bảng quản lý người dùng-->
        <table class="list">
            <tr>
                <th>Tên chủ tài khoản</th>
                <th>Vai trò</th>
                <th>Lựa chọn</th>
            </tr>

            <?php
            // Kiểm tra xem người dùng có ấn tìm kiếm hay ko
            if ($_SERVER['REQUEST_METHOD'] == 'POST'): 
                // Tìm kiếm theo vai trò
                if ($_POST['search'] != "" && $_POST['category'] == "roles"):
                    $all_Users = find_all_users_account_with_search($_POST['search']);
                    $count = mysqli_num_rows($all_Users);
                    for ($i = 0; $i < $count; $i++):
                        $account = mysqli_fetch_assoc($all_Users);  //Lấy về thông tin tài khoản từ $all_Users
                        if ($account['roles'] === "Nhà Tuyển Dụng"):
                            $user = find_recruiter_by_account_id($account['accountID']);
                            $userDetails = mysqli_fetch_assoc($user);   //Lấy về thông tin người dùng từ $user
                        ?>
                            <tr>
                                <td><?php echo $userDetails['name'] ?></td>
                                <td><?php echo $account['roles']; ?></td>
                                <!-- Nút details-->
                                <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                    class="btn btn-success">Chi tiết</a><br>
                                    <!-- Nút delete-->
                                    <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$account['roles']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                                </td>
                            </tr>
                        <?php else:
                            $user = find_recruitee_by_account_id($account['accountID']);
                            $userDetails = mysqli_fetch_assoc($user);
                            ?>
                            <tr>
                                <td><?php echo $userDetails['name'] ?></td>
                                <td><?php echo $account['roles']; ?></td>
                                <!-- Nút details-->
                                <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                    class="btn btn-success">Chi tiết</a><br>
                                    <!-- Nút delete-->
                                    <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$account['roles']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                                </td>
                            </tr>
                        <?php 
                        endif;
                    endfor;
                    ?>
                    <!-- Tìm kiếm theo tên người dùng -->
                <?php elseif ($_POST['search'] != "" && $_POST['category'] == "name"):
                    $all_recruiters = find_all_recruiter_with_search($_POST['search']);
                    $count = mysqli_num_rows($all_recruiters);
                    for ($i = 0; $i < $count; $i++):
                        $userDetails = mysqli_fetch_assoc($all_recruiters);
                        $account = find_account_by_id($userDetails['accountID']);
                        $accountDetails = mysqli_fetch_assoc($account);
                    ?>
                        <tr>
                            <td><?php echo $userDetails['name'] ?></td>
                            <td><?php echo $accountDetails['roles']; ?></td>
                            <!-- Nút details-->
                            <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                class="btn btn-success">Chi tiết</a><br>
                                <!-- Nút delete-->
                                <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$accountDetails['roles']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                            </td>
                        </tr>
                    <?php endfor;

                    $all_recruitee = find_all_recruitee_with_search($_POST['search']);
                    $count = mysqli_num_rows($all_recruitee);
                    for ($i = 0; $i < $count; $i++):
                        $userDetails = mysqli_fetch_assoc($all_recruitee);
                        $account = find_account_by_id($userDetails['accountID']);
                        $accountDetails = mysqli_fetch_assoc($account);
                        ?>
                        <tr>
                            <td><?php echo $userDetails['name'] ?></td>
                            <td><?php echo $accountDetails['roles']; ?></td>
                            <!-- Nút details-->
                            <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                class="btn btn-success">Chi tiết</a><br>
                                <!-- Nút delete-->
                                <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$accountDetails['roles']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                            </td>
                        </tr>
                    <?php 
                    endfor;
                    ?>
                <?php endif; ?>
                <!-- mặc định khi không ấn tìm kiếm hoặc không có nội dung tìm kiếm-->
            <?php else:
                $all_Users = find_all_users_account();
                $count = mysqli_num_rows($all_Users);
                for ($i = 0; $i < $count; $i++):
                    $account = mysqli_fetch_assoc($all_Users);
                    if ($account['roles'] === "Nhà Tuyển Dụng"):
                        $user = find_recruiter_by_account_id($account['accountID']);
                        $userDetails = mysqli_fetch_assoc($user);
                    ?>
                        <tr>
                            <td><?php echo $userDetails['name'] ?></td>
                            <td><?php echo $account['roles']; ?></td>
                            <!-- Nút details-->
                            <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                class="btn btn-success">Chi tiết</a><br>
                                <!-- Nút delete-->
                                <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$account['roles']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                            </td>
                        </tr>
                    <?php else:
                        $user = find_recruitee_by_account_id($account['accountID']);
                        $userDetails = mysqli_fetch_assoc($user);
                        ?>
                        <tr>
                            <td><?php echo $userDetails['name'] ?></td>
                            <td><?php echo $account['roles']; ?></td>
                            <!-- Nút details-->
                            <td><a href="<?php echo 'UserDetails.php?id='.$userDetails['accountID']; ?>" 
                                class="btn btn-success">Chi tiết</a><br>
                                <!-- Nút delete-->
                                <a href="<?php echo 'DeleteAccount.php?id='.$userDetails['accountID'].'&roles='.$account['roles']; ?>" class="btn btn-danger"
                                onclick="return confirm('Are you sure to delete this account ?');">Xóa</a>
                            </td>
                        </tr>
                    <?php 
                    endif;
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