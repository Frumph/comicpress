// JavaScript Document

$j("pre").hover(function() {
	var codeInnerWidth = $j("code", this).width() + 10;
	if (codeInnerWidth > 550) {
		$j(this)
			.stop(true, false)
			.css({
				zIndex: "100",
				position: "relative"
			})
			.animate({
				width: codeInnerWidth + "px"
			});
	}
}, function() {
	$j(this).stop(true, false).animate({
		width: 550
	});
});