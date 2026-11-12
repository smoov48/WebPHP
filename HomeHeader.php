<?php
include 'includes/dbh.inc.php';
$abfrage = "select id, firstname, familyname, email from students";
$ergebnis = mysqli_query($conn,$abfrage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FirstPHPSite</title>
    <link rel="stylesheet" href="HomeHeader.css">
    <link rel="stylesheet" href="HomeForm.css">
    <link rel="stylesheet" href="HomeIndex.css">
   
</head>
<body>
    <header>
        <h1>Students Information</h1>
        <nav>
            <a class="login-link" href="Delete.php">Remove People</a>
            <a class="login-link" href="HomeIndex.php">People List</a>
            <a class="login-link" href="HomeForm.php">Add Person</a>
            <a class="login-link" href="Update.php">Update</a>

        </nav>
    </header>
