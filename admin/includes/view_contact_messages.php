<!-- DELETE USERS -->
<?php $page_title = "Contact form messages"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">

      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>#</th>
            <th>Date</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Message</th>
          </tr>
        </thead>
        <tbody>
          <?php
        //pagination
        $rowCounter_per_page = 0;
        //the number of posts per page
        $articles_per_page = 15;
    
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

        $post_query_count = "SELECT * FROM contact";
        $select_post_query_count = mysqli_query($connection, $post_query_count);
        $count = mysqli_num_rows($select_post_query_count);
        $count = ceil($count / $articles_per_page); 

        $query = "SELECT * FROM contact ORDER BY id DESC LIMIT $page_1, $articles_per_page";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $rowCounter_per_page++;
            $totalRowCounter = $rowCounter_per_page + (($page-1) * $articles_per_page);
            
            $id = $row['id'];
            $firstname = $row['firstname'];
            $lastname = $row['lastname'];
            $email = $row['email'];
            $phone = $row['phone'];
            $message = $row['message'];

            $timestamp = strtotime($row['timestamp']);
            $contact_date = date("Y-m-d", $timestamp);
            $contact_time = date("H:i:s", $timestamp);

            $short_message = strip_tags($message);
            if (strlen($short_message) > 50) {

                // truncate string
                $stringCut = substr($short_message, 0, 45);
                $endPoint = strrpos($stringCut, ' ');
            
                //if the string doesn't contain any space then it will cut without word basis.
                $short_message = $endPoint? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                $short_message .= '...';
            } 
        
        ?>
          <tr data-widget="expandable-table" aria-expanded="false">
            <td>
              <?php echo $totalRowCounter ?>
            </td>
            <td>
              <?php echo $contact_date ?> /<br> <?php echo $contact_time ?>
            </td>
            <td>
              <?php echo $firstname." ".$lastname ?>
            </td>
            <td>
              <?php echo $email ?>
            </td>
            <td>
              <?php echo $phone ?>
            </td>
            <td>
              <?php echo $short_message ?>
            </td>
          </tr>
          <tr class="expandable-body">
            <td colspan="6">
              <p>
                <?php echo $message ?>
              </p>
            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>

          </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
      <nav aria-label="Contacts Page Navigation">
        <ul class="pagination justify-content-center m-0">
          <?php
        if($count > 1){
            for($i = 1; $i <= $count; $i++){
                if($i == $page){
                    echo "<li class='page-item active'><a class='page-link' href='contact.php?page={$i}'>$i</a></li>";
                }else{
                    echo "<li class='page-item'><a class='page-link' href='contact.php?page={$i}'>$i</a></li>";
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
