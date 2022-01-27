<?php
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "cake_world";

    $connection = new mysqli($host, $user, $password, $dbname);

    if($connection->error){
        echo "Something wents wrong!";
    }

    session_start();

    if(isset($_POST['username'])) {
        $userName= mysqli_real_escape_string($connection,$_POST['username']);
        $password= md5(mysqli_real_escape_string($connection,$_POST['password']));

        $adminQuery="SELECT * FROM owner WHERE username='$userName' AND password='$password'";

        $location = "./index.php";

        if($connection->query($adminQuery) == TRUE) {
            $result = $connection->query($adminQuery);

            if($result->num_rows == 1){
                $_SESSION['userName'] = $userName;

                if(isset($_POST['keep_logged'])){
                    setcookie('userName', $userName, time() + 7*24*60*60);
                }
                header('Location: ' . $location);
            }
            else {
                echo "<span style='width: fit-content; border: 1px solid red; text-align: center;".
                " padding: 15px 20px'>username or password is wrong!<span> <br><br><br>";
            }
        }
    }

?>


<!DOCTYPE html>
<html>
    <head>
        <title>Cake World!</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }
            body {
                height: 100vh;
                width: 100vw;
                display: flex;
                align-items: center;
                flex-direction: column;
                justify-content: center;
            }
            .login-form {
                width: fit-content;
                border: 3px outset grey;
                padding: 35px 20px;
                box-shadow: 0 0 20px grey;
            }
            .name-group {
                margin: 25px 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .password-group {
                margin: 25px 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            .submit-group {
                margin: 25px 10px;
                display: flex;
                align-items: center;
                justify-content: space-between;
            }
            input {
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <form class="login-form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST">
            <div class="name-group">
                <label for="name">UserName: </label>
                <input type="text" id="name" name="username">
            </div>
            <div class="password-group">
                <label for="psd">Password: </label>
                <input type="password" id="psd" name="password">
            </div>
            <div class="submit-group">
                <input type="checkbox" name="keep_logged"> Keep me login for 7 days
                <input type="submit" value="Login">
            </div>
        </form>
    </body>
</html>