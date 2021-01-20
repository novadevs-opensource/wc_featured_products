jQuery(function($){

	// Just one, please.
    $('document').ready(function() {
		
		// Carousel controls
        $('a.carousel-control-prev').on('click', function(e) {
            $('.carousel').carousel('prev')
        });
		
		$('a.carousel-control-next').on('click', function(e) {
            $('.carousel').carousel('next')
        });
		
    });
	
});