jQuery(document).ready(function () {
    var $ = jQuery, buttonpanel, comicpanes;
    
    // Cache our panes
    comicpanes = $("#comic .comicpane");
    
    if (comicpanes.length > 1) {
        // Make our button panel
        buttonpanel = $('<div id="buttonpanel"></div>');
        
        // Loop over our panes
        comicpanes.each(function (i) {
            var button;

            // Make a button for it
            button = $('<button id="show-' + (i+1) + '">' + (i+1) + '</button>');
            
            // Make the button hide all the comics and show this one
            button.click(function (e) {
                comicpanes.hide().eq(i).show();
            });
            
            // Put the button in the panel
            buttonpanel.append(button);
        });
        
        // Add the panel to the main comic pane
        buttonpanel.appendTo("#comic");
        
        // Hide all but the first strip
        comicpanes.hide().eq(0).show();
    } // if (comicpanes.length > 1)
});