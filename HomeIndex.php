<?php
include'HomeHeader.php';
?>



<table border="1">
    <tr>
        <td>ID</td>
        <td>First-Name</td>
        <td>Family-Name</td>
        <td>Email</td>
        
    </tr>

    <?php 
    
    while($row = mysqli_fetch_assoc($ergebnis)) 
        {
        ?>

        <tr>

            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row ['firstname']?></td>
            <td><?php echo $row ['familyname']?></td>
            <td><?php echo $row ['email']?></td>

            <td><a href="Delete.php?id=<?php echo $row["id"]; ?>">Delete</a></td>
            <td><a href="Update.php?id=<?php echo $row["id"]; ?>">Update</a></td>
        </tr>

       <!-- <?php
        var_dump($row);
        ?> -->

        <?php
        }
    ?>

</table>

</body>
</html>