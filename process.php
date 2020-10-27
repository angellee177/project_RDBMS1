<?php 

session_start();

$host    = 'localhost';
$usrname = 'root';
$pwd     = '';
$dbname  = 'project_CRUD';

// Object Oriented Programming style
// $mysqli = new mysqli($host, $usrname, $pwd, $dbname) or die(mysqli_error($mysqli));

try{
    $mysqli = new mysqli($host, $usrname, $pwd, $dbname);
    echo "Success to connect to database";
}catch(Exception $e){
    echo "Failed to connect to Database" . $e->getMessage();
}

$id        = 0;
$update    = false;
$title     = '';
$author    = '';
$year      = '';
$publisher = '';


// Save data Function
if(isset($_POST['save'])) {
    $judul_buku = $_POST['title'];
    $author     = $_POST['author'];
    $year       = $_POST['year'];
    $publisher  = $_POST['publisher'];

    $mysqli->query("INSERT INTO Books (title, author, year, publisher) VALUES('$judul_buku', '$author', '$year', '$publisher')") or die($mysqli->error);

    $_SESSION['message']    = "Record has beend saved!";
    $_SESSION['msg_type']   = "success";

    header("location: index.php");
}


// Delete data Function 
if(isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $mysqli->query("DELETE FROM Books WHERE id=$id") or die($mysqli->error());

    $_SESSION['message']  = "Record has been deleted!";
    $_SESSION['msg_type'] = "danger";

    header("location: index.php");
}


// Get data by ID Function
if(isset($_GET['id'])) {

    $id     = $_GET['id'];
    $update = true;
    $result = $mysqli->query("SELECT * FROM Books WHERE id=$id") or die($mysqli->error());

    if($result->num_rows){
        $row       = $result->fetch_array();
        $title     = $row['title'];
        $author    = $row['author'];
        $year      = $row['year'];
        $publisher = $row['publisher'];
    }
}


// Update data by ID Function
if(isset($_POST['update'])) {
    
    $id        = $_POST['id'];
    $title     = $_POST['title'];
    $author    = $_POST['author'];
    $year      = $_POST['year'];
    $publisher = $_POST['publisher']; 

    $mysqli->query("UPDATE Books SET title='$title', author='$author', year='$year', publisher='$publisher' WHERE id=$id ") or
        die($mysqli->error());

    $_SESSION['message']  = 'Record has been updated!';
    $_SESSION['msg_type'] = 'warning';

    header("location: index.php");
}