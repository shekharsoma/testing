<?php  
//for local
$connect = mysqli_connect("localhost", "root", "", "demo");
//for live
//$connect = mysqli_connect("localhost", "testuser", "password!", "demo");
$output = '';
if(isset($_POST["export"]))
{
 $query = "SELECT * FROM employees order by date";
 $result = mysqli_query($connect, $query);
 if(mysqli_num_rows($result))
 {
  $output .= '
  <h1 align="center">Report</h1>
  <table class="table table-bordered">
                    <tr>  
                         <th>S.No</th>
                         <th>Item</th>  
                         <th>Date</th>  
                         <th>Amount</th>  
                    </tr>
  ';
  while($row = mysqli_fetch_array($result))
  {
   $output .= '
    <tr>  
                         <td>' .$row['id'].' </td>
                         <td>'.$row["name"].'</td>  
                         <td>'.$row["date"].'</td>  
                         <td>'.$row["amount"].'</td>  
                    </tr>
   ';
  }
  $output .= '</table>';
  header('Content-Type: application/xls');
  header('Content-Disposition: attachment; filename=Report.xls');
  echo $output;
 }
}
?>