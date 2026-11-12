<?php
include 'includes/dbh.inc.php';


if(isset($_POST["submit"]))
{

    $firstname = $_POST["fname"];
    $familyname = $_POST["famname"];
    $email = $_POST["email"];

    $sql = "INSERT INTO students (firstname, familyname, email) VALUES ('$firstname','$familyname','$email');";
        
    mysqli_query($conn,$sql);
    header("location: HomeIndex.php");


};

?>