<?php
require_once('../../lib/database.php');
require_once('../../lib/initialize.php');

$id = $_GET['id'];
$recruitment = find_recruitment_by_post_and_user_id($_SESSION['userID'], $id);
$details = mysqli_fetch_assoc($recruitment);
$CVpath = "CV/".$details['CV'] ;
unlink($CVpath);
delete_recruitment_by_recruitee_and_post_id($_SESSION['userID'], $id);

redirect_to('recruitmentList.php');
?>

<?php
db_disconnect($db);
?>