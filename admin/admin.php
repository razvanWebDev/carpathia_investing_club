<?php include "includes/header.php"; ?>
  <div class="wrapper">

    <?php include "includes/top_navbar.php"; ?>
    <?php include "includes/sidebar.php"; ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <?php $page_title = "Home"; ?>
    <?php include "includes/page_title.php"; ?>

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-lg-3 col-6">
              <!-- small box -->
              <div class="small-box bg-info">
                <div class="inner">
                  <?php
                  $query = "SELECT * FROM users";
                  $select_users = mysqli_query($connection, $query);
                  $num_users = mysqli_num_rows($select_users);
                  ?>
                  <h3><?php echo $num_users ?></h3>
                  <p>Users</p>
                </div>
                <div class="icon">
                <i class="fas fa-users"></i>
                </div>
                <a href="users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->

            <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                <?php
                  $query = "SELECT * FROM member_requests";
                  $result = mysqli_query($connection, $query);
                  $num_requests = mysqli_num_rows($result);
                  ?>
                  <h3><?php echo $num_requests ?></h3>

                  <p>Memeber Requests</p>
                </div>
                <div class="icon">
                  <i class="fas fa-user-clock"></i>
                </div>
                <a href="member-requests.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div>

            <!-- ./col -->

            <!-- <div class="col-lg-3 col-6">
              <div class="small-box bg-warning">
                <div class="inner">
                  <h3>44</h3>

                  <p>User Registrations</p>
                </div>
                <div class="icon">
                  <i class="ion ion-person-add"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->

            <!-- ./col -->

            <!-- <div class="col-lg-3 col-6">
              <div class="small-box bg-danger">
                <div class="inner">
                  <h3>65</h3>

                  <p>Unique Visitors</p>
                </div>
                <div class="icon">
                  <i class="ion ion-pie-graph"></i>
                </div>
                <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
              </div>
            </div> -->
            <!-- ./col -->
          </div>
          <!-- /.row -->
        </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

  </div>
  <!-- ./wrapper -->

<?php include "includes/footer.php"; ?>