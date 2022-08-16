<?= $this->extend("admin/layout/master") ?>

<?= $this->section("content") ?>

<div class="content-wrapper">
	<div class="row">
		<div class="col-lg-12 grid-margin stretch-card customers_main_box">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title"><?php echo $module ?></h4>
						</div>
						<?php
						if (have_permission('add_customer', 'menu')) :
						?>
							<div class="col-md-6 text-right">
								<a href="<?php echo base_url('admin/customers/add') ?>">
									<button type="button" class="btn btn-primary btn-icon-text btn-sm" style="padding: 15px 20px;"><?php echo lang('Text.customer.add_customer') ?></button>
								</a>
							</div>
						<?php
						endif;
						?>
					</div>
					<?php
					if (!empty(session()->getFlashdata('class'))) { ?>
						<p class="card-description"></p>
						<div class="alert alert-<?php echo session()->getFlashdata('class'); ?>" style="display: block;">
							<button class="close" data-close="alert"></button>
							<span> <?php echo session()->getFlashdata('flash_message'); ?> </span>
						</div>
					<?php
					}
					?>
					<div class="row">
						<div class="col-lg-8">
						</div>
						<div class="col-lg-4 filter_box">
							<form  method="GET" class="tp-search filter_section" action=""  style="display:none;">
								<div class="form-input">
									<label for="name"><b><?php echo lang('Text.customer.customers_f') ?></b></label>
									<input type="text" class="form-control form-control-sm" name="name" value="<?php if (isset($_GET['name'])) {echo $_GET['name'];} ?>" id="teamcode" autocomplete="off" />
								</div>
								<button type="submit" class="btn btn-success btn-icon-text btn-sm">
									<i class="mdi mdi-magnify"></i><?php echo lang('Text.common.search') ?>
								</button>
								<a href="<?php echo base_url('admin/' . $mr) ?>" class="reset-btn">
									<button type="button" class="btn btn-warning btn-icon-text btn-sm">
										<i class="ti-reload btn-icon-prepend"></i><?php echo lang('Text.common.reset') ?>
									</button>
								</a>
							</form>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table" id="table" data-show-toggle="true" data-show-columns="true" data-show-columns-toggle-all="true" data-minimum-count-columns="2" data-reorderable-columns="true" data-resizable="true" data-buttons="buttons">
							<thead>
								<tr>
									<th><?php echo lang('Text.customer.table.name') ?></th>
									<th><?php echo lang('Text.customer.table.email') ?></th>
									<th><?php echo lang('Text.customer.table.phone') ?></th>
									<th><?php echo lang('Text.customer.table.gender') ?></th>
									<th><?php echo lang('Text.customer.table.dob') ?></th>
									<th><?php echo lang('Text.customer.table.status') ?></th>
									<th><?php echo lang('Text.customer.table.created_at') ?></th>
									<th><?php echo lang('Text.customer.table.action') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php if ($results) :
									$have_edit_permission = in_array('edit_customer', $permissions);
									$have_delete_permission = in_array('delete_customer',$permissions);
									$role_id =  session()->get('role_id');
									foreach ($results as $result) :
										$active = "Inactive";
										$status_cls = "danger";
										if ($result['active'] == 1) :
											$active = "Active";
											$status_cls = "success";
										endif;
										$email = $result['email'];
										$phone = $result['phone'];
								?>
										<tr>
											<td><?php echo ucfirst($result['name']) ?></td>
											<td><?php echo $email ?></td>
											<td><?php echo $phone ?></td>
											<td><?php echo gender($result['gender']); ?></td>
											<td><?php if($result['dob']):  echo date('d-M-Y', intval($result['dob'])); endif;?></td>

											<!--<td><?//php echo $status; ?></td>-->
											<td><label class="switch"><input class="check_category_status" value="<?=$result['active'] ?>" type="checkbox" <?php if($result['active']==1){echo 'checked';};?> data-id="<?=$result['id'] ?>"><span class="slider round"></span></label></td>
											
											<td><?php if($result['created_at']): echo date('d-M-Y', intval($result['created_at'])); endif; ?></td>
											<td>
												<?php
												if ($have_edit_permission) : ?>
													<a href="<?php echo base_url('admin/' . $mr . '/edit/' . $result['id']) ?>"><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> <?php echo lang('Text.common.edit') ?></label></a>
												<?php
												endif;
												if ($have_delete_permission) : ?>
													<a class="delete_user" href="#" data-id="<?= $result['id'] ?>" data-url="<?php echo base_url('admin/' . $mr . '/delete') ?>"><label class="badge badge-success"><i class="mdi mdi-delete"></i> <?php echo lang('Text.common.delete') ?></label></a>
												<?php
												endif;    ?>
											</td>
										</tr>
									<?php endforeach; ?>
								<?php else : ?>
									<tr>
										<td>
											<p><?php echo lang('Text.common.data_not_found') ?></p>
										</td>
									</tr>
								<?php endif; ?>
							</tbody>
						</table>
					</div>
					<div class="pagination">
						<?php echo $pagination; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>




