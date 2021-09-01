<!-- DELETE COMPANY -->
<?php 
 if(isset($_GET['delete'])) {
    if(isset($_SESSION['username'])){
        $company_id = mysqli_real_escape_string($connection, $_GET['delete']);
        deleteItem("portfolio", $company_id);
    }
    header("Location: portfolio.php");
    exit();
 }
?>

<?php $page_title = "Portfolio"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">

    <a href="portfolio.php?source=add_company" class="btn bg-primary mb-4">
      <i class="fas fa-plus mr-2"></i>Add Company
    </a>

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Date pitched</th>
            <th>Company</th>
            <th>Ticker</th>
            <th>Purchased</th>
            <th>Purchase Price</th>
            <th>Exit Price</th>
            <th>Exit Date</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          <?php
        //pagination
        $rowCounter_per_page = 0;
        //the number of posts per page
        $articles_per_page = 30;
    
        if(isset($_GET['page'])){
            $page = $_GET['page'];
        }else{
            $page = 1;
        }

        if($page == "" || $page == 1){
            $page_1 = 0;
        }else{
            $page_1 = ($page * $articles_per_page) - $articles_per_page;
        }

        $post_query_count = "SELECT * FROM portfolio";
        $select_post_query_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($select_post_query_count);
        $count = ceil($count / $articles_per_page); 

        $query = "SELECT * FROM portfolio ORDER BY id DESC LIMIT $page_1, $articles_per_page";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $rowCounter_per_page++;
            $totalRowCounter = $rowCounter_per_page + (($page-1) * $articles_per_page);
            
            $id = $row['id'];

            $date_pitched = $row['date_pitched'];
            $date_pitched = strtotime($date_pitched);
            $date_pitched = date("d/m/Y", $date_pitched);

            $company = $row['company'];
            $ticker = $row['ticker'];
            $purchased = $row['purchased'];
            $purchase_price = $row['purchase_price'] > 0 ? $row['purchase_price'] : "";
            $exit_price = $row['exit_price'] > 0 ? $row['exit_price'] : "";

            $exit_date = $row['exit_date'] > 1 ? $row['exit_date'] : "";
            if(ifExists($exit_date)){
              $exit_date = strtotime($exit_date);
              $exit_date = date("d/m/Y", $exit_date);
            }
            
        ?>
          <tr>
            <td>
              <?php echo $totalRowCounter ?>
            </td>
            <td>
              <?php echo $date_pitched ?>
            </td>
            <td>
              <?php echo $company ?>
            </td>
            <td>
              <?php echo $ticker ?>
            </td>
            <td>
              <?php echo $purchased ?>
            </td>
            <td>
              <?php echo $purchase_price ?>
            </td>
            <td>
              <?php echo $exit_price ?>
            </td>
            <td>
              <?php echo $exit_date ?>
            </td>
            <td class="text-center">
              <a href="portfolio.php?source=edit_company&id=<?php echo $id; ?>" class="btn btn-sm btn-primary">
                <i class="far fa-edit mr-2"></i>Edit
              </a>
            </td>
            <td class="text-center">
              <a href="portfolio.php?delete=<?php echo $id; ?>" onClick="javascript:return confirm('Delete <?php echo $company; ?>?')"; class="btn btn-sm bg-danger">
                <i class="fas fa-trash-alt mr-2"></i>
                  Delete
              </a>
            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>

          </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <nav>
        <ul class="pagination justify-content-center m-0">
          <?php
        if($count > 1){
            for($i = 1; $i <= $count; $i++){
                if($i == $page){
                    echo "<li class='page-item active'><a class='page-link' href='portfolio.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='portfolio.php?page={$i}'>$i</a></li>";
                }
            }
        }
        ?>
        </ul>
      </nav>
    </div>
    <!-- /.card-footer -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
