
<?php $page_title = "Assets under advisement"; ?>
<?php include "includes/page_title.php"; ?>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="card card-solid">
    <div class="card-body">


      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Assets</th>
            <th>Edit</th>
          </tr>
        </thead>
        <tbody>
      <?php
        $query = "SELECT * FROM assets_under_advisement WHERE id=1";
        $select_users = mysqli_query($connection, $query);

        while ($row = mysqli_fetch_assoc($select_users)) {
            $amount = $row['amount'];
        ?>
          <tr>
            <td>
              <?php echo $amount ?>
            </td>
           
            <td class="text-center">
              <a href="assets.php?source=edit_assets" class="btn btn-sm btn-primary">
                <i class="far fa-edit mr-2"></i>Edit
              </a>
            </td>
          </tr>
          <?php } ?>

        </tbody>
      </table>

          </div>
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->

</section>
<!-- /.content -->
