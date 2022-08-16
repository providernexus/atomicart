//CKEDITOR.disableAutoInline = true;
$('.editor').each(function () {
CKEDITOR.replace($(this).prop('id'), {
      height: 250,
      extraPlugins: 'colorbutton,colordialog',
      removeButtons: 'PasteFromWord'
    });
});
let base_url = $("#base_url").val();
/* $(document).on('change', 'select', function(e) {
		$(this).next("p.error").remove();
	});
	$(document).on('focus', 'input', function(e) {
		$(this).next("p.error").remove();
	});
	$(document).on('change', 'input', function(e) {
		$(this).next("p.error").remove();
	});
	
	function getFileExtension(filename)
	{
	  var ext = /^.+\.([^.]+)$/.exec(filename);
	  return ext == null ? "" : ext[1];
	}
	//for dropzone
	Dropzone.autoDiscover = false;
    $("#myId").dropzone({
    url: base_url+"/admin/dashboard/fileUpload",
    addRemoveLinks : true,
	removeAllFiles:true,
    maxFilesize: 5,
    dictDefaultMessage: '<span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp&nbsp<h4 class="display-inline"> (Or Click)</h4></span>',
    dictResponseError: 'Error uploading file!',
    success : function(file, response){
		let  obj = JSON.parse(response);
		let new_file_name = obj.name;
       $(".main-panel").append('<input type="hidden" name="attachment_ids[]" src="'+new_file_name+'" class="attachment_ids" value="'+obj.id+'">');
       file.previewElement.getElementsByClassName("dz-remove")[0].setAttribute("data-id",obj.id);
    }, 
    removedfile: function(file) {
		var id =  file.previewElement.getElementsByClassName("dz-remove")[0].getAttribute("data-id");
		$("input.attachment_ids").each(function(){
					var exist_val = $(this).val();
					if(exist_val==id)
					{
						$(this).remove();
					}
				})
			var _ref;
			//return (ref = file.previewElement.parentElement.parentElement.closest("form#myform")) != null ? ref.remove() : void 0;
			return (ref = file.previewElement) != null ? ref.parentNode.removeChild(file.previewElement) : void 0;
	}
});
//for submit
$(document).on('click','button[type="submit"]',function(){
		var self = $(this);
		BtnLoading(self);
		self.parents('form').submit();
	});
	
	//for multiple dropzone  and single dropzone add class 
$(document).on('click','.questions',function(){
	var myDropzone = Dropzone.forElement("#myId");
     myDropzone.removeAllFiles(true); 
	let section_id = $(this).attr('section_id');
	let section_class = $(this).attr('section_class');
	$("#section_id").val(section_id);
	$("#section_id").attr('section_class',section_class);
	let title = $(this).attr('title');
	$("#exampleModalScrollableTitle").html(title);
	$(this).addClass("section_box");
});
//for multiple dropzone add active class and css
$(document).on('click','.on_checked_image',function(e){
	    let checked_value = $(this).find("input").prop("checked");
		let section_class = $("#section_id").attr('section_class');

		//for single image select 
		if(section_class == 'section_hints' || section_class == 'section_background_image'){
			if(checked_value == false){
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").removeAttr('checked');
				$(".img_check").css('display','none');
				$(".on_checked_image").removeClass('on_checked_image_box');
			}
			else{
				$(".img_check").prop('checked', false);
				$(this).find(".img_check").prop('checked', true);
				$(this).find(".img_check").css('display','block');
				$(this).addClass('on_checked_image_box');
			}
		}
		//for multiple image select 
		else{
			    if(checked_value == false){
					//$(".img_check").prop('checked', false);
					$(this).find(".img_check").removeAttr('checked');
					$(this).find(".img_check").css('display','none');
					$(this).removeClass('on_checked_image_box');
				}
				else{
					//$(".img_check").prop('checked', false);
					$(this).find(".img_check").prop('checked', true);
					$(this).find(".img_check").css('display','block');
					$(this).addClass('on_checked_image_box');
				}
		}
	});


  //for media gallery and dropzone
  $(document).on('click','.media_add_image',function(e){
	      let section_class  = $("#section_id").attr('section_class');
	      let section_id  = $("#section_id").val();
		  	//for single image select 
		     if(section_class == 'section_hints' || section_class == 'section_background_image'){
			 	//	alert(section_class)
				 let checked_value = $('.img_check:checked').val();
				 let checked = $('.img_check:checked').prop("checked");
				 let key = "hints[image_id]";
				 //for background
				 if(section_class == 'section_background_image'){
					key = "bg_image";
				 }
				 if(checked == true){
					 let image = $('.img_check:checked').next('img').attr('src');
					 let fillename = getFileExtension(image);
					 const array = ["jpeg","jpg","png","gif"];
					 const isInArray = array.includes(fillename);
					 if(isInArray == true){
					 $('.card-body .'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+checked_value+'"><img src="'+image+'"></label></div></div>');
					 }
				 }else{
					 let value = parseInt($('.attachment_ids').val());
					// alert(value)
					 if(value > 0){
					 let image_url = base_url+"/uploads";
					 let image = image_url+$('.attachment_ids').attr('src'); 
					 let fillename = getFileExtension(image);
					 const array = ["jpeg","jpg","png","gif"];
					 const isInArray = array.includes(fillename);
					 if(isInArray == true){
					 $('.card-body .'+section_class+' .adventures_gallery_images').html('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="'+key+'" value="'+value+'"><img src="'+image+'"></label></div></div>');
					   }
					 }
				 }
			 }
			 else{
				   $('.img_check:checked').each(function () {
						var id = $(this).val();
						let image = $(this).next('img').attr('src');
						let fillename = getFileExtension(image);
						 const array = ["jpeg","jpg","png","gif"];
						 const isInArray = array.includes(fillename);
						 if(isInArray == true){
						   $('.'+section_class+' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions['+section_id+'][image_ids][]" value="'+id+'"><img src="'+image+'"></label></div></div>');
						 }
						$(this).prop("checked", false);
					});
					$('.attachment_ids').each(function () {
						var id = $(this).val();
						let image_url = base_url+'/uploads';
						let image = image_url+$(this).attr('src');
						let fillename = getFileExtension(image);
						const array = ["jpeg","jpg","png","gif"];
						const isInArray = array.includes(fillename);
						if(isInArray == true){
						  $('.'+section_class+' .adventures_gallery_images').prepend('<div class="col-lg-2 image_section" style="padding:5px 15px;"><div  class="radio_img"><label><span class="cross_icon_add"><i class="fa fa-times" aria-hidden="true"></i></span><input type="radio" name="test" value="big"><input type="hidden" class="image_ids" name="questions['+section_id+'][image_ids][]" value="'+id+'"><img src="'+image+'"></label></div></div>');
						}
					}); 
			 }
			//let img_count = $('.image_ids').length;
			//if(img_count > 0){
			//	$('.update_button').css('display','block');
			//}
			$('.adventures_gallery_box').attr('style','display:block;');
			    var myDropzone = Dropzone.forElement("#myId");
                myDropzone.removeAllFiles(true); 
				$(".img_check").css('display','none');
				$(".img_check").prop("checked", false);
				$(".on_checked_image").removeClass('on_checked_image_box');
				$('.attachment_ids').remove();
				$('.close').click();
   });
   
$(document).on('click','.media_add_image_new',function(e){
	$(this).addClass('active');
    // for remove class and checked value
	$(".img_check").prop("checked", false);
	$(".img_check").css('display','none');
	$(".on_checked_image").removeClass('on_checked_image_box');
	$(".show_media_images").removeClass('active');
	$('#media_box').css('display','none');
	$('#dropzone_box').css('display','block');
})
$(document).on('click','.show_media_images',function(e){
	$(this).addClass('active');
	$(".media_add_image_new").removeClass('active');
	$('#media_box').css('display','block');
	$('#dropzone_box').css('display','none');
});
	//on click remove image
	$(document).on('click', '.cross_icon_add', function(e) {
		e.preventDefault();
		$(this).parents(".image_section").remove();
	}); */
/* $('.editor').each(function () {
        CKEDITOR.replace($(this).prop('id'), {
      height: 250,
      extraPlugins: 'colorbutton,colordialog',
      removeButtons: 'PasteFromWord',
       // extraPlugins.'colorbutton,colordialog';
        //removeButtons.'PasteFromWord';
    }); */
	//CKEDITOR.dtd.$removeEmpty['i'] = false;