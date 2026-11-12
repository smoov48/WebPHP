# WebPHP

# PHP + MySQL Student List (CRUD) with XAMPP

A small beginner project: add, list, update and delete students using PHP, MySQL and HTML.

---

## 1. Install XAMPP and start Apache and MySQL

1. Download XAMPP from **https://www.apachefriends.org** and run the installer with the default components. On Windows, install to `C:\xampp`.
2. Open the **XAMPP Control Panel**.
3. Click **Start** next to **Apache** and next to **MySQL**. Both should turn green.
4. Open **http://localhost** in your browser. You should see the XAMPP welcome page.

> If Apache won't start, another program is using port 80 (for example Skype). Close it, or change `Listen 80` to `Listen 8080` in **Config → httpd.conf** and use `http://localhost:8080`.

## 2. Put the project in htdocs

Copy or clone this repository into XAMPP's web folder:

```bash
cd C:\xampp\htdocs
git clone https://github.com/YOUR-USERNAME/YOUR-REPO.git PhpMyAdminWeb
```

Or download the ZIP from GitHub (**Code → Download ZIP**) and unzip it to `C:\xampp\htdocs\PhpMyAdminWeb`.

The folder must look like this:

```
htdocs/PhpMyAdminWeb/
├── HomeHeader.php
├── HomeIndex.php
├── HomeForm.php
├── insert.php
├── Update.php
├── Delete.php
├── HomeHeader.css
├── HomeForm.css
├── HomeIndex.css
└── includes/
    └── dbh.inc.php
```

## 3. Create the database and the students table in phpMyAdmin

1. Open **http://localhost/phpmyadmin**.
2. Click **New**, enter the name `school_db` and click **Create**.
3. Select `school_db`, open the **SQL** tab, paste this and click **Go**:

```sql
CREATE TABLE `students` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `firstname` VARCHAR(100) NOT NULL,
  `familyname` VARCHAR(100) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
```

4. Optional test data:

```sql
INSERT INTO `students` (`firstname`, `familyname`, `email`) VALUES
('Max', 'Mustermann', 'max.mustermann@example.com'),
('Anna', 'Schmidt', 'anna.schmidt@example.com'),
('Lukas', 'Weber', 'lukas.weber@example.com');
```

## 4. The full code for every file

### `includes/dbh.inc.php`

```php
<?php

$serverName = "localhost";
$userName = "root";
$dbPwd = "";
$dbName = "school_db";

$conn = mysqli_connect($serverName, $userName, $dbPwd, $dbName);

if(!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
```

`root` with an empty password is the XAMPP default. `$dbName` must match the database from step 3.

### `HomeHeader.php`

```php
<?php
include_once 'includes/dbh.inc.php';
$abfrage = "select id, firstname, familyname, email from students";
$ergebnis = mysqli_query($conn,$abfrage);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student List</title>
    <link rel="stylesheet" href="HomeHeader.css">
    <link rel="stylesheet" href="HomeForm.css">
    <link rel="stylesheet" href="HomeIndex.css">
</head>
<body>
    <header>
        <h1>Students Information</h1>
        <nav>
            <a class="login-link" href="HomeIndex.php">People List</a>
            <a class="login-link" href="HomeForm.php">Add Person</a>
        </nav>
    </header>
```

### `HomeIndex.php` (list)

```php
<?php
include 'HomeHeader.php';
?>

<table border="1">
    <tr>
        <td>ID</td>
        <td>First-Name</td>
        <td>Family-Name</td>
        <td>Email</td>
        <td>Delete</td>
        <td>Update</td>
    </tr>

    <?php
    while($row = mysqli_fetch_assoc($ergebnis))
    {
    ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['firstname']; ?></td>
            <td><?php echo $row['familyname']; ?></td>
            <td><?php echo $row['email']; ?></td>
            <td><a href="Delete.php?id=<?php echo $row['id']; ?>">Delete</a></td>
            <td><a href="Update.php?id=<?php echo $row['id']; ?>">Update</a></td>
        </tr>
    <?php
    }
    ?>
</table>

</body>
</html>
```

