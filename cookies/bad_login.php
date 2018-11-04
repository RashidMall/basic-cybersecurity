<?php
// Database Authentication
require("../includes/dbinfo.inc");

if(isset($_POST['userName']) && isset($_POST['password'])){
    $userName = $_POST['userName'];
    $password = $_POST['password'];
}

//Not secure post call
if(!empty($userName) and !empty($password)) {
    //connect to database
    $connect = mysqli_connect($hostDB, $userDB, $passwordDB, $databaseDB);
    if(mysqli_connect_errno()){
        die("Error cannot execute a query ". mysqli_connect_error());
    }

    $query ="SELECT * FROM login  WHERE userName='" .
        $userName ."' AND password='" . $password ."'" ;

    $result= mysqli_query($connect,$query);
    if (!$result){
        die('Error cannot execute a query');
    }

    $loggedInUser=null;
    while ($row= mysqli_fetch_assoc($result)) {
        $loggedInUser= $row["userName"];
        break;
    }

    setcookie('userName', $loggedInUser, false, "/", false);

    mysqli_free_result($result);
    mysqli_close($connect);
}

?>
<?php require '../includes/header.php'?>
<div class="container">
    <form id="login" action="./bad_login.php" method="post" class="border border-primary mt-5 p-3">
        <div class="form-group">
            <label for="userName">User Name</label>
            <input type="text" name="userName" class="form-control" id="userName" placeholder="Enter User Name" maxlength="30" required/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" maxlength="30" required />
        </div>
        <input type="submit" value="Login" name="Login" class="btn btn-primary">
    </form>
    <?php

    if(!empty($userName) and !empty($password)) {
        echo "<pre>";
        echo "Server data:</br>";
        echo "username: " . $userName . "</br>";
        echo "password: " . $password . "</br>";
        echo "query: " . $query . "</br>";
        if (!empty($loggedInUser)) {

            echo "</br><div class=\"alert alert-success\">Database Message: The user $loggedInUser was logged in successfully";
            echo "</br></br><a class=\"btn btn-success\" href='bad_myAccount.php'> My Account</a>";
            echo "</div>";

        } else {
            echo "</br><div class=\"alert alert-danger\">Database Message: Fail login</div>";
        }
        echo "</pre>";
    }
    ?>

</div>
</body>
</html>