<!DOCTYPE html>
<html>
    <head>
        <title>Single User</title>
    </head>
    <body>
        <?php                         
            require_once("navbar.php"); 
            require_once("classes.php");
        ?> 
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Region</th>
                                <th>Country</th>
                                <th>Postal</th>
                                <th>Phone</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $travelUser = new travelUser(); 
                                $res = $travelUser->getUserByID($_GET['id']); 
                                foreach($res as $row){
                                    echo '<tr>'; 
                                    foreach($row as $key => $cell){
                                        if($row['Privacy'] == 2)
                                        {
                                            if($key == 'Address' || $key == 'Postal' || $key == 'Phone'){
                                                $cell = "Hidden"; 
                                            }
                                        }
                                        if($key != 'Privacy'){
                                            echo '<td>' . $cell . '</td>';
                                        }
                                    } 
                                    echo '</tr>';
                                }
                            ?>
                        </tbody>
                    </table>
            <div class="row">
                <div class="col-md-6">
                    <div class="text-center">
                        <h3>Posts By User</h3>
                    </div>
                    <div class="card-deck">
                    <?php
                        require_once("boxes.php"); 
                        otherPostsbyUser($_GET['id'], 0); 
                    ?>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="text-center">
                        <h3>User Images</h3>
                    </div>
                    <div class="card-deck">
                    <?php
                        imagesByUser($_GET['id']); 
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    </body>
</html>