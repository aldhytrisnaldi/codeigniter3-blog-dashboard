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
                            <div class="card-body">
                                <div class="mb-4">
                                   <a href="<?=base_url('dashboard/auth/create_user');?>" class="btn btn-xs btn-primary"><b>Add User</b></a>
                                </div>
                                <table class="table table-bordered" id="tb_users">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Level</th>
                                            <th>Status</th>
                                            <th>Last Login</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
										<?php $no=1; foreach ($users as $user):?>
											<tr>
												<td>
													<?=$no++;?>
												</td>
												<td>
													<?php echo htmlspecialchars($user->first_name,ENT_QUOTES,'UTF-8');?> <?php echo htmlspecialchars($user->last_name,ENT_QUOTES,'UTF-8');?>
												</td>
												<td>
													<?php echo htmlspecialchars($user->email,ENT_QUOTES,'UTF-8');?>
												</td>
												<td>
													<?php foreach ($user->groups as $group):?>
														<?php echo htmlspecialchars($group->name,ENT_QUOTES,'UTF-8');?><br />
													<?php endforeach?>
												</td>
												<td>
													<?php echo ($user->active) ? anchor("dashboard/auth/deactivate/".$user->id, 'Activate','class="badge badge-success"', lang('index_active_link')) : anchor("dashboard/auth/activate/". $user->id, 'Deactivate','class="badge badge-danger"' , lang('index_inactive_link'));?>
												</td>
                                                <td>
                                                    <?php
                                                        if(empty($user->last_login))
                                                        {
                                                            echo NULL;
                                                        }
                                                        else
                                                        {
                                                            echo date('D, d M Y | H:i', $user->last_login);
                                                        }
                                                    ;?>
                                                </td>
												<td>
													<?php
														echo anchor(site_url('dashboard/auth/update_user/'.$user->id),'<b>Update</b>','class="btn btn-xs bg-navy"'); echo '&nbsp; ';
														echo anchor(site_url('dashboard/auth/delete_user/'.$user->id),'<b>Delete</b>','class="btn btn-xs bg-navy", onclick="javasciprt: return confirm(\'Are you sure delete this user.?\')"');
													?>
												</td>
											</tr>
										<?php endforeach;?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<script src="<?=base_url();?>/assets/back/js/tb_users.js"></script>
<?php $this->load->view('back/layouts/footer');?>