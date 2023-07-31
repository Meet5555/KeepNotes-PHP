<?php 
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "notes";
    $insert = false;
    $update = false;
    $delete = false;
    
    $conn = mysqli_connect($servername,$username,$password,$database);

    if(!$conn){
      echo "Connection was not succesfull because of this error: " . mysqli_connect_error();
    }
    if(isset($_GET['delete'])){
      $sno = $_GET['delete'];
      $sql = "DELETE FROM `notes` WHERE `notes`.`sno` = $sno";
      $result = mysqli_query($conn,$sql);
      $delete = true;
    }
    else{
      $delete = false;
    }
    if($_SERVER['REQUEST_METHOD'] == "POST"){
      if(isset($_POST['snoEdit'])){
        $title = $_POST['titleEdit'];
        $description = $_POST['descriptionEdit'];
        $snoEdit = $_POST['snoEdit'];
        $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$description' WHERE `notes`.`sno` = $snoEdit";
        $result = mysqli_query($conn,$sql);
        if($result){
          $update = true;
        }
        else{
          $update = false;
        }
      }
      else{        
        $title = $_POST['title'];
        $description = $_POST['description'];
        $sql = "INSERT INTO `notes` (`sno`, `title`, `description`, `tstamp`) VALUES (NULL, '$title', '$description', current_timestamp())";
        $result = mysqli_query($conn,$sql);
        if($result){
          $insert = true;
        }
        else{
          $insert = false;
        }
      }
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous" />
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <title>KeepNotes - if hard to Remember</title>
</head>

<body>
  <!-- Edit modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal">
  Edit Modal
</button> -->

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModalLabel">Edit Note</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form class="my-3" method="post" action="/CRUD/index.php">
          <input type="hidden" name="snoEdit" id="snoEdit">
          <div class="form-group">
              <label for="titleEdit">Note Title</label>
              <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="emailHelp" />
          </div>
          <div class="form-group">
              <label for="descriptionEdit">Note Description</label>
              <textarea class="form-control" id="descriptionEdit" name="descriptionEdit" rows="3"></textarea>
          </div>

          <button type="submit" class="btn btn-info">Updat Note</button>
      </form>
      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>

    <nav class="navbar navbar-expand-lg navbar-dark bg-info">
        <a class="navbar-brand" href="#">KeepNotes</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact Us</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" />
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
                    Search
                </button>
            </form>
        </div>
    </nav>

    <?php
      if($insert){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been inserted succesfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <?php
      if($delete){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been deleted succesfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <?php
      if($update){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
        <strong>Success!</strong> Your note has been updated succesfully.
        <button type='button' class='close' data-dismiss='alert' aria-label='Close'>
          <span aria-hidden='true'>&times;</span>
        </button>
      </div>";
      }
    ?>

    <div class="container my-4">
        <h5>Hard to remember? Don't worry!</h5>
        <h3>Add a Note here</h3>
        <form class="my-3" method="post" action="/CRUD/index.php">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="emailHelp" />
            </div>
            <div class="form-group">
                <label for="description">Note Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-info">Add Note</button>
        </form>
    </div>

    <div class="container my-4">
        <table class="table" id="myTable">
            <thead>
                <tr>
                    <th scope="col">S.No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
              <?php 
        
                $sql = "SELECT * FROM `notes`";
                $result = mysqli_query($conn,$sql);
                $count=0;
                while($row = mysqli_fetch_assoc($result)){
                  $count = $count+1;
                  echo "<tr>
                  <th scope='row'>". $count ."</th>
                  <td>". $row['title'] ."</td>
                  <td>". $row['description'] ."</td>
                  <td><button class='edit btn btn-sm btn-info' id=" .$row['sno'] .">Edit</button> <button class='delete btn btn-sm btn-info' id=d" .$row['sno'] .">Delete</button></td>
                  </tr>";
                } 
              ?>

            </tbody>
        </table>
    </div>
    <hr>
    <!-- Bootstrap JavaScript -->
    
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous">
    </script>
    <script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready( function () {
          $('#myTable').DataTable();
      } );
    </script>
    <script>
      let edits = document.getElementsByClassName("edit");
      Array.from(edits).forEach((element)=>{
        element.addEventListener('click',(e)=>{
          // console.log('edits');
          let tr = e.target.parentNode.parentNode;
          let title = tr.getElementsByTagName('td')[0].innerText;
          let description = tr.getElementsByTagName('td')[1].innerText;
          // console.log(title,description);
          titleEdit.value = title;
          descriptionEdit.value = description;
          $('#editModal').modal("toggle");  
          snoEdit.value = e.target.id;
          // console.log(e.target.id);
        })
      })

      let deletes = document.getElementsByClassName("delete");
      Array.from(deletes).forEach((element)=>{
        element.addEventListener('click',(e)=>{
          dsno = e.target.id.substr(1,);
          
          if(confirm("Are you sure you want to delete?")){
            console.log('yes',dsno);
            window.location = `/CRUD/index.php?delete=${dsno}`;
          }
          else{
            console.log('No');
          }
        })
      })
    </script>
</body>

</html>