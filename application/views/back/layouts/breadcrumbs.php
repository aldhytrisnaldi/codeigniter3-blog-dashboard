<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark"><?=$pages;?></h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?=base_url('dashboard/home');?>">DASHBOARD</a></li>
                    <?php
                        if($this->uri->segment(3) == NULL){echo '<li class="breadcrumb-item active">'.$pages.'</li>';}else{echo'<li class="breadcrumb-item active">'.$pages.'</li><li class="breadcrumb-item active">'.$sub.'</li>';}
                    ;?>
                </ol>
            </div>
        </div>
    </div>
</div>