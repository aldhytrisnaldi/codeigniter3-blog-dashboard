<?php $this->load->view('back/layouts/header');?>
<?php $this->load->view('back/layouts/navbar');?>
<?php $this->load->view('back/layouts/sidebar');?>

    <div class="content-wrapper">
        <?php $this->load->view('back/layouts/breadcrumbs');?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <?php echo form_open($action);?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Subcategory</label>
                                        <?php echo form_input($subcategory,$subcat->subcategory);?>
                                        <?php echo form_error('subcategory') ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Parent Category</label>
                                        <?php echo form_dropdown('',$category, $subcat->id_parent,$id_parent); ?>
                                        <?php echo form_error('id_parent') ?>
                                    </div>
                                    <?php echo form_input($id_subcategory,$subcat->id_subcategory);?>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-xs btn-primary"><b><?php echo $button ?></b></button>
                                </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card card-widget widget-user-2">
                            <div class="widget-user-header bg-navy">
                                <div class="widget-user-image">
                                    <img class="img-circle elevation-2" src="<?=base_url('assets/svnth/logo.PNG');?>" alt="User Avatar">
                                </div>
                                <h3 class="widget-user-username"><?php echo $this->session->userdata('email');?></h3>
                                <h5 class="widget-user-desc">Backend Developer</h5>
                            </div>
                            <div class="card-footer p-0">
                                <ul class="nav flex-column">
                                    <li class="nav-item">
                                        <a href="#" class="nav-link">
                                            Category <span class="float-right badge bg-primary">842</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<?php $this->load->view('back/layouts/footer');?>