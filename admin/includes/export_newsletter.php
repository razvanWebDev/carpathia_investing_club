<?php include "../../PHP/db.php" ?>
<?php 
header("Content-Type: application/vnd-ms-excel");    
header('Content-Disposition: attachment; filename="City_nominations.xls"');  
header("Pragma: no-cache"); 
header("Expires: 0");

echo '<table border="1">';
//make the column headers what you want in whatever order you want
echo '<tr>
        <th>Email</th>
    </tr>';
//loop the query data to the table in same order as the headers
$query = "SELECT * FROM newsletter ORDER BY id DESC";
$result = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($result)){
    echo "<tr>
            <td>".$row['email']."</td>
        </tr>";
}
echo '</table>';
exit();?>