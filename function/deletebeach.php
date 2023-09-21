<?php
session_start();

if ($_SESSION['role'] == "user") {
    header('location: index.php');
    exit();
}
$conn = connect();

if(isset($_GET['id'])){
    $id = ($_GET['id']);
    try{
        $sql = "DELETE FROM beaches WHERE id = $id";
        $conn->query($sql);
    }catch(Exception $ex){
        echo $ex->getMessage();
    };
    echo '<script>alert("Beach has been deleted successfully.");</script>';
    header('location: admin.php');
    exit();
}else{
    header('location: admin.php');
    exit();
}