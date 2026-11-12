<?php
include 'HomeHeader.php';
?>

<div class="container" id="signup">        
    <h2>Register</h2>
    <form method="post" action="insert.php">

 
    <div class="input-groups1">
            <input type="text" name="fname" id="fname" placeholder="First-Name" required>
            <label for="fname">First-Name</label>
    </div>
   

    <div class="input-groups2">  
            <input type="text" name="famname" id="famname" placeholder="Family-Name" required>
            <label for="famname">Family-Name</label>   
    </div>

    <div class="input-groups3">
            <input type="email" id="email" name="email" placeholder="Email" required>
            <label for="email">Email</label>
    </div>

    <input type="submit" name="submit" class="btn" value="submit">
    </form>
</div>


</body>
</html>