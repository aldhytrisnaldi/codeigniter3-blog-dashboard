<?php $this->load->view('back/layouts/header');?>
<?php $this->load->view('back/layouts/navbar');?>
<?php $this->load->view('back/layouts/sidebar');?>

    <div class="content-wrapper">
        <?php $this->load->view('back/layouts/breadcrumbs');?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary elevation-2"><i class="fas fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Administrator</span>
                                <span class="info-box-number">
                                    <?=$admin;?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-2"><i class="fas fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Member</span>
                                <span class="info-box-number">
                                    <?=$member;?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-success elevation-2"><i class="fas fa-user-check"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">User Activate</span>
                                <span class="info-box-number">
                                    <?=$active;?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger elevation-2"><i class="fas fa-user-lock"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">User Deactivate</span>
                                <span class="info-box-number">
                                    <?=$deactive;?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<?php $this->load->view('back/layouts/footer');?>