<?php
require_once('../lib/database.php');
require_once('../lib/initialize.php');

// Nhấn ứng tuyển 
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $post = find_post_by_id($_SESSION['id']);  //  tìm bài đăng bằng id
    $postDetails = mysqli_fetch_assoc($post);

    if ($_SESSION['status'] == 0){  //nếu chưa đăng nhập thì chuyển về trang đăng nhập
        redirect_to('login.php');
    }
    //Lấy thông tin từ của file CV
    $fileName = $_FILES["CV"]["name"];
    $fileSize = $_FILES["CV"]["size"];
    $tmpName = $_FILES["CV"]["tmp_name"];

    $ValidWordExtention = ['doc', 'docm', 'docx', 'dot', 'dotx'];
    $WordExtention = explode('.', $fileName);
    $WordExtention = strtolower(end($WordExtention));

    if(!in_array($WordExtention, $ValidWordExtention)){ //nếu không phải file word thì báo lỗi
        $errors[] = 'Chưa có CV';
    }else if($fileSize > 5000000){  //file quá lớn thì báo lỗi
        $errors[] = 'CV quá lớn (<5MB)';
    }
} else{     //load trang web
    if(!isset($_GET['id'])) {   //Không có id từ đường dẫn
        redirect_to('PostManagement.php');
    }
    //Có id từ đường dẫn
    $_SESSION['id'] = $_GET['id'];  // lấy id từ đường dẫn
    $post = find_post_by_id($_SESSION['id']);  //  tìm bài đăng bằng id
    $postDetails = mysqli_fetch_assoc($post);
}

// Kiểm tra xem Người Tìm Việc đã ứng tuyển vào bài đăng này hay chưa
if ($_SERVER["REQUEST_METHOD"] == 'POST' && $_SESSION['accountRoles'] == "Người Tìm Việc"){    
    $recruiteeAccount = find_recruitee_by_account_id($_SESSION['accountID']);
    $recruitee = mysqli_fetch_assoc($recruiteeAccount);
    $all_Recruitments = find_all_recruitment_by_userID($recruitee['recruiteeID']);
    $count = mysqli_num_rows($all_Recruitments);
    for ($i = 0; $i < $count; $i++){
        $recruitment = mysqli_fetch_assoc($all_Recruitments);
        if (strval($recruitment['postID']) == strval($postDetails['postID'])){
            $errors[] = 'Đã ứng tuyển cho bài đăng này, không thể ứng tuyển tiếp';
        }
    }
} elseif ($_SERVER["REQUEST_METHOD"] == 'POST' && $_SESSION['accountRoles'] != "Người Tìm Việc"){
    $errors[] = 'Chỉ Người Tìm Việc mới có thể ứng tuyển';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="../css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header>
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
                    <?php if($_SESSION['status'] == 0): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Đăng nhập</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="registerAccount.php">Đăng ký</a>
                        </li>
                    <?php elseif ($_SESSION['status'] == 1): ?>
                        <?php if ($_SESSION['accountRoles'] == 'Admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../admin/AccountManagement.php">Quản lý</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php elseif ($_SESSION['accountRoles'] == 'Nhà Tuyển Dụng'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../user/Recruiter/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php elseif ($_SESSION['accountRoles'] == 'Người Tìm Việc'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="../user/recruitee/userDetails.php">Người dùng</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="logout.php" onclick="return confirm('Chắc chắn muốn đăng xuất?');">Đăng xuất</a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                        <li class="nav-item">
                            <a class="nav-link active" href="allPost.php">Bài đăng</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <br>
        <form action="<?php echo $_SERVER["PHP_SELF"] ?>" method="post" enctype="multipart/form-data">
            <center><h2>Thông tin Bài đăng </h2></center>
            <br>
            <label>Chuyên ngành: </label>
            <lable><?php echo $postDetails['major']; ?></lable>
            <br><br>
            <label>Lương tối thiểu: </label>
            <lable><?php echo $postDetails['minSalary']; ?></lable>
            <br><br>
            <label>Chi tiết công việc: </label>
            <lable><?php echo $postDetails['workDetails']; ?></lable>
            <br><br>
            <label>Yêu cầu: </label>
            <lable><?php echo $postDetails['experience']; ?></lable>
            <br>

            <!-- type="hidden không hiển thị trên trang web" -->
            <input type="hidden" name="postID" value="<?php echo isFormValidated()? $postDetails['postID']: $_POST['postID'] ?>">
            <input type="hidden" name="postName" value="<?php echo isFormValidated()? $postDetails['postName']: $_POST['postName'] ?>">
            <input type="hidden" name="recruiterName" value="<?php echo isFormValidated()? $postDetails['recruiterName']: $_POST['recruiterName'] ?>">

            <!-- Hiển thị lỗi nếu có -->
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
                <br>
            <?php endif; ?>
            <center><h3>Ứng tuyển </h3></center>
            <Label>Chưa có CV? Tải CV mẫu tại </Label> <a href="../CV/CV sample.docx" download>đây</a><br>
            <label>Nộp CV: </label>
            <label for="files" class="btn" style="border:3px solid pink;">Chọn file</label>
            <input type="file" id="files" name="CV" accept=".doc, .docm, .docx, .dot, .dotx" style="visibility:hidden;">
            <input type="submit" value="Nộp đơn ứng tuyển">

            <?php
            if ($_SERVER["REQUEST_METHOD"] == 'POST' && isFormValidated()){
                //Lấy thông tin ứng tuyển 
                $postDetailsID = $_POST['postID'];
                $recruiteeID = $recruitee['recruiteeID'];
                $postDetailsName = $_POST['postName'];
                $recruiteeName = $recruitee['name'];
                $recruiterName = $_POST['recruiterName'];
                $status = "Đang chờ phê duyệt";

                $WordExtention = explode('.', $fileName);       // lấy tên file word
                $WordExtention = strtolower(end($WordExtention));       // lấy hậu tố file word
                $tmpName = $_FILES["CV"]["tmp_name"];

                $newWordName = uniqid("CV-", true). '.' . $WordExtention;   //  tạo tên CV mới để không trùng lặp

                move_uploaded_file($tmpName, '../CV/' . $newWordName);  //lưu CV vào folder CV

                // Tạo thông tin ứng tuyển
                $RecruitmentDetails = [];
                $RecruitmentDetails['postID'] = $postDetailsID;
                $RecruitmentDetails['recruiteeID'] = $recruiteeID;
                $RecruitmentDetails['postName'] = $postDetailsName;
                $RecruitmentDetails['recruiteeName'] = $recruiteeName;
                $RecruitmentDetails['recruiterName'] = $recruiterName;
                $RecruitmentDetails['status'] = $status;
                $RecruitmentDetails['CV'] = $newWordName;

                $result = insert_recruitment_details($RecruitmentDetails); //lưu thông tin ứng tuyển vào database
                echo "<h2>Ứng tuyển thành công</h2>";
            }
            ?>
        </form>
    </main>

</body>
</html>

<?php
db_disconnect($db);
?>