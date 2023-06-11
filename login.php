<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <h2>Login to Travel Site</h2>
    <form action="login.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username">
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password">
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input class="form-check-input" type="checkbox" name="remember"> Remember me
            </label>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">    
    </form>
</div>
    <?php
        session_start(); 
        require_once("classes.php");  
        if(isset($_POST['username']) && isset($_POST['password'])){
            $travelUser = new travelUser();
            $user = $travelUser->getLogin($_POST['username'], $_POST['password']);
            if($_POST['password'] == $user['Pass']){

                $_SESSION['userID'] = $user['UID']; 
                $_SESSION['name'] = $user['FirstName'] . " " . $user['LastName']; 
                $_SESSION['state'] = $user['State'];
                if(isset($_POST['remember'])){
                    setcookie('userID', $user['UID'], time() + (86400 * 30), "/");
                    setcookie('name', $user['FirstName'] . " " . $user['LastName'], time() + (86400 * 30), "/");
                    setcookie('state', $user['State'], time() + (86400 * 30), "/");
                }
                header("Location: index.php"); 
            }
            else{
                echo "<script>alert('Please enter a valid username and password combination');</script>";
                header("Location: login.php");
            }
        }
         
    ?>
</body>
</html>