<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
 
 <!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .container {
    padding-right: 10px;
    padding-left: 10px;
    margin-right: auto;
    margin-left: auto;
}
        body{ font: 14px sans-serif; text-align: center; }
    </style>
</head>
<body>
<div class="container">
             <div class="col-lg-12">
        <h1>Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> Welcome to our site.</h1><?php $today = date("d/m/Y"); echo $today; ?>
        <p>
<h2 class="btn-middle">Goods Details</h2>
<a href="create.php" class="btn btn-success">Add Item</a>
<a href="reset-password.php" class="btn btn-warning">Reset Password</a>
<a href="logout.php" class="btn btn-danger">Sign Out</a>
<?php if($_SESSION["role"] == "admin"){ 
    echo "<a href='register.php' class='btn btn-primary'>Create User</a>"; 
    echo "<a href='reports.php' class='btn btn-primary'> Download </a>";
    } 
?>
</p>
 <?php
                    // Include config file
                    require_once "config.php";
                    
                    if(isset($_GET['page']))
                    {
                        $page = $_GET['page'];
                      }
                      else{
                          $page = 1;
                        }
                        $num_per_page = 10;
                        $start_from = ($page-1)*10;

                    // Attempt select query execution
                    $sql = "SELECT * FROM employees limit $start_from,$num_per_page";
                    //$result = mysqli_query($link,$query);
                    if($result = mysqli_query($link, $sql)){
                        if(mysqli_num_rows($result) > 0){
                            echo "<table class='table table table-striped'>";
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>S.No</th>";
                                        echo "<th>Item</th>";
                                        echo "<th>Date</th>";
                                        echo "<th>Amount</th>";
                                        if($_SESSION["role"] == "admin"){
                                        echo "<th>Action</th>"; 
                                        }  
                                        echo "<th>User</th>";                              
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                 
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                         if($_SESSION["role"] == "admin"){ 
                                        echo "<td>";
                                            echo "<a href='read.php?id=". $row['id'] ."' title='View Record' data-toggle='tooltip'> <span class='glyphicon glyphicon-eye-open'></span></a>";
                                            echo "<a href='update.php?id=". $row['id'] ."' title='Update Record' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='delete.php?id=". $row['id'] ."' title='Delete Record' data-toggle='tooltip'><span class='glyphicon glyphicon-trash'></span></a>";
                                        echo "</td>";
                                         }
                                         echo "<td>" . $_SESSION['username'] . "</td>";
                                        echo "</tr>";
                                     }
                                echo "</tbody>";                            
                            echo "</table>";
                             $query = "select * from employees";
                             $result = mysqli_query($link,$query);
                             $total_record = mysqli_num_rows($result);
                             $total_page = ceil($total_record/$num_per_page);
                            if($page>1)
                            {
                             echo " <a href='welcome.php?page=".($page-1)."' class='btn btn-primary'>Previous</a>";
                            }
                            for($i=1;$i<$total_page;$i++)
                            {
                                echo "<a href='welcome.php?page=".$i."' class='btn btn-primary'>$i</a>";
                            }
                            if($i>$page)
                            {
                                echo " <a href='welcome.php?page=".($page+1)."' class='btn btn-danger'>Next</a>";
                            }

                            // Free result set
                            mysqli_free_result($result);
                        } else{
                            echo "<p class='lead'><em>No records were found.</em></p>";
                        }
                    } else{
                        echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                    }
 
                    // Close connection
                    mysqli_close($link);
                    
                    ?>
                    
              </div>
    </div>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>