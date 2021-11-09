<?php
function uploadImage($file)
{
    $message = '';
    $target_dir = "uploads/";
    $uploadOk = 0;
    $imageFileType = strtolower(pathinfo(basename($file["name"]), PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    try {
        $check = getimagesize($file["tmp_name"]);
    } catch (Error $error) {
        $message = "File is not an image";
        $uploadOk = 1;
    }

    if ($check !== false) {
        $message = "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $message = "File is not an image.";
        $uploadOk = 0;
    }

    $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    // Check if file already exists
    while (file_exists($target_file)) {
        $target_file = $target_dir . uniqid() . '.' . $imageFileType;
    }

    // Check file size
    if ($file["size"] > 500000) {
        $message = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if (
        $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif"
    ) {
        $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
    } else {
        if (move_uploaded_file($file["tmp_name"], $target_file)) {
            $message = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $target_file;
            $uploadOk = 1;
        } else {
            $message = "Sorry, there was an error uploading your file.";
            $uploadOk = 0;
        }
    }

    return [
        "success" => $uploadOk,
        "message" => $message
    ];
};
// print_r($_POST);
header('Content-Type: application/json; charset=utf-8');
$data = uploadImage($_FILES['image']);
echo json_encode($data);
