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
							<div class="col-md-6 text-right">
								<a href="<?php echo base_url('admin/'.$mr.'/add') ?>">
									<button type="button" class="btn btn-primary btn-icon-text btn-sm" style="padding: 15px 20px;">Add New</button>
								</a>
							</div>
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
					$title = '';
					if(isset($_GET['title']) && !empty($_GET['title'])):
					   $title = $_GET['title'];
					endif;
					
					?>
					<!-- Search form -->
					<div class="row">
						<div class="col-lg-8">
						</div>
						<div class="col-lg-4 filter_box">
							<form  method="GET" class="tp-search filter_section" action=""  style="display:none;">
										<div class="form-input">
											<label for="title"><b>Title:</b></label>
											<input type="text" class="form-control form-control-sm" name="title" value="<?=$title?>" id="title" autocomplete="off" data-lpignore="true">
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
					<!-- End of search form -->
					<div class="table-responsive">
						<table class="table" id="table" data-show-toggle="true" data-show-columns="true" data-show-columns-toggle-all="true" data-minimum-count-columns="2" data-reorderable-columns="true" data-resizable="true" data-buttons="buttons">
							<thead>
								<tr>
									<th>Title</th>
									<th>Director</th>
									<th>Studio</th>
									<th>Description</th>
									<th>Created At</th> 
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if ($results) :
									
									$role_id =  session()->get('role_id');
									foreach ($results as $result) :
								/* 	$status = "Inactive";
										$status_cls = "danger";
										if($result['status']==1):
											$status = "Active";
											$status_cls = "success";
										endif; */
									
									/* $parent_story_line = $modal->GetSingleValue(DEPARTMENT_TABLE, 'title', array('id' => $result['parent_id']));
									if(empty($parent_story_line)):
									  $parent_story_line = 'None';
									endif; */
								?>
								<tr>
									<td><?php echo ucfirst($result['title']) ?></td>
									<td><?php echo ucfirst($result['director']) ?></td>
									<td><?php echo ucfirst($result['studio']) ?></td>
								   <?php if (strlen($result['description']) > 10):?>
									<td class="descri"><span class="description"><?php echo substr(strip_tags($result['description']), 0, 7) . '...'; ?></span> <span class="full_description d-none"><?php echo strip_tags($result['description']) ?></span>
									</td>
									<?php else:?>
										<td ><?php echo strip_tags($result['description']) ?></td>
									<?php endif;?>
									
							<!--		<td><?//php echo ucfirst($parent_story_line) ?></td>  -->
									<td><?php echo date('d-M-Y h:i A',$result['created_at']); ?></td>
									<td> 
										<a href="<?php echo base_url('admin/' . $mr . '/edit/' . $result['id']) ?>"><label class="badge badge-success"><i class="mdi mdi-eyedropper"></i> <?php echo lang('Text.common.edit') ?></label></a>
									
										<a class="delete_user" href="#" data-id="<?= $result['id'] ?>" data-url="<?php echo base_url('admin/' . $mr . '/delete') ?>"><label class="badge badge-success"><i class="mdi mdi-delete"></i> <?php echo lang('Text.common.delete') ?></label></a>
								
							<!--			<a class="" href="<?//php echo base_url('admin/' . $mr . '/clone/' . $result['id']) ?>" data-id="<?//= $result['id'] ?>" data-url=""><label class="badge badge-success"><i class="fas fa-clone"></i> Clone</label></a>  -->
										
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
			//	swal("Status has not been changed!");
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
 		var data = {status: 1 ,id: data_id};
 	}
 	else
 	{
 		var data = {status: 0 ,id: data_id};
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
 	}) */
/*  	.then((willDelete) => {
 		if (willDelete) { */
 			$.ajax({
 				url: "<?php echo base_url('admin/'.$mr.'/change_status') ?>",
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
 				//	swal("Status has not been changed!");
 				}
 			});
 		//} else {
 		//	swal("Status has not been changed!");
 		//}
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
				text: "Deleted story will not recover!!",
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
							 swal("Story successfully deleted!", {
							  icon: "success",
							}); 
							self.parents("tr").remove();
						} else {
						//	swal("Challenges has not been deleted!");
						}
					});
				} else {
					//swal("Challenges has not been deleted!");
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
				$('.filter_section').css('display','none');
			}
			else
			{
				//false cond
				$('.filter_section').css('display','block');
			}
        },
        attributes: {
          title: 'Search filter'
        }
      },
    }
  }
</script>
<?= $this->endSection() ?>