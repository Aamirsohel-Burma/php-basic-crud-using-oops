<?php
include "./includes/cn.php";
$conn = new Database();

$name = $image = $id = "";

/** Create user table if not exists */
$table_name = 'tbl_user';
$columns = array(
    "id" => "INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY",
    "name" => "VARCHAR(30) NOT NULL",
    "image" => "VARCHAR(50)",
    "created_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP",
    "updated_at" => "TIMESTAMP DEFAULT CURRENT_TIMESTAMP"
);
$conn->createTable($table_name, $columns);

/** Fetch user data from database */
$userData = $conn->read($table_name);

/** Create user data */
if (isset($_POST['submit'])) {

    include "./includes/file-upload.php";
    $name = $_POST['name'];
    $image = $_FILES['image'];

    $data = array(
        "name" => $name
    );
    $uploadedFile = "";
    /** If image exists than upload */
    if (file_exists($image['tmp_name'])) {
        $allowedExtension = array("png", "jpg", "jpeg", "gif");
        $uploader = new FileUploader('./assets/images/', $allowedExtension);
        $uploadedFile = $uploader->upload($image);
        $data['image'] = $uploadedFile;
    }
    $conn->create($table_name, $data);
    header("Location:" . $_SERVER['PHP_SELF']);
}

/** Delete user data */
if (isset($_POST['delete'])) {
    $where = array(
        "id" => $_POST['delete']
    );
    $conn->delete($table_name, $where);
    header("Location:" . $_SERVER['PHP_SELF']);
}

/** Fetch data for edit */
if (isset($_POST['edit'])) {
    $where = array(
        "id" => $_POST['edit']
    );
    $singleUserData = $conn->read($table_name, $where);
    $name = $singleUserData[0]["name"];
    $image = $singleUserData[0]["image"];
    $id = $singleUserData[0]["id"];
}

/** Update user data */
if (isset($_POST['update'])) {
    include "./includes/file-upload.php";
    $previous_image = $_POST['previous_image'];
    
    $name = $_POST['name'];
    $id = $_POST['id'];
    $image = $_FILES['image'];

    $updateData = array(
        "name" => $name,
        "updated_at" => date('Y-m-d H:i:s')
    );

    $uploadedFile = "";
    /** If image exists than upload */
    if (file_exists($image['tmp_name'])) {
        unlink('./assets/images/' . $previous_image);
        $allowedExtension = array("png", "jpg", "jpeg", "gif");
        $uploader = new FileUploader('./assets/images/', $allowedExtension);
        $uploadedFile = $uploader->upload($image);
        $updateData['image'] = $uploadedFile;
    }
    $where = array(
        "id" => $id
    );
    $conn->update($table_name, $updateData, $where);
    header("Location:" . $_SERVER['PHP_SELF']);
}
