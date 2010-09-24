function equalHeight(group) {
	tallest = 0;
	group.each(function() {
		thisHeight = jQuery(this).height();
		if (thisHeight > tallest) {
			tallest = thisHeight;
		}
	});
	group.height(tallest);
}


jQuery(document).ready(function() {
	equalHeight(jQuery(".sidebar"));
});
