<?php $this->load->view('back/layouts/header');?>
<?php $this->load->view('back/layouts/navbar');?>
<?php $this->load->view('back/layouts/sidebar');?>

    <div class="content-wrapper">
        <?php $this->load->view('back/layouts/breadcrumbs');?>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-xs-12">
                        <?php if($this->session->flashdata('message')){echo $this->session->flashdata('message');} ?>
                        <div class="card">
                            <?php echo form_open_multipart($action);?>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <?php echo form_input($title);?>
                                        <?php echo form_error('title') ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <?php echo form_textarea($description);?>
                                        <?php echo form_error('description') ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Category</label>
                                                <?php echo form_dropdown('',$category, '',$id_cat); ?>
                                                <?php echo form_error('id_cat') ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Subcategory</label>
                                                <?php echo form_dropdown('', array(''=>'- Please choose a category -'), '', $id_subcat); ?>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="form-group">
                                                <label>Images</label>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" name="photos" id="photos" onchange="imagesPreview(this,'preview')">
                                                        <label class="custom-file-label">Choose Images</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <label>Status</label>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="1" <?php echo  set_radio('status', '1', TRUE); ?> />
                                                <label class="form-check-label">Publish</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="status" value="0" <?php echo  set_radio('status', '0'); ?> />
                                                <label class="form-check-label">Draft</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-xs btn-primary"><b>Submit</b></button>
                                </div>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-xs-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-group">
                                    <label>Images Preview</label>
                                    <img class="img-fluid pad" id="preview" width="450px" height="auto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php $this->load->view('back/layouts/main_footer');?>
<script src="<?=base_url()?>/assets/back/js/add_article.js"></script>
<script>
    function viewSubcat(){
        var id_cat  = document.getElementById("id_cat").value;
        
        $.ajax({
            url:"<?php echo base_url();?>dashboard/article/get_subcategory/"+id_cat+"",
            type: "GET",
            success: function(response)
            {
                $("#id_subcat").html(response);
            },
            dataType:"html"
        });
        return false;
    }
</script>
<?php $this->load->view('back/layouts/footer');?>