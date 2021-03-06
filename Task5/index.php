<?php

session_start();

//////// Connection db /////////
require "helpers/conn.php";

if ($_SERVER['REQUEST_METHOD']=='POST') {
            $searchKey = $_POST['search'];
            $sql = "SELECT * FROM post WHERE title LIKE '%$searchKey%' or content LIKE '%$searchKey%' ";
        }else{
            $sql = "SELECT * FROM post";
            $searchKey="";
        }
         $allData = mysqli_query($conn, $sql);



////// Header of Project /////////
require "helpers/header.php";

?>

<body class="all">
  <h1> Posts </h1>
  <a href="createPost.php" style="display: block;"><button type="button" class="btn btn-secondary">Create Post</button></a>

  <?php


  if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-primary" role="alert">'
      . $_SESSION['message'] .
      '</div>';

    unset($_SESSION['message']);
  }
  ?>
  <form class="d-flex " id="search" method="POST" action="<?php echo   htmlspecialchars($_SERVER['PHP_SELF']) ?>">
           <input class="form-control me-2" type="search" placeholder="Search By Full Name" aria-label="Search" name="search" value="<?php echo $searchKey ?>">
           <button class="btn btn-dark" type="submit" name="submit">Search</button>
        </form>
  
  <table class="table table-striped table-hover">
    <thead>
      <tr>
        <th scope="col">Id</th>
        <th scope="col">Title</th>
        <th scope="col">Content</th>
        <th scope="col">Date</th>
        <th scope="col">Image</th>
        <th scope="col">Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      while ($row = mysqli_fetch_assoc($allData)) {
      ?>
        <tr>
          <th><?php echo $row['id']; ?></th>
          <td><?php echo $row['title']; ?></td>
          <td><?php echo $row['content']; ?></td>
          <td><?php echo $row['date']; ?></td>
          <td><img style="width: 100px; height:100px" src="<?php echo $row['img_dir']; ?>"></td>
          <td>
            <a href="edite.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-secondary">Edit</button></a>
            <form action="delete.php" method="POST" style="display: inline;">
              <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
              <input type="hidden" name="img_dir" value="<?php echo $row['img_dir']; ?>">
              <button type="submit" class="btn btn-danger">Delete</button>
            </form>
          </td>
        </tr>

      <?php
      }
      ?>

    </tbody>
  </table>

  <?php
  require "helpers/footer.php";
  ?>