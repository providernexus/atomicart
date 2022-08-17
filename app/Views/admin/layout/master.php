<!DOCTYPE html>
<html lang="<?php
	if(empty(session()->get('lang'))){
		echo 'EN';
	}else{
		echo session()->get('lang');
	}
?>">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Atomic Arts Intranet</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/feather/feather.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/ti-icons/css/themify-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/css/vendor.bundle.base.css') ?>" />
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/ti-icons/css/themify-icons.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/vendors/mdi/css/materialdesignicons.min.css') ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/admin/js/select.dataTables.min.css') ?>" />
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/vertical-layout-light/style.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/css/custom.css') ?>" />
    <link rel="stylesheet" href="<?php echo base_url('assets/common/css/custom.css?v=' . time()) ?>">
    <!-- endinject -->
    <link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/dropzone.css')?>" />
    <link href="https://unpkg.com/jquery-resizable-columns@0.2.3/dist/jquery.resizableColumns.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/akottr/dragtable@master/dragtable.css">

    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.css" rel="stylesheet">
    <link href="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.css" rel="stylesheet">

    <link href="https://unpkg.com/@fortawesome/fontawesome-free@5.12.1/css/all.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .errors p {
            margin-bottom: 0;
        }

        a label.badge {
            cursor: pointer;
            text-decoration: underline;
        }

        p.error {
            color: red;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .sidebar .nav.sub-menu {
            background: #002366;
        }

        .sidebar .nav:not(.sub-menu)>.nav-item.active {
            background: #002366;
        }

        .sidebar .nav:not(.sub-menu)>.nav-item>.nav-link[aria-expanded="true"] {
            background: #002366;
        }

        .sidebar .nav:not(.sub-menu)>.nav-item:hover>.nav-link,
        .sidebar .nav:not(.sub-menu)>.nav-item:hover[aria-expanded="true"] {
            background: #002366;
        }

        .sidebar .nav.sub-menu .nav-item::before {
            background: #ffffff;
        }

        .sidebar .nav .nav-item.active>.nav-link {
            background: #002366;
        }

        /* Full body loader */
        .center {
            display: flex;
            text-align: center;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            position: fixed;
            background: rgba(0, 0, 0, 0.8);
            z-index: 99999;
            width: 100%;
            color: #fff;
        }

        .ring {
            position: absolute;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            animation: ring 2s linear infinite;
        }

        @keyframes ring {
            0% {
                transform: rotate(0deg);
                box-shadow: 1px 5px 2px #e65c00;
            }

            50% {
                transform: rotate(180deg);
                box-shadow: 1px 5px 2px #18b201;
            }

            100% {
                transform: rotate(360deg);
                box-shadow: 1px 5px 2px #0456c8;
            }
        }

        .ring:before {
            position: absolute;
            content: '';
            left: 0;
            top: 0;
            height: 100%;
            width: 100%;
            border-radius: 50%;
            box-shadow: 0 0 5px rgba(255, 255, 255, .3);
        }

        @keyframes text {
            50% {
                color: black;
            }
        }

        /* End Full body loader */
    </style>
    <?= $this->renderSection("style") ?>
</head>

<body>
    <input type="hidden" id="base_url" value="<?php echo base_url(); ?>">
    <div class="full-body-loader center d-none">
        <div class="ring"> </div>
        <span>Processing please wait...</span>
    </div>
    <div class="container-scroller">
        <?php
        use App\Models\Common;
        $this->common_model = new Common();
        $id = session()->get('admin_id');
        $media_id = $this->common_model->GetSingleValue(ADMIN_TABLE, 'media_id', array('id' => $id));
        $name = $this->common_model->GetSingleValue(MEDIA_TABLE, 'name', array('id' => $media_id));
        if (!empty($name) && file_exists(FCPATH.'/uploads/' . $name)) :
            $image = base_url('uploads/' . $name);
        else :
            $image = base_url('assets/admin/images/faces/profile.png');
        endif;

        ?>
        <!-- partial:partials/_navbar.html -->
        <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
            <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
                <a class="navbar-brand brand-logo mr-5" href="<?php echo base_url('admin/dashboard') ?>"><img src="https://www.nexustechies.com/images/logo.AVIF" class="mr-2" alt="logo" /></a>
                <a class="navbar-brand brand-logo-mini" href="<?php echo base_url('admin/dashboard') ?>">
                    <!--<img src="<?php echo base_url('assets/front/img/logo.png') ?>" alt="logo" />-->
                </a>
            </div>
            <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
                <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                    <span class="icon-menu"></span>
                </button>
				
                <ul class="navbar-nav navbar-nav-right">
                    <li class="nav-item nav-profile dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" id="profileDropdown">
                            <img src="<?php echo $image ?>" alt="profile" />
                        </a> 
                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="profileDropdown">
                            <a class="dropdown-item" href="<?php echo base_url('admin/profile') ?>">
                                <i class="ti-settings text-primary"></i>
                                <?php echo lang('Text.common.profile') ?>
                            </a>
                            <a class="dropdown-item" href="<?php echo base_url('admin/logout') ?>">
                                <i class="ti-power-off text-primary"></i>
                                <?php echo lang('Text.common.logout') ?>
                            </a>
                        </div>
                    </li>
                </ul>
                <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
                    <span class="icon-menu"></span>
                </button>
                &nbsp;
	
            </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
            <!-- partial:partials/_settings-panel.html -->

            <!-- partial -->
            <!-- partial:partials/_sidebar.html -->
            <?php
            $router = service('router');
            $route  = $router->getMatchedRoute();
            $permissions = all_permissions();
            ?>
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                <ul class="nav">
                    <li class="nav-item <?php if ($route[0] == "admin/dashboard") echo "active"; ?>">
                        <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
                            <i class="icon-grid menu-icon"></i>
                            <span class="menu-title"><?php echo lang('Text.menu.dashboard') ?></span>
                        </a>
                    </li>
                        <li class="nav-item  <?php if ($route[0] == "admin/department" || $route[0] == "admin/department/add" || $route[0] == "admin/department/edit/([0-9]+)") echo "active"; ?>">
                            <a class="nav-link" data-toggle="collapse" href="#ui-storyline" aria-expanded="false" aria-controls="ui-storyline">
                                <i class="mdi mdi-book-open-page-variant" aria-hidden="true"></i>
                                <span class="menu-title">Department</span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse <?php if ($route[0] == "admin/department" || $route[0] == "admin/department/add" || $route[0] == "admin/department/edit/([0-9]+)") echo "show"; ?>" id="ui-storyline">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item <?php if ($route[0] == "admin/department") echo "active"; ?>"><a class="nav-link" href="<?php echo base_url('admin/department') ?>">All Department</a></li>
                                    <?//php if (in_array('add_challenges',$permissions)) : ?>
                                        <li class="nav-item <?php if ($route[0] == "admin/department/add") echo "active"; ?>"><a class="nav-link" href="<?php echo base_url('admin/department/add') ?>">Add New</a></li>
                                    <?//php endif; ?>
                                </ul>
                            </div>
                        </li>
						 <li class="nav-item  <?php if ($route[0] == "admin/media" || $route[0] == "admin/media/add" || $route[0] == "admin/media/edit/([0-9]+)") echo "active"; ?>">
                            <a class="nav-link" data-toggle="collapse" href="#ui-media" aria-expanded="false" aria-controls="ui-media">
                                <i class="mdi mdi-image-multiple" aria-hidden="true"></i>
                                <span class="menu-title"><?php echo lang('Text.menu.media') ?></span>
                                <i class="menu-arrow"></i>
                            </a>
                            <div class="collapse <?php if ($route[0] == "admin/media" || $route[0] == "admin/media/add" || $route[0] == "admin/media/edit/([0-9]+)") echo "show"; ?>" id="ui-media">
                                <ul class="nav flex-column sub-menu">
                                    <li class="nav-item <?php if ($route[0] == "admin/media") echo "active"; ?>"><a class="nav-link" href="<?php echo base_url('admin/media') ?>"><?php echo lang('Text.menu.all_media') ?></a></li>
                                </ul>
                            </div>
                        </li>
						<li class="nav-item  <?php if ($route[0] == "admin/project" || $route[0] == "admin/project/add" || $route[0] == "admin/project/edit/([0-9]+)") echo "active"; ?>">
							<a class="nav-link" data-toggle="collapse" href="#ui-project" aria-expanded="false" aria-controls="ui-project">
								<i class="mdi mdi-bike" aria-hidden="true"></i>
								<span class="menu-title">Project</span>
								<i class="menu-arrow"></i>
							</a>
							<div class="collapse <?php if ($route[0] == "admin/porject" || $route[0] == "admin/project/add" || $route[0] == "admin/project/edit/([0-9]+)") echo "show"; ?>" id="ui-project">
								<ul class="nav flex-column sub-menu">
									<li class="nav-item <?php if ($route[0] == "admin/project") echo "active"; ?>"><a class="nav-link" href="<?php echo base_url('admin/project') ?>">All Project</a></li>
									<li class="nav-item <?php if ($route[0] == "admin/project/add") echo "active"; ?>"><a class="nav-link" href="<?php echo base_url('admin/project/add') ?>">Add New</a></li>
								</ul>
							</div>
						</li>
                </ul>
            </nav>
            <!-- partial -->
            <div class="main-panel">
                <?= $this->renderSection("content") ?>
                <!-- partial:partials/_footer.html -->
                <footer class="footer">
                    <div class="d-sm-flex justify-content-center justify-content-sm-between">
                        <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">
                            Copyright © <?php echo date('Y') ?>. All rights reserved.
                        </span>
                        <!--<span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Hand-crafted & made with <i class="ti-heart text-danger ml-1"></i> <a href="https://www.nexustechies.com/" target="_blank"> Nexus Techies</a></span>-->
                    </div>
                </footer>
                <!-- partial -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
<?php  
   if(isset($media_img) && !empty($media_img)): ?>
<div class="modal fade media-modal" id="exampleModalScrollablequestions" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalScrollableTitle">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <div class="modal-tabs">
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary show_media_images show_media_images_button active" type="button">Media Gallery</button>
		</div>
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary media_add_image_new show_media_images_button" type="button">Upload</button>
		</div>
	  </div>
      <div class="modal-body" >
        <div class="radio_img checked_image_box" id="media_box">
			<?php 
			   if(isset($media_img) && !empty($media_img)):
				 foreach($media_img as $img):
					$image_id = $model->GetSingleValue(MEDIA_TABLE, 'name', array('id' => $img['id']));
					$path = FCPATH.'/uploads/'.$img['name'];
					if(file_exists($path)):  ?>
						<label class="hints_img_modal img_slt on_checked_image">
							<div class="img-container">
							  <input type="checkbox" class="img_check" name="img_check" id="myCheckbox1" value="<?=$img['id']?>"   style="display:none;"/>
							  <img imgs="<?=$img['id']?>" src="<?php echo base_url('uploads/'.$img['name'])?>">
							</div>
						</label> <?php 
		           endif;
				endforeach;
			endif;
			?>
		</div>
		<div class="row " id="dropzone_box" style="display:none;">
			<div class="col-md-12 user_avatar" >
				<div class="form-group">
					<form action="<?php echo base_url('admin/'.$mr.'/gallery/')?>" id="form" method="post" enctype="multipart/form-data">
						<div class="fallback">
							<div class="dropzone" id="myId" name="files" style="text-align: center"></div>
						</div>
					   <input type="hidden"  name="s" value="okk" >									
					</form>
				</div>
			</div>
		</div>
      </div>
      <div class="modal-footer" >
		<div class="add_img">
			<button class="file-upload-browse btn btn-primary media_add_image" type="button">Submit</button>
		</div>
      </div>
    </div>
  </div>
 <?php  
 endif; ?>
    <!-- plugins:js -->
    <script src="<?php echo base_url('assets/admin/vendors/js/vendor.bundle.base.js') ?>"></script>
	<script src="https://cdn.ckeditor.com/4.16.2/standard-all/ckeditor.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="<?php echo base_url('assets/admin/vendors/chart.js/Chart.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/vendors/datatables.net/jquery.dataTables.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/vendors/datatables.net-bs4/dataTables.bootstrap4.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/dataTables.select.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/admin/dist/dropzone.js')?>"></script>

    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="<?php echo base_url('assets/admin/js/off-canvas.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/hoverable-collapse.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/template.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/settings.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/todolist.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/custom.js') ?>"></script>
    <!-- endinject -->

    <script src="<?php echo base_url('assets/admin/js/dashboard.js') ?>"></script>
    <script src="<?php echo base_url('assets/admin/js/Chart.roundedBarCharts.js') ?>"></script>
    <script src="https://unpkg.com/jquery-resizable-columns@0.2.3/dist/jquery.resizableColumns.min.js"></script>
    <script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>

	<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-migrate/3.0.1/jquery-migrate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jqueryui@1.11.1/jquery-ui.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/akottr/dragtable@master/jquery.dragtable.js"></script>
    

    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/bootstrap-table.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/reorder-columns/bootstrap-table-reorder-columns.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/resizable/bootstrap-table-resizable.min.js"></script>
    <script src="https://unpkg.com/bootstrap-table@1.19.1/dist/extensions/sticky-header/bootstrap-table-sticky-header.min.js"></script>
    <!-- Custom js for this page-->
    <?= $this->renderSection("script") ?>
    <!-- End custom js for this page-->
    <script src="<?php echo base_url('assets/common/js/custom.js?v=' . time()) ?>"></script>
	

</body>

</html>