<?php include 'upload.php';

$sql = "SELECT * FROM users1";
$result = mysqli_query($conn, $sql);

$files = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <link rel="stylesheet" href="style.css">
    <title>Files Upload and Download</title>
    <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }

        tr:nth-child(even) {
        background-color: #dddddd;
        }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="row">
        <form action="index.php" method="post" enctype="multipart/form-data" >
          <h3>Upload File </h3>
        PDF:   <input type="file" name="mypdffile"> <br>
        Image:  <input type="file" name="myfile"> <br>
          <button type="submit" name="save">upload</button>
        </form>
      </div>
      <br/>
      <br/>
      <div class="row">
      <table>
        <thead>
            <th>ID</th>
            <th>PDF Filename</th>
            <th>Image Filename</th>
            <th>Download Filename</th>
        </thead>
        <tbody>
        <?php foreach ($files as $file): ?>
            <tr>
            <td><?php echo $file['file_id']; ?></td>
            <td><?php echo $file['pdf']; ?></td>
            <td><?php echo $file['main_image']; ?></td>
            <td><a href="index.php?id=<?php echo $file['file_id'] ?>">Download</a></td>
            </tr>
        <?php endforeach;?>

        </tbody>
        </table>
      </div>
    </div>
  </body>
</html>