<?php
include_once dirname(dirname(__FILE__)) . '/include/forms.inc.php';
include($_SERVER['DOCUMENT_ROOT'] . '/wp-load.php');
get_header();

if(isset($_SESSION['id']))
	$user_id = $_SESSION['id'];
else
{
	print "You are not logged in.";
	show_footer();
	exit;
}

$class = $_SESSION['class'];

$target_dir = "../images/profiles/";
$target_file = $target_dir . $user_id . "." . jpg;
$uploadOk = 1;
$imageFileType = strtolower(pathinfo(basename( $_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg") {
    echo "Sorry, only jpg files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}

?>
<br>
<img src="/images/profiles/<?php echo $user_id; ?>.jpg" width="333" height="500" />