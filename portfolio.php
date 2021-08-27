<?php include "PHP/header.php"; ?>
<?php include "PHP/nav.php"; ?>

<section class="portfolio">
    <h2 class="section-title">Portfolio</h2>
    <table class="portfolio-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Date Pitched</th>
                <th>Company</th>
                <th>Ticker</th>
                <th>Purchased</th>
                <th>Purchase Price</th>
                <th>Exit Price</th>
            </tr>
        </thead>
        <tbody>
          <?php
        //pagination
        $rowCounter_per_page = 0;
        //the number of posts per page
        $articles_per_page = 25;
    
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
            $company = $row['company'];
            $ticker = $row['ticker'];
            $purchased = $row['purchased'];
            $purchase_price = $row['purchase_price'] > 0 ? $row['purchase_price'] : "";
            $exit_price = $row['exit_price'] > 0 ? $row['exit_price'] : "";
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
          </tr>
          <?php } ?>

        </tbody>
    </table>

    <nav>
        <div class="pagination">
          <?php
        if($count > 1){
            for($i = 1; $i <= $count; $i++){
                if($i == $page){
                    echo "<a class='page-item active' href='portfolio.php?page={$i}'>$i</a>";
                }else{
                    echo "<a class='page-item' href='portfolio.php?page={$i}'>$i</a>";
                }
            }
        }
        ?>
        </div>
      </nav>

</section>

<?php include "PHP/footer.php"; ?>