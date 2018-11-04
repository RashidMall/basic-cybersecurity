<?php require '../includes/header.php'?>

<div class="container">
    <form id='login' action="myAccount.php?userToken=<?= $_GET['userToken'];?>" method='post' accept-charset='UTF-8'>
        <div class="panel panel-primary">
            <div class="panel-heading">Send Money</div>
            <div class="panel-body">
                <div class="form-group">
                    <label for='ToUserName' >To UserName*:</label>
                    <input type='text' name='ToUserName' id='ToUserName'  maxlength="50" required />
                    <label for='Amount' >Amount:</label>
                    <input type='text' name='Amount' id='Amount' maxlength="50" required />

                <input type='submit' class="btn btn-default" name='Submit' id='submit' value='Send' />
                </div>
            </div>
        </div>

    </form>

    <div class="transactions">
        <h1>Transactions</h1>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td scope="col"> Transaction Key </td>
                    <td scope="col"> From </td>
                    <td scope="col"> To</td>
                    <td scope="col"> Amount</td>
                </tr>
            </thead>
            <tbody>

                <?php
                require("../includes/dbinfo.inc");

                // Connect to db
                $connect = mysqli_connect($hostDB, $userDB, $passwordDB, $databaseDB);
                if(mysqli_connect_errno()){
                    die("Failed to connect to the database ". mysqli_connect_error());
                }

                $userToken = $_GET['userToken'];

                // Get user name from token
                $query = "SELECT userName FROM login WHERE userToken='$userToken'";
                $result = mysqli_query($connect,$query);
                if (!$result){
                    die('Error cannot execute a query');
                }

                $userName = null;
                while ($row = mysqli_fetch_assoc($result)) {
                $userName = $row["userName"];
                break;
                }

                // Add new transaction
                if(!empty($userName) && !empty($_POST['ToUserName'])) {

                    $query ="INSERT INTO activities(fromUserName, ToUserName, Amount)
                        VALUES ('".$userName ."','".$_POST['ToUserName'] ."',".$_POST['Amount'] .")";

                    $result= mysqli_query($connect,$query);
                    if (!$result){
                        die('Error cannot execute a query');
                    }
                }

                // Get user transactions
                if( !empty($userName)) {
                    $query ="SELECT * FROM activities  WHERE fromUserName = '$userName' OR ToUserName = '$userName'" ;
                    $result= mysqli_query($connect,$query);
                    if (!$result){
                        die('Error cannot execute a query');
                    }

                    $userInfo=array();
                    $loginInUser=null;
                    while ($row= mysqli_fetch_assoc($result)) {
                        $rowColor ="class='table-success'";
                        if($row["fromUserName"]==$userName){
                            $rowColor ="class='table-danger'";
                        }
                        echo "<tr $rowColor>";
                        echo "<td>". $row["transactionKey"] ."</td>";
                        echo "<td>". $row["fromUserName"] ."</td>";
                        echo "<td>". $row["ToUserName"]."</td>";
                        echo "<td>". $row["Amount"]."</td>";
                        echo "</tr>";
                    }
                    mysqli_free_result($result);
                }
                mysqli_close($connect);
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>