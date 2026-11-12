<?php
include'includes/dbh.inc.php';

$id = "";
$firstname ="";
$familyname ="";

if(isset($_GET['id'])){

    $id = $_GET['id'];
    $anfrage = "select id,firstname,familyname,email from students where id = '$id'";
    $ergebnis = mysqli_query($conn,$anfrage);

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
    $sql ="DELETE FROM students WHERE id='$id';";
    mysqli_query($conn,$sql) or die("Error: " . mysqli_error($conn));

    echo "id = [$id], rows deleted: " . mysqli_affected_rows($conn);
    header("location:HomeIndex.php");
    exit;
}
?>


<?php
include 'HomeHeader.php';
?>

<form action="Delete.php" method="POST">
    <input type="hidden" name="id" value="<?php echo $id; ?>">

    <table border="1">
        <tr>
            <td><label>Firstname:</label><input type="text" name="fname" value="<?php echo $firstname; ?>"></td>
            <td><label>familyname:</label><input type="text" name="famname" value="<?php echo $familyname; ?>"></td>
        </tr>
       
    </table>

    <input type="submit" name="submit" value="delete">
</form>

</body>
</html>