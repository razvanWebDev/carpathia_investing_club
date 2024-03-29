<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="../" class="brand-link">
    <img src="../img/Logo_small.png" alt="Carpathia Logo" class="brand-image img-circle elevation-3"
      style="opacity: .8">
    <span class="brand-text font-weight-light">Carpathia</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <?php
               $user_image = ifExists($_SESSION["user_image"]) ? $_SESSION["user_image"] : "user.png";
            ?>
        <img src="dist/img/users/<?php echo $user_image; ?>" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">
          <?php echo $_SESSION["username"]; ?>
        </a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        <li class="nav-item sidebar-page-header" id="home-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="admin.php" class="nav-link" data-page="admin.php" data-page-header="home-page-header">
                <i class="far fa-circle nav-icon"></i>
                <p>Dashboard</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item sidebar-page-header" id="home-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-envelope"></i>
            <p>
              Home Page
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="contact.php" class="nav-link" data-page="contact.php" data-page-header="home-page-header">
                <i class="far fa-circle nav-icon"></i>
                <p>View messages</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="assets.php" class="nav-link" data-page="assets.php" data-page-header="home-page-header">
                <i class="far fa-circle nav-icon"></i>
                <p>Assets</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item sidebar-page-header" id="portfolio-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-folder-open"></i>
            <p>
            Portfolio
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="portfolio.php" class="nav-link" data-page="portfolio.php" data-page-header="portfolio-page-header">
                <i class="far fa-circle nav-icon"></i>
                <p>Portfolio page</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="portfolio.php?source=add_company" class="nav-link" data-page="portfolio.php?source=add_company" data-page-header="portfolio-page-header">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Company</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item sidebar-page-header" id="members-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-comments"></i>
            <p>
              Chat
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="members.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Members</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="members.php?source=add_member" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Member</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="member-requests.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Member Requests</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="channels.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Channels</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="channels.php?source=add_channel" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Channel</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item sidebar-page-header" id="users-page-header">
          <a href="#" class="nav-link sidebar-page-title">
          <i class="far fa-newspaper nav-icon"></i>
            <p>
              News
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="news.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>View Articles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="news.php?source=add_article" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Add Article</p>
              </a>
            </li>
            <li class="nav-item">
                <a href="newsletter" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Newsletter</p>
                </a>
              </li>
            </ul>

        </li>

        <li class="nav-item sidebar-page-header" id="users-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-user"></i>
            <p>
              Users
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="users.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Admin Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="users.php?source=add_user" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create User</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item sidebar-page-header" id="regulations-page-header">
          <a href="#" class="nav-link sidebar-page-title">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Regulations
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="terms.php" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Terms&Conditions</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- <li class="nav-item">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Simple Link
                </p>
              </a>
            </li> -->
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>