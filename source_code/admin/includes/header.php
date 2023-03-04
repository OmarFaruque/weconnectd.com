
  <!-- .navbar -->
  <nav class="main-header navbar navbar-expand navbar-dark">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item">
        <a class="nav-link btn btn-danger" href="logout.php" role="button">
          <i class="fa-solid fa-right-from-bracket"></i> Logout
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img style="width:180px;" src="upload/logo_img/<?php echo $conn->query("SELECT * FROM logos WHERE id=1")->fetch_array()['header_logo']; ?>" alt="Logo" class="brand-image" style="opacity: 1">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="upload/admin_img/<?php echo $admin_photo; ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block"><?php echo $admin_name; ?></a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="dashboard.php" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard              
              </p>
            </a>           
          </li>         
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-copy"></i>
              <p>
                Manage CMS
                <i class="fas fa-angle-left right"></i>             
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php
              $permission = explode(',', $admin_data['permission']);
               ?>
              <?php
              if($admin_type == 'admin' OR in_array('logos', $permission)){
                ?>
              <li class="nav-item">
                <a href="manage-logo.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-primary"></i>
                  <p>Manage Logos</p>
                </a>
              </li> 
                <?php
              }
              ?> 
                                           
            </ul>
          </li>
            <?php
          if($admin_type == 'admin' OR in_array('coin_token_blast', $permission)){
            ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-rocket"></i>
              <p>
                Manage Coin Token Blast
                <i class="fas fa-angle-left right"></i>             
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="add-coin-token-blast.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Add Coin Token Blast</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view-coin-token-blast.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>View Coin Token Blast</p>
                </a>
              </li>                                                                             
            </ul>
          </li> 
            <?php
          }
          ?>
			            <?php
          if($admin_type == 'admin' OR in_array('sc_top_40', $permission)){
            ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-rocket"></i>
              <p>
                Manage SC TOP 40
                <i class="fas fa-angle-left right"></i>             
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="add-sc-top-40.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Add SC TOP 40</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view-sc-top-40.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>View SC TOP 40</p>
                </a>
              </li>                                                                             
            </ul>
          </li> 
            <?php
          }
          ?>
						            <?php
          if($admin_type == 'admin' OR in_array('sc_top_40', $permission)){
            ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-rocket"></i>
              <p>
                Manage Forum Category
                <i class="fas fa-angle-left right"></i>             
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="add-forum-category.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Add Forum Category</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="view-forum-category.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>View Forum Category</p>
                </a>
              </li>                                                                             
            </ul>
          </li> 
            <?php
          }
          ?>
          <?php
          if($admin_type == 'admin' OR in_array('admin', $permission)){
            ?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-user"></i>
              <p>
                Manage Admin
                <i class="fas fa-angle-left right"></i>             
              </p>
            </a>
            <ul class="nav nav-treeview">              
              <li class="nav-item">
                <a href="add-admin.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-danger"></i>
                  <p>Add Admin</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="views-admin.php" class="nav-link">
                  <i class="far fa-circle nav-icon text-warning"></i>
                  <p>View Admin</p>
                </a>
              </li>                                                                             
            </ul>
          </li> 
            <?php
          }
          ?>             
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>