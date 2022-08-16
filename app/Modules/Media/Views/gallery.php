<?= $this->extend("admin/layout/master") ?>

<?= $this->section('style') ?>
<style>
	.existing_user_avatar img {
		display: block;
	}

	button.btn.btn-primary.mr-2.upload {
		margin: 0px 0 5px 0;
	}

	/* HIDE RADIO */
	[type=radio] {
		position: absolute;
		opacity: 0;
		width: 0;
		height: 0;
	}

	/* IMAGE STYLES */
	[type=radio]+img {
		cursor: pointer;
	}

	/* CHECKED STYLES */
	[type=radio]:checked+img {
		outline: 2px solid #f00;
	}

	.radio_img {
		width: 100% !important;
	}

	.radio_img img {
		width: 200px;
		height: 150px;
	}

	.form-group .text-right {
		padding: 10px 0px;
	}

	.model_view img {
		width: 100%;
		height: auto;
		padding-bottom: 20px;
	}

	.model_view span {
		display: flex;
		font-weight: 500;
	}

	.model_view span p {
		padding-left: 10px;
	}

	.model_view span input {
		margin-left: 10px;
		width: 85%;
		border: 1px solid #000;
	}

	.model_view label {
		width: 100%;
	}

	.gallery_image .image_section .radio_img img {
		cursor: pointer;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<link rel="stylesheet" href="<?php echo base_url('assets/admin/dist/dropzone.css') ?>" />

<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card media-gallery">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title"><?= $module ?></h4>
						</div>
						<div class="col-lg-6 text-right">
							<button type="upload" name="upload" class="btn btn-primary mr-2 upload"><?php echo lang('Text.media.upload') ?></button>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12 user_avatar" style="display:none;">
							<div class="form-group">
								<form action="<?php echo base_url('admin/' . $mr . '/') ?>" id="form" method="post" enctype="multipart/form-data">
									<div class="fallback">
										<div class="dropzone" id="myId" name="files" style="text-align: center"></div>
									</div>
									<div class="col-md-12 text-right">
										<button type="submit" name="submit" class="btn btn-primary mr-2 submit">Submit</button>
									</div>
									<input type="hidden" name="s" value="okk">
								</form>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="gallery_box" style="padding: 20px;">
							<hr>
							<div class="row gallery_image">
								<?php
								if (isset($media_img)  && !empty($media_img)) :
									foreach ($media_img as $img) :
										$path = FCPATH . '/uploads/' . $img['name'];
										if (file_exists($path)) :
								?>
											<!--<label class="img_modal image_section"  src="<?php echo base_url('uploads/' . $img['name']) ?>"  original="<?php echo $img['original_name'] ?>"><span class="cross_icon " data-url="<?php echo base_url('admin/' . $mr . '/remove_image') ?>" 
												data-id="<?= $img['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></span>
											<div class="img-container">
											  <input type="radio" name="test" value="big">
											  <img src="<?php echo base_url('uploads/' . $img['name']) ?>">
											</div>
										</label>-->
											<div class="col-lg-2 image_section img_modal" src="<?php echo base_url('uploads/' . $img['name']) ?>" original="<?php echo $img['original_name'] ?>" style="padding:5px 10px;">
												<div class="radio_img">
													<label class=""><span class="cross_icon " data-url="<?php echo base_url('admin/' . $mr . '/remove_image') ?>" data-id="<?= $img['id'] ?>"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big">
														<input type="hidden" class="image_ids" name="image_ids[]" value="">
														<?php
														$ext = pathinfo($img['name'], PATHINFO_EXTENSION);
														if ($ext == 'mp4' ||  $ext == '3gp') :
															echo '<video autoplay="" loop="" muted="" inline="">
																  <source src="eye-of-the-tiger-video.webm" type="video/webm">
																  <source src="https://www.selluscars.co.za/wp-content/plugins/vehicle-lookup/public//images/selluscars.mp4" type="video/mp4">
																</video>';
														else :
															echo ' <img src="' . base_url('uploads/' . $img['name']) . '">';
														endif; ?>


													</label>
												</div>
											</div>
								<?php
										endif;
									endforeach;
								endif;
								?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade media-gallery-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLongTitle">Modal Image</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="radio_img model_view">
					<div class="modal-img">
						<div class="modal-img-cont" id="imgVideo">
							<img src="" id="myImg">
						</div>
					</div>
					<div class="image-detail">
						<input type="radio" name="test" value="big">
						<span>Origial Name:<p id="org_name" original=""></p></span>
						<span>File url:<input type="text" id="ImgUrl" value="src"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<button type="button" class="btn btn-primary show_model" data-toggle="modal" data-target="#exampleModalCenter" style="display:none;">
	Launch demo modal
</button>
<!-- content-wrapper ends -->
<?= $this->endSection() ?>

<?= $this->section("script") ?>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>

<script src="<?php echo base_url('assets/admin/dist/dropzone.js') ?>"></script>

<script>
	$(document).on('change', '.user_avatar .submit', function(e) {
		var self = $(this);
		var data = new FormData();
		data.append('file', e.target.files[0]);
		$.ajax({
			url: "<?php echo base_url('admin/' . $mr . '/fileUpload') ?>",
			type: "POST",
			data: data,
			enctype: 'multipart/form-data',
			processData: false, // tell jQuery not to process the data
			contentType: false // tell jQuery not to set contentType
		}).done(function(insert_id) {
			console.log(insert_id);
			self.parents('.user_avatar').find('.file').val(insert_id);
		});
		return false;
	});


	Dropzone.autoDiscover = false;
	$("#myId").dropzone({
		url: "<?php echo base_url('admin/' . $mr . '/fileUpload') ?>",
		addRemoveLinks: true,
		maxFilesize: 5,
		dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
		dictResponseError: 'Error uploading file!',
		success: function(file, response) {
			$('#form').append('<input type="hidden" name="attachment_ids[]" class="attachment_ids" value="' + response + '">');
			file.previewElement.getElementsByClassName("dz-remove")[0].setAttribute("data-id", response);
		},
		removedfile: function(file) {
			var id = file.previewElement.getElementsByClassName("dz-remove")[0].getAttribute("data-id");
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/' . $mr . '/delete') ?>/" + id,
				data: {
					id: id
				},
				success: function(response) {
					$("input.attachment_ids").each(function() {
						var exist_val = $(this).val();
						if (exist_val == id) {
							$(this).remove();
						}
					})
				}
			});
			var _ref;
			//return (ref = file.previewElement.parentElement.parentElement.closest("form#myform")) != null ? ref.remove() : void 0;
			return (ref = file.previewElement) != null ? ref.parentNode.removeChild(file.previewElement) : void 0;
		}
	});
	//on deleting
	$(document).on('click', '.cross_icon', function(e) {
		e.preventDefault();
		var self = $(this);
		var data_id = $(this).data('id');
		var gallery_id = $(this).data('gallery_id');
		var data = {
			id: data_id,
			gallery_id: gallery_id,
		};
		var data_url = $(this).data('url');
		swal({
				title: "Are you sure to delete?",
				text: "Deleted Image will not recover!!",
				icon: "warning",
				buttons: true,
				dangerMode: true,
			})
			.then((willDelete) => {
				if (willDelete) {
					//alert(data_url)
					//return false;
					$.ajax({
						url: data_url,
						type: "POST",
						data: data,
						dataType: "json",
						enctype: 'multipart/form-data',
					}).done(function(resp) {
						if (resp.status == "success") {
							swal("Media successfully deleted!", {
								icon: "success",
							}); //.parents('.image_section').remove()
							self.parents(".image_section").remove();
						} else {
							//swal("User has not been deleted!");
						}
					});
				} else {
					//swal("User has not been deleted!");
				}
			});
		return false;
	});
	$(document).on('click', '.upload', function(e) {

		var display = $('.user_avatar').css('display');
		//alert(display);
		if (display == 'block') {
			//true cond
			//alert('remove');
			//$('.radio_img').css('display','none');
		} else {
			//false cond
			//alert('add');
			$('.user_avatar').css('display', 'block');
		}

	});

	$(document).on('click', '.img_modal', function(e) {
		let self = $(this);
		let original_name = $(this).attr('original')
		var src = $('#myImg').attr('src', $(this).attr('src'));
		var ImgUrl = $('#ImgUrl').val($(this).attr('src'));
		var original = $('#org_name').text($(this).attr('original'));
		var getFile = getFileExtension(original_name);
		if (getFile == 'mp4' || getFile == '3gp') {
			$('#imgVideo').html('<video autoplay="" loop="" muted="" inline=""><source src="eye-of-the-tiger-video.webm"type="video/webm"><source src="' + $(this).attr('src') + '" type="video/mp4"></video>');
		} else {
			$('#imgVideo').html('<img src="' + $(this).attr('src') + '" id="myImg">');
		}
		//console.log(src);
		$(".show_model").click();
		//	data-toggle="modal" data-target="#exampleModalCenter"

	});

	function getFileExtension(filename) {
		var ext = /^.+\.([^.]+)$/.exec(filename);
		return ext == null ? "" : ext[1];
	}
</script>
<?= $this->endSection() ?>