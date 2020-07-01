<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="<?=base_url('/');?>" class="brand-link">
    <img src="<?=base_url();?>assets/svnth/logo.PNG" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">TECHNOCT</span>
  </a>
  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?=base_url();?>assets/svnth/logo.PNG" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata('email'); ?></a>
      </div>
    </div>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-header">BLOG OPTION</li>
        <li class="nav-item">
          <a href="<?=base_url('dashboard/home');?>" <?php if($this->uri->segment(2) == "home"){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?>>
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('dashboard/article');?>" <?php if($this->uri->segment(2) == "article"){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?>>
            <i class="nav-icon fas fa-file"></i>
            <p>
              Article
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('dashboard/category');?>" <?php if($this->uri->segment(2) == "category"){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?>>
            <i class="nav-icon fas fa-folder"></i>
            <p>
              Category
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('dashboard/subcategory');?>" <?php if($this->uri->segment(2) == "subcategory"){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?>>
            <i class="nav-icon fas fa-sitemap"></i>
            <p>
              Subcategory
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?=base_url('dashboard/auth/users');?>" <?php if($this->uri->segment(2) == "auth"){echo "class='nav-link active'";}else{echo "class='nav-link'";} ?>>
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>