<?php
define("DB_SERVER", "localhost");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_NAME", "1633_Assignment");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
    return $connection;
}

$db = db_connect();

function db_disconnect($connection) { 
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

function confirm_query_result($result){
    global $db;
    if (!$result){
        echo mysqli_error($db);
        db_disconnect($db);
        exit; //terminate php
    } else {
        return $result;
    }
}

function find_all_post_with_search($key){
    global $db;
    $sql = "SELECT * FROM Post WHERE postName LIKE '%{$key}%' OR recruiterName LIKE '%{$key}%' OR major LIKE '%{$key}%' 
            OR minSalary LIKE '%{$key}%' OR workDetails LIKE '%{$key}%' OR experience LIKE '%{$key}%' OR due LIKE '%{$key}%' 
            ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

function delete_recruitment_by_recruitee_and_post_id($rID, $pID){
    global $db;
    $sql = "DELETE FROM RecruitmentDetails WHERE recruiteeID = '{$rID}' && postID = '{$pID}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_recruitment_by_post_and_user_id($postID, $recruiteeID){
    global $db;
    $sql = "SELECT * FROM RecruitmentDetails WHERE postID = '{$postID}' AND recruiteeID = '{$recruiteeID}' ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_all_recruitment_by_postID_with_search($id, $key){
    global $db;
    $sql = "SELECT * FROM RecruitmentDetails WHERE postID = '{$id}' AND recruiteeName LIKE '%{$key}%' OR status LIKE '%{$key}%' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_all_post_by_userID_with_search($id, $key){
    global $db;
    $sql = "SELECT * FROM post WHERE recruiterID = '{$id}' AND postName LIKE '%{$key}%' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_all_recruitment_by_userID_with_search($id, $key){
    global $db;
    $sql = "SELECT * FROM RecruitmentDetails WHERE recruiteeID = '{$id}' AND postName LIKE '%{$key}%' OR recruiterName LIKE '%{$key}%' OR status LIKE '%{$key}%' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_all_recruitee_with_search($key){
    global $db;
    $sql = "SELECT * FROM Recruitee Where name LIKE '%{$key}%' ORDER BY recruiteeID DESC";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_all_recruiter_with_search($key){
    global $db;
    $sql = "SELECT * FROM Recruiters Where name LIKE '%{$key}%' ORDER BY recruiterID DESC";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_all_users_account_with_search($key){
    global $db;
    $sql = "SELECT * FROM Accounts Where (roles = 'Nhà Tuyển Dụng' OR roles = 'Người Tìm Việc') AND roles LIKE '%{$key}%' ORDER BY accountID DESC";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function delete_all_recruitment_by_recruiter_name($name){
    global $db;
    $sql = "DELETE FROM RecruitmentDetails WHERE recruiterName = '{$name}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function delete_all_recruitment_by_recruitee_id($id){
    global $db;
    $sql = "DELETE FROM RecruitmentDetails WHERE recruiteeID = '{$id}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function insert_post($post){
    global $db;
    $sql = "INSERT INTO post (postName, recruiterName, major, minSalary, workDetails, experience, due, recruiterID) VALUES 
            ('{$post['postName']}', '{$post['recruiterName']}', '{$post['major']}', '{$post['minSalary']}', '{$post['workDetails']}', 
            '{$post['experience']}', '{$post['due']}', '{$post['recruiterID']}' )";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function delete_all_recruitment_by_post_id($id){
    global $db;
    $sql = "DELETE FROM RecruitmentDetails WHERE postID = '{$id}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function update_recruitment_status_with_post_and_recruiteeID($pID, $svID, $status){
    global $db;
    $sql = "UPDATE RecruitmentDetails SET status = '{$status}' WHERE postID = '{$pID}' AND recruiteeID = '{$svID}' ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function insert_recruitment_details($Details){
    global $db;
    $sql = "INSERT INTO RecruitmentDetails (postID, recruiteeID, postName, recruiteeName, recruiterName, status, CV) VALUES ";
    $sql .= "('{$Details['postID']}', '{$Details['recruiteeID']}', '{$Details['postName']}', '{$Details['recruiteeName']}', '{$Details['recruiterName']}', '{$Details['status']}', '{$Details['CV']}') ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_all_post(){
    global $db;
    $sql = "SELECT * FROM Post ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

function update_account_password($accountID, $newPassword){
    global $db;
    $sql = "UPDATE Accounts SET hashedPassword = '{$newPassword}' WHERE accountID = '{$accountID}' ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function insert_recruiter($recruiter){
    global $db;
    $sql = "INSERT INTO Recruiters (name, address, intro, website, accountID) VALUES ";
    $sql .= "('{$recruiter['name']}', '{$recruiter['address']}', '{$recruiter['intro']}', '{$recruiter['website']}', '{$recruiter['accountID']}') ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function insert_recruitee($recruitee){
    global $db;
    $sql = "INSERT INTO Recruitee (name, dateOfBirth, address, phone, email, experience, major, accountID) VALUES ";
    $sql .= " ('{$recruitee['name']}', '{$recruitee['dateOfBirth']}', '{$recruitee['address']}', '{$recruitee['phone']}', '{$recruitee['email']}', '{$recruitee['experience']}', '{$recruitee['major']}', {$recruitee['accountID']}) ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function insert_account($account){
    global $db;
    $sql = "INSERT INTO Accounts (roles, username, hashedPassword) VALUES ('{$account['roles']}', '{$account['username']}', '{$account['hashedPassword']}') ";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}


function delete_post_by_id($id){
    global $db;
    $sql = "DELETE FROM Post WHERE postID = '{$id}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_post_by_id($id){
    global $db;
    $sql = "SELECT * FROM Post WHERE postID = '{$id}'";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_all_recruitment_by_postID($id){
    global $db;
    $sql = "SELECT * FROM RecruitmentDetails WHERE postID = '{$id}' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_all_recruitment_by_userID($id){
    global $db;
    $sql = "SELECT * FROM RecruitmentDetails WHERE recruiteeID = '{$id}' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_all_post_by_userID($id){
    global $db;
    $sql = "SELECT * FROM Post WHERE recruiterID = '{$id}' ORDER BY postID DESC";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function find_all_account(){
    global $db;
    $sql = "SELECT * FROM accounts ORDER BY accountID DESC";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function update_recruiter($user){
    global $db;
    $sql = "UPDATE Recruiters SET name = '{$user['name']}', address = '{$user['address']}', intro = '{$user['intro']}', website = '{$user['website']}' 
            WHERE recruiterID = '{$user['recruiterID']}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

function delete_recruitee_by_id($id){
    global $db;
    $sql = "DELETE FROM Recruitee WHERE recruiteeID = '{$id}' LIMIT 1";
    $result = mysqli_query($db, $sql); 
    return confirm_query_result($result);
}

function delete_recruiter_by_id($id){
    global $db;
    $sql = "DELETE FROM Recruiters WHERE recruiterID = '{$id}' LIMIT 1";
    $result = mysqli_query($db, $sql); 
    return confirm_query_result($result);
}

function delete_account_by_id($id){
    global $db;
    $sql = "DELETE FROM Accounts WHERE accountID = '{$id}' LIMIT 1";
    $result = mysqli_query($db, $sql); 
    return confirm_query_result($result);
}

function find_account_by_id($id){
    global $db;
    $sql = "SELECT * FROM Accounts WHERE accountID = '{$id}' ";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_recruiter_by_account_id($id){
    global $db;
    $sql = "SELECT * FROM Recruiters WHERE accountID = '{$id}' ";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_recruitee_by_account_id($id){
    global $db;
    $sql = "SELECT * FROM Recruitee WHERE accountID = '{$id}' ";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_all_users_account(){
    global $db;
    $sql = "SELECT * FROM Accounts Where roles = 'Nhà Tuyển Dụng' OR roles = 'Người Tìm Việc' ORDER BY accountID DESC";
    $result = mysqli_query($db, $sql); 
    return $result;
}

function find_recruiter_by_id($id) {
    global $db;
    $sql = "SELECT * FROM Recruiters WHERE recruiterID = '{$id}' ";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_recruitee_by_id($id){
    global $db;
    $sql = "SELECT * FROM Recruitee WHERE recruiteeID = '{$id}' ";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_account_by_recruiter_id($id){
    global $db;
    $sql = "SELECT * FROM Recruiters WHERE recruiterID = '{$id}' ";
    $result1 = mysqli_query($db, $sql);
    $recruiter = mysqli_fetch_assoc($result1);
    $sql = "SELECT * FROM Accounts WHERE accountID = '{$recruiter['accountID']}' ";
    $result = mysqli_query($db, $sql);
    return $result;
}

function find_account_by_recruitee_id($id){
    global $db;
    $sql = "SELECT * FROM Recruitee WHERE recruiteeID = '{$id}' ";
    $result1 = mysqli_query($db, $sql);
    $recruitee = mysqli_fetch_assoc($result1);
    $sql = "SELECT * FROM Accounts WHERE accountID = '{$recruitee['accountID']}' ";
    $result = mysqli_query($db, $sql);
    return $result;
}

function update_recruitee($user){
    global $db;

    $sql = "UPDATE recruitee SET name = '{$user['name']}', dateOfBirth = '{$user['dateOfBirth']}', address = '{$user['address']}', phone = '{$user['phone']}', email = '{$user['email']}', experience = '{$user['experience']}', major = '{$user['major']}' 
            WHERE recruiteeID = '{$user['recruiteeID']}'";
    $result = mysqli_query($db, $sql);
    return confirm_query_result($result);
}

?>