$(document).ready(function () {

	loadmansonry();

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
	 
	if($('#container').length > 0){
		$('#container').infinitescroll({
	 
		  //navSelector  : "div.navigation",            
		                 // selector for the paged navigation (it will be hidden)
		 
	      //  nextSelector : "div.navigation a:first",    
		                 // selector for the NEXT link (to page 2)
		 
		 // itemSelector : "#content div.post",          
		                 // selector for all items you'll retrieve
		 
		  debug        : true,                        
		                 // enable debug messaging ( to console.log )
		 
		 // loadingImg   : "/img/loading.gif",          
		                 // loading image.
		                 // default: "http://www.infinite-scroll.com/loading.gif"
		 
		  loadingText  : "Loading new posts...",      
		                 // text accompanying loading image
		                 // default: "<em>Loading the next set of posts...</em>"
		 
		  animate      : true,      
		                 // boolean, if the page will do an animated scroll when new content loads
		                 // default: false
		 
		  extraScrollPx: 50,      
		                 // number of additonal pixels that the page will scroll 
		                 // (in addition to the height of the loading div)
		                 // animate must be true for this to matter
		                 // default: 150
		 
		  donetext     : "I think we've hit the end, Jim" ,
		                 // text displayed when all items have been retrieved
		                 // default: "<em>Congratulations, you've reached the end of the internet.</em>"
		 
		  bufferPx     : 40,
		                 // increase this number if you want infscroll to fire quicker
		                 // (a high number means a user will not see the loading message)
		                 // new in 1.2
		                 // default: 40
		 
		  //errorCallback: function(){},
		                 // called when a requested page 404's or when there is no more content
		                 // new in 1.2                   
		 
		  //localMode    : true
		                 // enable an overflow:auto box to have the same functionality
		                 // demo: http://paulirish.com/demo/infscr
		                 // instead of watching the entire window scrolling the element this plugin
		                 //   was called on will be watched
		                 // new in 1.2
		                 // default: false
		 
		 
		    },function(arrayOfNewElems){
		 
		     // optional callback when new content is successfully loaded in.
		 
		     // keyword `this` will refer to the new DOM content that was just added.
		     // as of 1.5, `this` matches the element you called the plugin on (e.g. #content)
		     //                   all the new elements that were found are passed in as an array
		 
		});
	}
	
	$("#search").keyup(function () {
	    var that = this,
	    value = $(this).val();
	
	    if (value.length >= minlength ) {
	        
	        $.ajax({
	            type: "GET",
	            url: "search.php",
	            data: {
	                'search_keyword' : value
	            },
	            dataType: "text",
	            success: function(msg) {
	                //we need to check if the value is the same
	                if (value==$(that).val()) {
		               	$('.item').fadeOut().remove();
		               	$("#container").prepend(msg).masonry('reload');
	                }
	            }
	        });
	    }
	});
	
	$(document).ready(function () {

	loadmansonry();

	var minlength = 2;
	
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
	
	if($('#container').length > 0){
		$('#container').infinitescroll({
	 
		  //navSelector  : "div.navigation",            
		                 // selector for the paged navigation (it will be hidden)
		 
	      //  nextSelector : "div.navigation a:first",    
		                 // selector for the NEXT link (to page 2)
		 
		 // itemSelector : "#content div.post",          
		                 // selector for all items you'll retrieve
		 
		  debug        : true,                        
		                 // enable debug messaging ( to console.log )
		 
		 // loadingImg   : "/img/loading.gif",          
		                 // loading image.
		                 // default: "http://www.infinite-scroll.com/loading.gif"
		 
		  loadingText  : "Loading new posts...",      
		                 // text accompanying loading image
		                 // default: "<em>Loading the next set of posts...</em>"
		 
		  animate      : true,      
		                 // boolean, if the page will do an animated scroll when new content loads
		                 // default: false
		 
		  extraScrollPx: 50,      
		                 // number of additonal pixels that the page will scroll 
		                 // (in addition to the height of the loading div)
		                 // animate must be true for this to matter
		                 // default: 150
		 
		  donetext     : "I think we've hit the end, Jim" ,
		                 // text displayed when all items have been retrieved
		                 // default: "<em>Congratulations, you've reached the end of the internet.</em>"
		 
		  bufferPx     : 40,
		                 // increase this number if you want infscroll to fire quicker
		                 // (a high number means a user will not see the loading message)
		                 // new in 1.2
		                 // default: 40
		 
		  //errorCallback: function(){},
		                 // called when a requested page 404's or when there is no more content
		                 // new in 1.2                   
		 
		  //localMode    : true
		                 // enable an overflow:auto box to have the same functionality
		                 // demo: http://paulirish.com/demo/infscr
		                 // instead of watching the entire window scrolling the element this plugin
		                 //   was called on will be watched
		                 // new in 1.2
		                 // default: false
		 
		 
		    },function(arrayOfNewElems){
		 
		     // optional callback when new content is successfully loaded in.
		 
		     // keyword `this` will refer to the new DOM content that was just added.
		     // as of 1.5, `this` matches the element you called the plugin on (e.g. #content)
		     //                   all the new elements that were found are passed in as an array
		 
		});
	}
	
	$("#search").keyup(function () {
	    var that = this,
	    value = $(this).val();
	
	    if (value.length >= minlength ) {
	    	if($('.item')) {
		    	$('.item').fadeOut(function(){
			    	$(this).remove();
		    	});
	    	}
	        
	        $.ajax({
	            type: "GET",
	            url: "search.php",
	            data: {
	                'search_keyword' : value
	            },
	            dataType: "text",
	            success: function(msg) {
	                //we need to check if the value is the same
	                if (value==$(that).val()) {
	                	$("#container").prepend(msg).masonry('reload');
	                }
	            }
	        });
	    }
	});
	
	// Toggle fullscreen button:
    /* $('#toggle-fullscreen').button().click(function () {
        var button = $(this),
            root = document.documentElement;
        if (!button.hasClass('active')) {
            $('#modal-gallery').addClass('modal-fullscreen');
            if (root.webkitRequestFullScreen) {
                root.webkitRequestFullScreen(
                    window.Element.ALLOW_KEYBOARD_INPUT
                );
            } else if (root.mozRequestFullScreen) {
                root.mozRequestFullScreen();
            }
        } else {
            $('#modal-gallery').removeClass('modal-fullscreen');
            (document.webkitCancelFullScreen ||
                document.mozCancelFullScreen ||
                $.noop).apply(document);
        }
    });
	*/
});

function loadmansonry(){
	$("img").lazyload({
		threshold: 8500,
		effect: "fadeIn"
	});
	var $container = $('#container');
	$container.imagesLoaded( function(){
		$container.masonry({
			animated: true,
			itemSelector : '.item'
		});
	});
}
	
});

function loadmansonry(){
	$("img").lazyload({
		threshold: 8500,
		effect: "fadeIn"
	});
	var $container = $('#container');
	$container.imagesLoaded( function(){
		$container.masonry({
			animated: true,
			itemSelector : '.item'
		});
	});
}