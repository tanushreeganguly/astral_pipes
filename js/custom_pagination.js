(function($) {
	$.fn.scrollPagination = function(options) {		
		var settings = { 
			nop     : 9, // The number of posts per scroll to be loaded
			offset  : 0, // Initial offset, begins at 0 in this case
			error   : 'No More Posts!', // When the user reaches the end this is the message that is
			                            // displayed. You can change this if you want.
			delay   : 500, // When you scroll down the posts will load after a delayed amount of time.
			               // This is mainly for usability concerns. You can alter this as you see fit
			scroll  : true // The main bit, if set to false posts will not load as the user scrolls. 
			               // but will still load if the user clicks.
		}
		
		// Extend the options so they work with the plugin
		if(options) {
			$.extend(settings, options);
		}
		
		// For each so that we keep chainability.
		return this.each(function() {		
			
			// Some variables 
			$this = $(this);
			$settings = settings;
			var offset = $settings.offset;
			var busy = false; // Checks if the scroll action is happening 
			                  // so we don't run it multiple times
			
			// Custom messages based on settings
			//if($settings.scroll == true) $initmessage = 'View More';
			if($settings.scroll == true) $initmessage = ''; //removed View More @farheen
			//else $initmessage = '<label style="cursor:pointer">View More</label>';
			
			//else $initmessage = '<div class="viewMore loadMore"><a>View More <div class="color-1-bg-light color-bg"></div></a></div>';
			else $initmessage = '<div class="viewMore loadMore"><a><div class="color-1-bg-light color-bg"></div></a></div>'; // @farheen
			
			// Append custom messages and extra UI
			$this.append('<div class="more_updates"></div><div class="viewMore loadMore">'+$initmessage+'</div>');
			//alert(category);
			function getData() {	
				console.log(base_url);
				// Post data to ajax page.
				$.post(base_url, {						
					action        : 'scrollpagination',
				    number        : $settings.nop,
				    offset        : offset,
					//category      : category, //custom variable
					//tags	      : tags, //custom variable
					//csrf_name	  : csrf_hash, //custom variable
					    
				}, function(data) {
					//console.log(data);
					
					// Change loading bar content (it may have been altered)
					$this.find('.loadMore').html($initmessage);
						
					// If there is no data returned, there are no more posts to be shown. Show error
					
					//console.log("length: " + data.length);
					if(data.length <= 75) { 
							//$this.find('.loadMore').html($settings.error);	
							$this.find('.loadMore').html(data);	
					}
					else {
						
						// Offset increases
					    offset = offset+$settings.nop; 						    
						// Append the data to the content div
					   	$this.find('.more_updates').append(data);						
						// No longer busy!	
						busy = false;
					}	
						
				});
					
			}	
			
			getData(); // Run function initially
			
			// If scrolling is enabled
			if($settings.scroll == true) {
				// .. and the user is scrolling
				$(window).scroll(function() {
					
					// Check the user is at the bottom of the element
					if($(window).scrollTop() + $(window).height() > $this.height() && !busy) {
						
						// Now we are working, so busy is true
						busy = true;
						
						// Tell the user we're loading posts
						$this.find('.loadMore').html('');
						
						// Run the function to fetch the data inside a delay
						// This is useful if you have content in a footer you
						// want the user to see.
						setTimeout(function() {
							
							getData();
							
						}, $settings.delay);
							
					}	
				});
			}
			
			// Also content can be loaded by clicking the loading bar/
			$this.find('.loadMore').click(function() {			
				if(busy == false) {
					busy = true;
					getData();
				}			
			});
			
		});
	}

})(jQuery);
