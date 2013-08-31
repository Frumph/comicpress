/**
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 * Things like site title and description changes.
 */

( function( $ ) {
	wp.customize('easel_comic_wrap',function( value ) {
		value.bind(function(to) {
			$('#comic-wrap').css('background-color', to ? to : '' );
       	});
 	});
	wp.customize('easel_subcontent_wrapper',function( value ) {
		value.bind(function(to) {
			$('#subcontent-wrapper').css('background-color', to ? to : '' );
       	});
 	});
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			if ( 'blank' == to ) {
				if ( 'remove-header' == _wpCustomizeSettings.values.header_image )
					$( '#header h1 a' ).css( 'min-height', '0' );
				$( '#header h1, .description' ).css( {
					'clip': 'rect(1px, 1px, 1px, 1px)',
					'position': 'absolute'
				} );
			} else {
				$( '#header h1 a' ).css( 'min-height', '230px' );
				$( '#header h1, .description' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
				} );
			}
		} );
	} );
} )( jQuery );
