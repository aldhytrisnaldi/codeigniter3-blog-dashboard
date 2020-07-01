<?php $this->load->view('back/layouts/header');?>
<?php $this->load->view('back/layouts/navbar');?>
<?php $this->load->view('back/layouts/sidebar');?>

    <div class="content-wrapper">
        <?php $this->load->view('back/layouts/breadcrumbs');?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <?php echo $this->session->userdata('message') <> '' ? $this->session->userdata('message') : ''; ?>
                        <div class="card">
                            <div class="card-body table-responsive">
                                <div class="mb-4">
                                    <a href="<?=base_url('dashboard/article/add_article');?>" class="btn btn-xs btn-primary"><b>Add Article</b></a>
                                </div>
                                <table class="table table-bordered" id="tb_article">
                                    <thead>
                                        <tr>
                                            <th width="20px">No</th>
                                            <th>Title</th>
                                            <th>Author</th>
                                            <th>Category</th>
                                            <th>Subcategory</th>
                                            <th>Status</th>
                                            <th width="110px">Action</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<script src="<?=base_url();?>/assets/back/js/tb_article.js"></script>
<?php $this->load->view('back/layouts/footer');?>