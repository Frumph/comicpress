/*	Exclude Old IE from showing custom Range Slider with Output Bubble
	Yes, this is an ugly, ugly hack but here is why:
	+ can't use WP global $is_IE variable because it also detects IE 10 & 11, which
	  can actually display the range sliders
	+ on Customize Theme apparently admin_head/admin_foot do not work to place style block
	+ enqueue admin scripts/styles DOES work in Customize Theme page
	+ but IE conditional arguments cannot be used in external stylesheets
	= Solution appears to be to enqueue script to doc write style block with conditionals
	  IE 10 & 11 ignore these conditional tags anyway, so they'll still show range sliders	
*/
document.write('<!--[if IE]><style type="text/css">.range-value{display:none;}</style><![endif]-->');