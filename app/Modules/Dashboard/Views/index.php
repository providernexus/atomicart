<?= $this->extend("admin/layout/master") ?>

<?= $this->section("content") ?>
<style>
	a.dashboard_click {
		color: #fff !important;
		text-decoration: none;
	}
</style>
<div class="content-wrapper">
	<div class="row">
		<div class="col-md-12 grid-margin">
			<div class="row">
				<div class="col-8 col-xl-8 mb-4 mb-xl-0">
					<h3 class="font-weight-bold"><?php echo lang('Text.common.welcome') ?> <?php echo session()->get('admin_name') ?></h3>
					<h6 class="font-weight-normal mb-0"><?php echo lang('Text.common.all_systems_are_running_smoothly!') ?></span></h6>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (session()->getFlashdata('flash_message')) { ?>
		<div class="alert alert-<?php echo session()->getFlashdata('class'); ?>" style="display: block;">
			<button class="close" data-close="alert"></button>
			<span> <?php echo session()->getFlashdata('flash_message'); ?> </span>
		</div>
	<?php
	}
	?>
	<!-- Graphs-->
	<!-- End of graphs -->
	<!-- Start of Pie chart membership -->
	<div class="row">
		<!-- Start of tiles -->
		<div class="col-md-12 grid-margin transparent">
			<div class="row">
				
					<div class="col-md-3 mb-4 stretch-card transparent">
						<div class="card card-orange">
							<a href="<?php echo base_url("admin/department") ?>" class="dashboard_click">
								<div class="card-body">
									<p class="mb-4">Total Department</p>
									<p class="fs-30 mb-2"><?php echo $departments; ?></p>
								</div>
							</a>
						</div>
					</div>
	</div>
	</div>
</div>
</div>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>
<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script>
/* 	//profile picture
	 $(document).on('change', '.attachment .file-upload-default', function(e) {
		var tmppath = URL.createObjectURL(event.target.files[0]);
		console.log(tmppath);
	}); */

	//orders count
	/* var data_to_be_filtered = "";
	$(document).ready(function() {
		var data = {
			data_to_be_filtered: data_to_be_filtered
		};
		$.ajax({
			url: "<?php echo base_url('admin/dashboard/initChart'); ?>",
			type: "GET",
			data: data,
			dataType: "json",
		}).done(function(resp) {
			if (resp.status == "success") {
				var label_arr = JSON.parse(JSON.stringify(resp.order_month));
				var order_value = JSON.parse(JSON.stringify(resp.order_value));
				initChart(label_arr, order_value);
			} else {
				console.log(resp);
			}
		});
	});
	 */
	//Monthly Challenges count
	/* $(document).ready(function() {
		 var data = {
			data_to_be_filtered: data_to_be_filtered
		};
		$.ajax({
			url: "<?php echo base_url('admin/dashboard/monthlyCustomers'); ?>",
			type: "GET",
			data: data,
			dataType: "json",
		}).done(function(resp) {
			if (resp.status == "success") {
				var label_arr = JSON.parse(JSON.stringify(resp.customers_month));
				var customers_value = JSON.parse(JSON.stringify(resp.customers_value));
				monthlyCustomers(label_arr, customers_value);
			} else {
				console.log(resp);
			}
		}); 
	}); */

</script> 
<?= $this->endSection() ?>