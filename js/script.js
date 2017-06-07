$(document).ready(function() {

	//Set matchHeight
	/*if($(".listFiction").length){
		$(".listFiction .nameTitle").matchHeight();
		$(".listFiction .well").matchHeight();
		$(".listFiction .displayThumbnail").matchHeight();
	}*/

	if($(".member-list .thumbnail").length){
		$(".member-list .thumbnail").matchHeight();
	}

	if($(".story-page .meta-story .meta-body").length){
		$(".meta-body > div").matchHeight();
	}

	//Add .form-control class's Bootstrap on the inputs.
	$("form .controls").find(".ccm-input-text").addClass("form-control");
	$(".ccm-input-captcha").addClass("form-control");

	//Enable submit when choose radio value's vote.
	$(".meta-vote input[type='radio']").change(function(){
		$(".meta-vote input[type='submit']").prop("disabled", false);
	});


	if($(".modal").length){
		var modalUniqueClass = ".modal";
		$('.modal').on('show.bs.modal', function(e) {
		  var $element = $(this);
		  var $uniques = $(modalUniqueClass + ':visible').not($(this));
		  if ($uniques.length) {
			$uniques.modal('hide');
			$uniques.one('hidden.bs.modal', function(e) {
			  $element.modal('show');
			});
			return false;
		  }
		});
	}
    
    $(document).bind("contextmenu cut copy",function(e){
        e.preventDefault();
        //alert('Copying is not allowed');
    });

});