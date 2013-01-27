$(document).ready(function () {


	$("img").lazyload({
		threshold: 500,
		effect: "fadeIn"
	});
	
	var minlength = 1;
	
	$("#rating").change(function(){
		var tmdb_id = $(this).attr('rel');
		var value = $(this).val();
		$.ajax({
            type: "GET",
            url: "updaterating.php",
            data: {
                'rating' : value,
                'tmdb_id' : tmdb_id
            },
            dataType: "text",
            success: function(msg){
                //we need to check if the value is the same
				if(msg=='ok') {
					alert('done');
				} else {
					alert('problem');
				}
            }
        });
	});
	 
	$("#search").keyup(function () {
	    var that = this,
	    value = $(this).val();
	
	    if (value.length >= minlength ) {
	    	$('#searchicon').removeClass('icon-search').addClass('icon-spinner icon-spin');    
	        $.ajax({
	            type: "GET",
	            url: "search.php",
	            data: {
	                'search_keyword' : value
	            },
	            dataType: "text",
	            success: function(msg) {
	    		$('#searchicon').removeClass('icon-spinner icon-spin').addClass('icon-search');    
	                //we need to check if the value is the same
	                if (value==$(that).val()) {
		               	$('.item').fadeOut().remove();
		               	$("#container").prepend(msg);
	                }
	            }
	        });
	    }
	});
	
	
	
	// Toggle fullscreen button:
    	/*
	$('#fullscreen').click(function () {
        var button = $(this),
            root = document.documentElement;
        if (!button.hasClass('active')) {
            if (root.webkitRequestFullScreen) {
                root.webkitRequestFullScreen(
                    window.Element.ALLOW_KEYBOARD_INPUT
                );
            } else if (root.mozRequestFullScreen) {
                root.mozRequestFullScreen();
            }
        } else {
            (document.webkitCancelFullScreen ||
                document.mozCancelFullScreen ||
                $.noop).apply(document);
        }
    	})
	*/;
});