### `HomeForm.php` (add)

```php
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
```

### `insert.php` (add)

```php
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
    exit;
}
?>
```

### `Update.php` (update)

```php
<?php
include 'includes/dbh.inc.php';

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
    exit;
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
            <td><label>Email:</label><input type="text" name="email" value="<?php echo $email; ?>"></td>
        </tr>
    </table>

    <input type="submit" name="submit" value="Update">
</form>

</body>
</html>
```

### `Delete.php` (delete)

```php
<?php
include 'includes/dbh.inc.php';

$id = "";
$firstname = "";
$familyname = "";

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $anfrage = "select id,firstname,familyname,email from students where id = '$id'";
    $ergebnis = mysqli_query($conn,$anfrage);

    while($row = mysqli_fetch_assoc($ergebnis))
    {
        $firstname = $row["firstname"];
        $familyname = $row["familyname"];
    }
}
?>

<?php
if(isset($_POST["submit"]))
{
    $id = $_POST["id"];
    $sql = "DELETE FROM students WHERE id='$id';";
    mysqli_query($conn,$sql);

    header("location: HomeIndex.php");
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
            <td><label>Familyname:</label><input type="text" name="famname" value="<?php echo $familyname; ?>"></td>
        </tr>
    </table>

    <input type="submit" name="submit" value="delete">
</form>

</body>
</html>
```

### `HomeHeader.css`

```css
body {
    margin: 0;
    padding: 0;
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}

header {
    background-color: rgb(201, 133, 85);
    padding: 20px;
    display: flex;
    justify-content: space-between;
}

nav {
    display: flex;
    align-items: center;
}

li {
    display: inline-block;
    list-style: none;
}

.login-link {
    text-decoration: none;
    margin: 10px;
    padding: 16px 16px;
    background-color: white;
    color: black;
    transition: background-color 300ms ease-in-out;
}

.login-link:hover {
    background-color: rgba(255, 250, 250, 0.658);
}
```

### `HomeIndex.css`

```css
body {
    font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
}
```

### `HomeForm.css`

Create this file and leave it empty.

## 5. How to run it, and troubleshooting

1. Make sure **Apache** and **MySQL** are green in the XAMPP Control Panel.
2. Open **http://localhost/PhpMyAdminWeb/HomeIndex.php** (use your own folder name).
3. Try all four functions: **Add Person**, the list, **Update**, **Delete**.

Always open the project through `http://localhost/...`. If the address starts with `file://`, PHP does not run.

| Problem | Likely cause and fix |
|---------|----------------------|
| `Not Found` | The file is not in `htdocs/PhpMyAdminWeb/` or the name is spelled differently. Check the address bar. |
| PHP code is shown as text | You opened the file directly (`file://`). Use `http://localhost/...`. |
| `Connection failed` / `Unknown database` | MySQL is not started, or `$dbName` in `dbh.inc.php` doesn't match the database in phpMyAdmin. |
| `Failed to open stream: includes/dbh.inc.php` | The `includes` folder or the file name is wrong. |
| `Table '...students' doesn't exist` | Run the `CREATE TABLE` SQL from step 3 in the correct database. |
| Insert redirects but nothing is saved | Check the table name in `insert.php` (`students`, with an s). Use `mysqli_query($conn,$sql) or die(mysqli_error($conn));` to see the SQL error. |
| Update or Delete shows empty fields, or `id = []` | The page was opened without `?id=...`. Click the link from the list instead of typing the address. |
| Update saves blank values | The update code must read `fname`, `famname` and `email` from `$_POST`, and the input `name="..."` must match exactly. |
| `Undefined variable` warning | A variable was never set. Set a default (`$id = "";`) before the `if`. |
| MySQL won't start | Port 3306 is used by another MySQL install. Stop that service or change the port in XAMPP's `my.ini`. |

Useful debugging lines:

```php
var_dump($_POST);                                     // shows what a form sent
var_dump($_GET);                                      // shows what the URL sent
mysqli_query($conn,$sql) or die(mysqli_error($conn)); // shows SQL errors
```
