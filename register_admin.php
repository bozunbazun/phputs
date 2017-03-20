<?php
    $errors = array();
    if ($_POST)
    {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $fullname = $_POST["fullname"];
        $email = $_POST["email"];
        $gender = $_POST["gender"];
        
        //validasi
        if (strlen(trim($username)) < 3)
            array_push($errors, "Username must be at least 3 Characters");
        if (strlen(trim($password)) < 6)
            array_push($errors, "Password must be at least 6 Characters");
        if (strlen(trim($fullname)) == 0)
            array_push($errors, "Full Name must be filled");
        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            array_push($errors, "Invalid email");
        
        //register jika tidak ada error
        if (count($errors) == 0)
        {            
            //echo "<script>alert('Success!');</script>";
            //cara include "..." include("...")
            //required "..." required("...")
            //required_once "..."
            require_once "database.php";
            $db = new UserDB();
            if ($db->insert($username, $password, $fullname, $email, $gender))
            {
                //echo "<script>alert('Success!');</script>";
                //katanya tidak boleh ada apa2 di atas header klo ndak error, jdi pke javascript
                header("Location: login.php");
                exit();
            }
            else
            {
                echo "<script>alert('Gagal!');</script>";
            }
        }
    }
?>

<html>
    <head>
        <title>Register</title>
    </head>
    <body>
        <h1>Register</h1>
        <?php
            if (count($errors) > 0)
            {
                echo "<font color='red'>";
                foreach ($errors as $e)
                {
                    echo "<li>$e</li>";
                }
                echo "</ul></font>";
            }
        ?>
        
        <form method="post" action="register.php">
            Username
            <input type="text" name="username">
            <br>
            Password
            <input type="password" name="password">
            <br>
            Full Name
            <input type="text" name="fullname">
            <br>
            E-mail
            <input type="email" name="email">
            <br>
            Gender
            <select name="gender">
                <option value="M">Male</option>
                <option value="F">Female</option>
            </select>
            <br>
            <input type="submit" name="submit" value="Register">
        </form>
    </body>
</html>