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
                            <?php echo form_open_multipart(uri_string());?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Images</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <?php echo form_input($photos);?>
                                                <label class="custom-file-label">Choose Images</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_fname_label', 'first_name');?> 
                                                <?php echo form_input($first_name);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_lname_label', 'last_name');?>
                                                <?php echo form_input($last_name);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_email_label', 'email');?>
                                                <?php echo form_input($email);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_phone_label', 'phone');?>
                                                <?php echo form_input($phone);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_password_label', 'password');?> 
                                                <?php echo form_input($password);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
                                                <?php echo form_input($password_confirm);?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <?php if ($this->ion_auth->is_admin()): ?>
                                                    <?php foreach ($groups as $group):?>
                                                        <label class="radio">
                                                            <?php
                                                                $gID=$group['id'];
                                                                $checked = null;
                                                                $item = null;
                                                                foreach($currentGroups as $grp) {
                                                                    if ($gID == $grp->id) {
                                                                        $checked= ' checked="checked"';
                                                                    break;
                                                                    }
                                                                }
                                                            ?>
                                                            <input type="radio" name="groups[]" value="<?php echo $group['id'];?>"<?php echo $checked;?>>
                                                            <?php echo htmlspecialchars($group['name'],ENT_QUOTES,'UTF-8');?>
                                                        </label>
                                                    <?php endforeach?>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-xs btn-primary"><b>Update</b></button>
                                </div>
                                <?php echo form_hidden('id', $user->id);?>
                                <?php echo form_hidden($csrf); ?>
                            <?php echo form_close();?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<?php $this->load->view('back/layouts/footer');?>