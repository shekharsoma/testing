<?php
//for local
$connect = mysqli_connect("localhost", "root", "", "demo");
//for live
//$connect = mysqli_connect("localhost", "testuser", "password!", "demo");
if(isset($_GET['page']))
{
    $page = $_GET['page'];
  }
  else{
      $page = 1;
    }
    $num_per_page = 10;
    $start_from = ($page-1)*10;
$sql = "SELECT * FROM employees limit $start_from,$num_per_page";  
$result = mysqli_query($connect, $sql);
?>
<html>  
 <head>  
  <title>Export Data</title>  
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
 </head>  
 <body>  
 <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                 <div class="col-md-10">
                     <div class="col-md-16"> 
   <br />  
   <div class="table-responsive">  
    <h2 align="center">Export Data</h2><br /> 
    <table class="table table-bordered">
     <tr>  
                         <th>S.No</th>
                         <th>Item</th>  
                         <th>Date</th>  
                         <th>Amount</th>  
     </tr>
     <?php
                                echo "<tbody>";
                                while($row = mysqli_fetch_array($result)){
                                    echo "<tr>";
                                        echo "<td>" . $row['id'] . "</td>";
                                        echo "<td>" . $row['name'] . "</td>";
                                        echo "<td>" . $row['date'] . "</td>";
                                        echo "<td>" . $row['amount'] . "</td>";
                                        echo "</tr>";
                                }
                                echo "</tbody>"; 
                             $query = "select * from employees";
                             $result = mysqli_query($connect,$query);
                             $total_record = mysqli_num_rows($result);
                             $total_page = ceil($total_record/$num_per_page);
                            if($page>1)
                            {
                             echo " <a href='reports.php?page=".($page-1)."' class='btn btn-primary'>Previous</a>";
                            }
                            for($i=1;$i<$total_page;$i++)
                            {
                                echo "<a href='reports.php?page=".$i."' class='btn btn-primary'>$i</a>";
                            }
                            if($i>$page)
                            {
                                echo " <a href='reports.php?page=".($page+1)."' class='btn btn-danger'>Next</a>";
                            }
     ?>
    </table>
    <br />
    <form method="post" action="export.php">
     <input type="submit" name="export" class="btn btn-success" value="Export" />
     <a href="index.php" class="btn btn-danger">Cancel</a>
     <a href="logout.php" class="btn btn-danger">Sign Out</a>
    </form>
   </div>  
  </div>  
 </body>  
</html>
