<?php
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'test');

// Uploads files
if (isset($_POST['save'])) { // if save button on the form is clicked
    // name of the uploaded file
    $filename = $_FILES['myfile']['name'];
    $pdffilename = $_FILES['mypdffile']['name'];
    // destination of the file on the server
    $destination = 'upload/' . $filename;
    $destination1 = 'upload/' . $pdffilename;
    

    // get the file extension
    $extension = pathinfo($filename, PATHINFO_EXTENSION);
    $extension1 = pathinfo($pdffilename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
    $file = $_FILES['myfile']['tmp_name'];
    $pdffile = $_FILES['mypdffile']['tmp_name'];
    $size = $_FILES['myfile']['size'];

    if (!in_array($extension, ['png','jpg']) || !in_array($extension1, ['zip', 'pdf', 'docx']) ) {
        echo "You file extension must be .png, .jpg .zip, .pdf or .docx";
    } elseif (($_FILES['myfile']['size'] > 1000000) || ($_FILES['mypdffile']['size'] > 3000000)) { // file shouldn't be larger than 1 and 3Megabyte
        echo "File too large!";
    } else {
        // move the uploaded (temporary) file to the specified destination
        if (move_uploaded_file($pdffile, $destination1) and  move_uploaded_file($file, $destination) ) {
            $sql = "INSERT INTO users1 (pdf, main_image) VALUES ('$pdffilename','$filename')";
            if (mysqli_query($conn, $sql)) {
                echo "File uploaded successfully";
            }
        } else {
            echo "Failed to upload file.";
        }
    }
}

// Downloads files
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // fetch file to download from database
    $sql = "SELECT * FROM users1 WHERE file_id=$id";
    $result = mysqli_query($conn, $sql);

    $file = mysqli_fetch_assoc($result);
    $filepath = 'upload/' . $file['name'];

    if (file_exists($filepath)) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename=' . basename($filepath));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize('upload/' . $file['name']));
        readfile('upload/' . $file['name']);

        // Now update downloads count
       # $newCount = $file['downloads'] + 1;
       # $updateQuery = "UPDATE users1 SET downloads=$newCount WHERE id=$id";
      #  mysqli_query($conn, $updateQuery);
       # exit;
    }

}