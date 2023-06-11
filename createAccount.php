<!DOCTYPE html>
<html>
<head>
    <title>Sign Up Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</head>
<body>
<div class="container">
    <h2>Sign Up for Travel Site</h2>
    <form action="createAccount.php" method="post">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
        </div>
        <div class="form-group">
            <label for="firstName">First Name:</label>
            <input type="text" class="form-control" id="firstName" placeholder="Enter first name" name="firstName" required>
        </div>
        <div class="form-group">
            <label for="lastName">Last Name:</label>
            <input type="text" class="form-control" id="lastName" placeholder="Enter last name" name="lastName" required>
        </div>
        <div class="form-group">
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" placeholder="Enter address" name="address" required>
        </div>
        <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" placeholder="Enter city" name="city" required>
        </div>
        <div class="form-group">
            <label for="region">Region:</label>
            <input type="text" class="form-control" id="region" placeholder="Enter region" name="region" required>
        </div>
        <div class="form-group">
            <label for="country">Country:</label>
            <input type="text" class="form-control" id="country" placeholder="Enter country" name="country" required>
        </div>
        <div class="form-group">
            <label for="postal">Postal Code:</label>
            <input type="text" class="form-control" id="postal" placeholder="Enter postal code" name="postal" required>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number:</label>
            <input type="text" class="form-control" id="phone" placeholder="Enter phone number" name="phone" required>
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" placeholder="Enter email" name="email" required>
        </div>
        <div class="form-group form-check">
            <label class="form-check-label">
                <input type="hidden" name="privacy" value="1">
                <input class="form-check-input" type="checkbox" name="privacy" value="2"> Make my account Private.
            </label>
        </div>
        <input type="submit" class="btn btn-primary" name="submit" value="Submit">    
    </form>
    <?php
        require_once("classes.php"); 
        if (isset($_POST['username'])){
            $travelUser = new travelUser(); 
            $travelUser->createUser($_POST['username'], 
                                    $_POST['password'], 
                                    $_POST['firstName'], 
                                    $_POST['lastName'], 
                                    $_POST['address'], 
                                    $_POST['city'], 
                                    $_POST['region'], 
                                    $_POST['country'], 
                                    $_POST['postal'], 
                                    $_POST['phone'], 
                                    $_POST['email'], 
                                    $_POST['privacy']); 
    
        }
    ?>
</div>
</body>
</html>