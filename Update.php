<?php
include'includes/dbh.inc.php';

$id = "";
$firstname = "";
$familyname = "";
$email = "";

if(isset($_GET["id"])) 
{
    $id = $_GET["id"];
    $abfrage = "select id,firstname,familyname,email from students where id = '$id'";
    $ergebnis = mysqli_query($conn,$abfrage);

    while($row = mysqli_fetch_assoc($ergebnis))
    {
        $firstname = $row["firstname"];
        $familyname = $row["familyname"];
        $email = $row["email"];
    }
}
?>

<?php

if(isset($_POST["submit"]))
{
    $id = $_POST["id"];
    $firstname = $_POST["fname"];
    $familyname = $_POST["famname"];
    $email = $_POST["email"];
    
    $abfrage = "UPDATE students SET firstname = '$firstname', familyname = '$familyname', email='$email' where id = '$id';";

    $ergebnis = mysqli_query($conn,$abfrage);

    header("Location: HomeIndex.php");
}
?>


<?php
include 'HomeHeader.php';
?>

<form action="Update.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <table border="1">
        <tr>
            <td><label>Firstname:</label><input type="text" name="fname" value="<?php echo $firstname; ?>"></td>
            <td><label>Familyname:</label><input type="text" name="famname" value="<?php echo $familyname; ?>"></td>
            <td><label>Email</label><input type="text" name="email" value="<?php echo $email; ?>"></td>
        </tr>
       
    </table>

    <input type="submit" name="submit" value="Update">
</form>

</body>
</html>