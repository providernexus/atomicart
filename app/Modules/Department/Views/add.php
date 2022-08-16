<?= $this->extend("admin/layout/master") ?>

<?= $this->section("style") ?>
<style>
	.action {
		margin-top: 35px;
	}

	a.remove_row {
		font-size: 35px;
	}

	.favor_in_span {
		color: red;
		font-size: 0.875rem;
	}

	/* IMAGE STYLES */
	[type=radio]+img {
		cursor: pointer;
	}

	/* CHECKED STYLES */
	[type=radio]:checked+img {
		outline: 2px solid #f00;
	}

	input[type="radio"] {
		display: none;
	}

	.add_img {
		text-align: right;
	}

	.radio_img {
		width: 100% !important;
	}

	.radio_img img {
		width: 142px;
		height: 100px;
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

	.modal-dialog {
		max-width: 800px;
		margin: 30px auto;
	}

	.text-right {
		text-align: right !important;
		padding: 0px 0px 10px 0px !important;
	}

	.text-right button.btn.btn-primary.mr-2.submit {
		margin: 0px !important;
	}

	.img_show img {
		width: 100px;
		height: 100px;
		margin: 5px 3px;
	}

	.hints_file .hints_show_img img {
		width: 100px;
		height: 100px;
	}

	.hints_file .hints_show_img {
		padding: 5px 2px;
	}

	.questions_img_modal.questions_img_show {
		width: 100%;
	}

	.questions_img_modal.questions_img_show img {
		width: 100px;
	}

	.choose_file .img_modal.img_show {
		width: 100% !important;
	}

	.img_show img {
		width: 100%;
		height: 200px;
		margin: 5px 3px;
		object-fit: cover;
	}

	hr.spacer {
		margin-bottom: 35px;
	}

	.form-group.task-description {
		margin-bottom: 45px;
	}

	.user_avatar .form-group .input-group-append button {
		background: #57B657 !important;
		border-color: #57B657 !important;
	}

	.user_avatar .form-group .input-group-append button:hover {
		background: #005689 !important;
		border-color: #005689 !important;
	}

	.card .card-title {
		margin-bottom: 10px;
	}

	.card .task-tittle {
		margin-bottom: 14px;
	}

	.adventures_gallery_images .radio_img .cross_icon_add {
		background: #d52929;
		color: #fff;
		display: inline-block;
		padding: 1px 6px;
		border-radius: 100%;
		position: absolute;
		right: -10px;
		top: -10px;
		height: 25px;
		width: 25px;
		-webkit-text-stroke: 1px #d52929;
		cursor: pointer;
	}

	.adventures_gallery_images .radio_img label {
		position: relative;
	}

	.adventures_gallery_images .image_section {
		flex: auto;
		max-width: max-content;
	}
</style>
<?= $this->endSection() ?>

<?= $this->section("content") ?>
<div class="content-wrapper">
	<div class="row">
		<div class="col-12 grid-margin stretch-card">
			<div class="card">
				<div class="card-body">
					<div class="row">
						<div class="col-lg-6">
							<h4 class="card-title"><?= $module ?></h4>
						</div>
					</div>
					<?php if (!empty($errors)) : ?>
						<div class="alert alert-danger errors">
							<?php foreach ($errors as $field => $error) : ?>
								<p><?= $error ?></p>
							<?php endforeach ?>
						</div>
					<?php endif ?>
					<?php echo form_open_multipart('', array('class' => 'forms-sample'), array('s' => 'ok')); ?>
					<div class="row">
					    <div class="col-md-4">
							<div class="form-group">
								<label for="name">Title<span class="favor_in_span">*</span></label>
								<input type="text" class="form-control " id="title" name="title" value="" /><?php echo set_value('title') ?></input>
								<?php if (!empty($errors['title'])) : ?>
									<p class="error"><?= $errors['title'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label for="exampleSelectGender">Parent</label>
								<select class="form-control select2" name="parent_id" id="parent_id">
									<option value="">--<?php echo lang('Text.storyline.table.label.select_parent') ?>--</option>
									<?= $parent_id ?>
								</select>
								<?php if (!empty($errors['parent_id'])) : ?>
									<p class="error"><?= $errors['parent_id'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						
						<div class="col-md-12">
							<div class="form-group">
								 <label for="name">Description<span class="favor_in_span">*</span></label> 
								<textarea type="text" rows="4" cols="50" class="form-control editor" id="description" name="description" value="" id="description" autocomplete="off" /><?php echo set_value('description') ?></textarea>
								<?php if (!empty($errors['description'])) : ?>
									<p class="error"><?= $errors['description'] ?></p>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="row">
								<div class="col-lg-12">
									<h5 class="card-title">Image</h5>
								</div>
								<div class="col-md-12 user_avatar choose_file questions" title="Image" section_class="section_image">
									<div class="form-group">
										<span class="input-group-append">
											<button class="btn btn-primary" id="choose_file" data-toggle="modal" data-target="#exampleModalScrollablequestions" type="button"><?php echo lang('Text.storyline.table.label.choose_image') ?></button>
										</span>
										<label class="img_modal img_show"></label>
									</div>
								</div>

								<!-- for selected image show -->
								<div class="col-md-12 adventures_gallery_box section_image" style="padding: 0px 15px; display:block;">
									<div class="row adventures_gallery_images">
										<?php
										if (isset($_POST['image']) && !empty($_POST['image'])) :
											$image_name = $model->GetSingleValue(MEDIA_TABLE, 'name', array('id' => $_POST['image']));
											$path = FCPATH . '/uploads/' . $image_name;
											if (file_exists($path)) : ?>
												<div class="col-lg-2 image_section" style="padding:5px 15px;">
													<div class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="image" value="<?= $_POST['image'] ?>"><img src="<?= base_url('/uploads/' . $image_name) ?>"></label></div>
												</div>
										<?php
											endif;
										endif;
										?>
									</div>
									<hr>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-6">
							<a href="<?php echo base_url('admin/' . $mr) ?>">
								<button type="button" class="btn btn-primary btn-icon-text btn-sm">
									<i class="mdi mdi-arrow-left" style="font-size: 11px;"></i><span><?php echo lang('Text.common.back') ?></span>
								</button>
							</a>
						</div>
						<div class="col-md-6 text-right">
							<button type="submit" class="btn btn-primary mr-2"><?php echo lang('Text.common.submit') ?></button>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>


<input type="hidden" name="section_id" section_class="" id="section_id" value="">
<!-- content-wrapper ends -->
<link rel="stylesheet" href="//code.jquery.com/ui/1.13.1/themes/base/jquery-ui.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<?= $this->endSection() ?>

<?= $this->section("script") ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>

<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<script src="<?php echo base_url('assets/admin/js/file-upload.js') ?>"></script>

<script>
	//on changing select tag of adventure 
	$(document).on("change", "#adventure_id", function(e) {
		var adventure_id = $(this).val();
		var self = $(this);
		if (adventure_id != '') {
			var data = {
				adventure_id: adventure_id
			}
			$.ajax({
				url: "<?php echo base_url('admin/' . $mr . '/get-challenges'); ?>",
				type: "POST",
				data: data,
				dataType: "json",
				enctype: "multipart/form-data",
			}).done(function(resp) {
				if (resp.status == "success") {
					$("#challenge_id").html(resp.html);
				} else {
					$("#challenge_id").html(resp.html);
				}
			});
		}
	});
	$('.select2').select2();
	Dropzone.autoDiscover = false;
	$("#myId").dropzone({
		url: "<?php echo base_url('admin/' . $mr . '/fileUpload') ?>",
		addRemoveLinks: true,
		removeAllFiles: true,
		maxFilesize: 5,
		dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
		dictResponseError: 'Error uploading file!',
		success: function(file, response) {
			let obj = JSON.parse(response);
			let new_file_name = obj.name;
			$('#form').append('<input type="hidden" name="attachment_ids[]" src="' + new_file_name + '" class="attachment_ids" value="' + obj.id + '">');
			new_file_name.previewElement.getElementsByClassName("dz-remove")[0].setAttribute("data-id", obj.id);
		},
		removedfile: function(file) {
			var id = file.previewElement.getElementsByClassName("dz-remove")[0].getAttribute("data-id");
			$.ajax({
				type: "post",
				url: "<?php echo base_url('admin/' . $mr . '/delete_image') ?>/" + id,
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

	function getFileExtension(filename) {
		var ext = /^.+\.([^.]+)$/.exec(filename);
		return ext == null ? "" : ext[1];
	}
	//hide show password
	function myFunction() {
		$('#eye').removeClass('mdi mdi-eye-off');
		$('#eye').removeClass('mdi mdi-eye');
		var x = document.getElementById("password");
		if (x.type === "password") {
			$('#eye').addClass('mdi mdi-eye');
			x.type = "text";
		} else {
			$('#eye').addClass('mdi mdi-eye-off');
			x.type = "password";
		}
	}

	$(function() {
		var current_year = new Date().getFullYear();
		$("#datepicker").datepicker({
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			yearRange: "1930:" + (current_year - 10),

		});
	});

	$(document).on('click', 'button[type="submit"]', function() {
		var self = $(this);
		BtnLoading(self);
		self.parents('form').submit();
	})

	$(document).on('click', '.img_modal img', function(e) {
		let src = $(this).attr('src');
		let imgs = $(this).attr('imgs');
		$(".img_show").html('<img imgs="' + imgs + '" src="' + src + '">');
		$('#bg_image_id').val(imgs);

	});

	/* $(document).on('click','.img_click',function(e){
		e.preventDefault();
		var display= $('.modal-dialog').css('display');	
		 $('.close').click();	
		if(display =='block')
		{
			//true cond
			$('.modal-dialog').css('display','none');
		}
		else
		{
			//false cond
			//$('.choose_file').css('display','block');
		}
	})
	 */
	//hints model
	$(document).on('click', '.add_hints_img', function(e) {
		e.preventDefault();
		var display = $('.hints_modal').css('display');
		if (display == 'block') {
			//true cond
			//	$('.img_upload').css('display','none');
		} else {
			//false cond
			$('.hints_modal').css('display', 'block');
		}
	})

	$(document).on('click', '.add_hints_img', function(e) {
		e.preventDefault();
		var display = $('.hints_file').css('display');
		$('.close').click();
		if (display == 'block') {
			//true cond
			$('.hints_file').css('display', 'none');
			$('.modal-dialog').css('display', 'none');
		} else {
			//false cond
			//$('.choose_file').css('display','block');
		}
	})

	$(document).on('click', '.hints_img_modal img', function(e) {
		let src = $(this).attr('src');
		let imgs = $(this).attr('imgs');
		//$(".hints_show_img").html('<img imgs="'+imgs+'" src="'+src+'">');
		$('#attachment_id').val(imgs);

	});


	//model 2nd //

	$(document).on('click', '.add_questions', function(e) {
		e.preventDefault();
		var display = $('.questions_modal').css('display');
		if (display == 'block') {
			//true cond
			//	$('.img_upload').css('display','none');
		} else {
			//false cond
			$('.questions_modal').css('display', 'block');
		}
	})

	$(document).on('click', '.add_questions', function(e) {
		e.preventDefault();
		alert('asdd');
		var display = $('.questions').css('display');
		$('.close').click();
		if (display == 'block') {
			//true cond
			$('.questions').css('display', 'none');
			$('.modal-dialog').css('display', 'none');
		} else {
			//false cond
			//$('.choose_file').css('display','block');
		}
	})

	$(document).on('click', '.questions_img_modal img', function(e) {
		let src = $(this).attr('src');
		let imgs = $(this).attr('imgs');
		let image_section = $("#section_id").val();
		$('.' + image_section).append('<img imgs="' + imgs + '" src="' + src + '">');
		$('#questions_id').val(imgs);

	});

	//for multiple dropzone  and single dropzone add class 
	$(document).on('click', '.questions', function() {
		var myDropzone = Dropzone.forElement("#myId");
		myDropzone.removeAllFiles(true);
		let section_id = $(this).attr('section_id');
		let section_class = $(this).attr('section_class');
		$("#section_id").val(section_id);
		$("#section_id").attr('section_class', section_class);
		let title = $(this).attr('title');
		$("#exampleModalScrollableTitle").html(title);
		$(this).addClass("section_box");
	});
	//for multiple dropzone add active class and css
	$(document).on('click', '.on_checked_image', function(e) {
		let checked_value = $(this).find("input").prop("checked");
		let section_class = $("#section_id").attr('section_class');
		//for single image select 
		if (section_class == 'section_image' || section_class == 'section_background_image') {
			if (checked_value == false) {
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").removeAttr('checked');
				$(".img_check").css('display', 'none');
				$(".on_checked_image").removeClass('on_checked_image_box');
			} else {
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").prop('checked', true);
				$(this).find(".img_check").css('display', 'block');
				$(this).addClass('on_checked_image_box');
			}
		}
		//for multiple image select 
		else {
			if (checked_value == false) {
				//$(".img_check").prop('checked', false);
				$(this).find(".img_check").removeAttr('checked');
				$(this).find(".img_check").css('display', 'none');
				$(this).removeClass('on_checked_image_box');
			} else {
				//$(".img_check").prop('checked', false);
				$(this).find(".img_check").prop('checked', true);
				$(this).find(".img_check").css('display', 'block');
				$(this).addClass('on_checked_image_box');
			}
		}
	});


	//for media gallery and dropzone
	$(document).on('click', '.media_add_image', function(e) {
		let section_class = $("#section_id").attr('section_class');
		let section_id = $("#section_id").val();
		//for single image select 
		if (section_class == 'section_image' || section_class == 'section_background_image') {
			let checked_value = $('.img_check:checked').val();
			let checked = $('.img_check:checked').prop("checked");
			let key = "hints[image_id]";
			//for background
			if (section_class == 'section_background_image') {
				key = "bg_image";
			}
			if (section_class == 'section_image') {
				key = "image";
			}
			if (checked == true) {
				let image = $('.img_check:checked').next('img').attr('src');
				let fillename = getFileExtension(image);
				const array = ["jpeg", "jpg", "png", "gif"];
				const isInArray = array.includes(fillename);
				if (isInArray == true) {
					$('.' + section_class + ' .adventures_gallery_images').html('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="' + key + '" value="' + checked_value + '"><img src="' + image + '"></label></div></div>');
				}
			} else {
				let value = parseInt($('.attachment_ids').val());
				if (value > 0) {
					let image_url = '<?php echo base_url('uploads'); ?>/';
					let image = image_url + $('.attachment_ids').attr('src');
					let fillename = getFileExtension(image);
					const array = ["jpeg", "jpg", "png", "gif"];
					const isInArray = array.includes(fillename);
					if (isInArray == true) {
						$('.' + section_class + ' .adventures_gallery_images').html('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="' + key + '" value="' + value + '"><img src="' + image + '"></label></div></div>');
					}
				}
			}
		} else {
			$('.img_check:checked').each(function() {
				var id = $(this).val();
				let image = $(this).next('img').attr('src');
				let fillename = getFileExtension(image);
				const array = ["jpeg", "jpg", "png", "gif"];
				const isInArray = array.includes(fillename);
				if (isInArray == true) {
					$('.' + section_class + ' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions[' + section_id + '][image_ids][]" value="' + id + '"><img src="' + image + '"></label></div></div>');
				}
				$(this).prop("checked", false);
			});
			$('.attachment_ids').each(function() {
				var id = $(this).val();
				let image_url = '<?php echo base_url('uploads'); ?>/';
				let image = image_url + $(this).attr('src');
				let fillename = getFileExtension(image);
				const array = ["jpeg", "jpg", "png", "gif"];
				const isInArray = array.includes(fillename);
				if (isInArray == true) {
					$('.' + section_class + ' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions[' + section_id + '][image_ids][]" value="' + id + '"><img src="' + image + '"></label></div></div>');
				}
			});
		}
		//let img_count = $('.image_ids').length;
		//if(img_count > 0){
		//	$('.update_button').css('display','block');
		//}
		$('.adventures_gallery_box').attr('style', 'display:block;');
		var myDropzone = Dropzone.forElement("#myId");
		myDropzone.removeAllFiles(true);
		$(".img_check").css('display', 'none');
		$(".img_check").prop("checked", false);
		$(".on_checked_image").removeClass('on_checked_image_box');
		$('.attachment_ids').remove();
		$('.close').click();
	});

	$(document).on('click', '.media_add_image_new', function(e) {
		$(this).addClass('active');
		// for remove class and checked value
		$(".img_check").prop("checked", false);
		$(".img_check").css('display', 'none');
		$(".on_checked_image").removeClass('on_checked_image_box');
		$(".show_media_images").removeClass('active');
		$('#media_box').css('display', 'none');
		$('#dropzone_box').css('display', 'block');
	})
	$(document).on('click', '.show_media_images', function(e) {
		$(this).addClass('active');
		$(".media_add_image_new").removeClass('active');
		$('#media_box').css('display', 'block');
		$('#dropzone_box').css('display', 'none');
	});
	//on click remove image
	$(document).on('click', '.cross_icon_add', function(e) {
		e.preventDefault();
		$(this).parents(".image_section").remove();
	});


	//on change
	//	$(document).on('change','#adventure_id',function(){
	//		alert($(this).val());
	//		let adventure_class = $(this).attr('section_class');
	//	})
</script>
<?= $this->endSection() ?>