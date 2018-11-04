<?php require '../includes/header.php' ?>

<div class="container">
    <form id="login" action="./login.php" method="post" class="border border-primary mt-5 p-3">
        <div class="form-group">
            <label for="username">User Name</label>
            <input type="text" name="username" class="form-control" id="username" placeholder="Enter User Name" maxlength="30" required/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" maxlength="30" required />
        </div>
        <input type="submit" value="Login" name="Login" class="btn btn-primary">
    </form>

    <?php
    // DB authentication
    require("../includes/dbinfo.inc");

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        $connect = mysqli_connect($hostDB, $userDB, $passwordDB, $databaseDB);
        if(mysqli_connect_errno()){
            die("Failed to connect to the database " . mysqli_connect_errno());
        }

        $query = "SELECT * FROM login ";
        $query .= "WHERE userName = '$username' AND password = '$password'";

        $result = mysqli_query($connect, $query);
        if(!$result){
            die('Error cannot execute a query');
        }

        $loggedInUser=null;
        $userToken = null;
        while ($row= mysqli_fetch_assoc($result)) {
            $loggedInUser= $row["userName"];
            $userToken= $row["userToken"];
            break; // to be save
        }

        mysqli_free_result($result);
        mysqli_close($connect);

        echo "<pre class=\"border mt-5 p-3 bg-light\">";
        echo "Server data:</br>";
        echo "username: $username</br>";
        echo "password: $password</br>";
        echo "query: " . $query . "</br>";
        if (!empty($loggedInUser)) {

            $_SESSION["username"] = $loggedInUser;

            echo "</br><div class=\"alert alert-success\">Database Message: The user $loggedInUser was logged in successfully";
            echo "</br></br><a class=\"btn btn-success\" href='myAccount.php?userToken=$userToken'> My Account</a>";
            echo "</div>";

        }else{
            echo "</br><div class=\"alert alert-danger\">Database Message: Fail login</div>";
        }
        echo "</pre>";
    }
    ?>
</div>
</body>
</html>