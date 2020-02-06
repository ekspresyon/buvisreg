jQuery(document).ready(function($){
	var $uploadViewToggle = $( '.upload-view-toggle' ),
		$body = $( document.body );


		$uploadViewToggle
			.attr({
				role: 'button',
				'aria-expanded': 'false'
			})
			.on( 'click', function( event ) {
				event.preventDefault();
				$body.toggleClass( 'show-upload-view' );
				$uploadViewToggle.attr( 'aria-expanded', $body.hasClass( 'show-upload-view' ) );
			});
		})