<!-- content-wrapper ends -->

<?= $this->endSection() ?>
<?= $this->section("script") ?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
$('.select2').select2();

	//on checking status of user
	$(document).on('change', '.check_user_status', function(e) {
		var self = $(this);
		var data_id = $(this).data('id');
		var current_val = $(this).val();
		var data_url = $(this).data('url');
		if ($(this).is(':checked')) {
			var data = {
				status: 1,
				id: data_id
			};
		} else {
			var data = {
				status: 0,
				id: data_id
			};
		}

		/* if(current_val==1)
		{
			var text_for_swal = "Are you sure to inactive?";
		}
		else{
			var text_for_swal = "Are you sure to active?";
		} */
		console.log(data);
		/* swal({
		  title: "Are you sure?",
		  text: text_for_swal,
		  icon: "warning",
		  buttons: true,
		  dangerMode: true,
		})
		.then((willDelete) => {
		  if (willDelete) { */
		$.ajax({
			url: data_url,
			type: "POST",
			data: data,
			dataType: "json",
			enctype: 'multipart/form-data',
		}).done(function(resp) {
			if (resp.status == "success") {
				self.val(resp.status_value);
				/* swal("Data successfully updated!", {
				  icon: "success",
				}); */
			} else {
				swal("Status has not been changed!");
			}
		});
		/* } else {
			swal("Status has not been changed!");
		  } */
	});


//on checking status of category
 $(document).on('change','.check_category_status',function(e){
 	var self = $(this);
 	var data_id = $(this).data('id');
 	var current_val = $(this).val();
 	if($(this).is(':checked'))
 	{
 		var data = {active: 1 ,id: data_id};
 	}
 	else
 	{
 		var data = {active: 0 ,id: data_id};
 	}

 	if(current_val==1)
 	{
 	//	var text_for_swal = "Are you sure to inactive this category?";
 	}
 	else{
 	//	var text_for_swal = "Are you sure to active this category??";
 	}
 	console.log(data);
/*  	swal({
 		title: "Are you sure?",
 		text: text_for_swal,
 		icon: "warning",
 		buttons: true,
 		dangerMode: true,
 	}) 
 	 .then((willDelete) => {
 		if (willDelete) { */
 			$.ajax({
 				url: "<?php echo base_url('admin/customers/change_status') ?>",
 				type: "POST",
 				data: data,
 				dataType: "json",
 				enctype: 'multipart/form-data',
 			}).done(function(resp) {
 				if(resp.status=="success")
 				{
 					self.val(resp.status_value);
 					/* swal("Data successfully updated!", {
 						icon: "success",
 					}); */
 				}
 				else
 				{
 			//		swal("Status has not been changed!");
 				}
 			});
 		//} else {
 		//	swal("Status has not been changed!");
 	//	}
 	//});
 	return false;
 });

	//on deleting
	$(document).on('click', '.delete_user', function(e) {
		e.preventDefault();
		var self = $(this);
		var data_id = $(this).data('id');
		var data = {
			id: data_id
		};
		var data_url = $(this).data('url');
		swal({
				title: "Are you sure to delete?",
				text: "Deleted user will not recover!!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					$.ajax({
						url: data_url,
						type: "POST",
						data: data,
						dataType: "json",
						enctype: 'multipart/form-data',
					}).done(function(resp) {
						if (resp.status == "success") {
							/* swal("User successfully deleted!", {
							  icon: "success",
							}); */
							self.parents("tr").remove();
						} else {
							swal("User has not been deleted!");
						}
					});
				} else {
					swal("User has not been deleted!");
				}
			});
		return false;
	});
	
	
//filter button
  function buttons () {
    return {
      btnUsersAdd: {
        text: 'Highlight Users',
        icon: 'mdi mdi-tune-vertical',
        event: function () {
		var display= $('.filter_section').css('display');
			//alert(display);
			if(display =='block')
			{
				//true cond
				//alert('remove');
				$('.filter_section').css('display','none');
			}
			else
			{
				//false cond
				//alert('add');
				$('.filter_section').css('display','block');
			}
		 // $(".filter_section").removeClass('d-none');
		//  $(".filter_section").hasClass("d-block")
        //  alert('Do some stuff to e.g. search all users which has logged in the last week')
        },
        attributes: {
          title: 'Search filter'
        }
      },
/*       btnAdd: {
        text: 'Add new row',
        icon: 'fa-plus',
        event: function () {
          alert('Do some stuff to e.g. add a new row')
        },
        attributes: {
          title: 'Add a new row to the table'
        }
      } */
    }
  }

</script>
<?= $this->endSection() ?>