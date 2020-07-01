<?php $this->load->view('back/layouts/header');?>
<?php $this->load->view('back/layouts/navbar');?>
<?php $this->load->view('back/layouts/sidebar');?>

      <div class="content-wrapper">
            <?php $this->load->view('back/layouts/breadcrumbs');?>
            <div class="content">
                  <div class="container-fluid">
                        <div class="row">
                              <div class="col-12">
                                    <?php echo $message;?>  
                                    <div class="card">
                                          <?php echo form_open(uri_string());?>
                                                <div class="card-body">
                                                      <div class="row">
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php echo lang('create_user_fname_label', 'first_name');?> 
                                                                        <?php echo form_input($first_name);?>
                                                                  </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php echo lang('create_user_lname_label', 'last_name');?>
                                                                        <?php echo form_input($last_name);?>
                                                                  </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php
                                                                              if($identity_column!=='email') {
                                                                                    echo '<p>';
                                                                                    echo lang('create_user_identity_label', 'identity');
                                                                                    echo '<br />';
                                                                                    echo form_error('identity');
                                                                                    echo form_input($identity);
                                                                                    echo '</p>';
                                                                              }
                                                                        ?>
                                                                        <?php echo lang('create_user_email_label', 'email');?> <br />
                                                                        <?php echo form_input($email);?>
                                                                  </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php echo lang('create_user_phone_label', 'phone');?> 
                                                                        <?php echo form_input($phone);?>
                                                                  </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php echo lang('create_user_password_label', 'password');?> 
                                                                        <?php echo form_input($password);?>
                                                                  </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                  <div class="form-group">
                                                                        <?php echo lang('create_user_password_confirm_label', 'password_confirm');?>
                                                                        <?php echo form_input($password_confirm);?>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                <div class="card-footer">
                                                      <button type="submit" class="btn btn-xs btn-primary"><b>Add User</b></button>
                                                </div>
                                          <?php echo form_close();?>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>

<?php $this->load->view('back/layouts/main_footer');?>
<?php $this->load->view('back/layouts/footer');?>