<div id="sidebar-left">
    <div class="sidebar">
    <?php 
        do_action('comicpress-sidebar-left');
        if ( !dynamic_sidebar('sidebar-left-sidebar') ) { ?>
        <div class="sidebar-no-widgets">
            <?php _e( 'There are currently no widgets assigned to the left-sidebar, place some!', 'comicpress' ); ?>
            <br />
            <br />
            <?php _e( 'Once you add widgets to this sidebar, this default information will go away.', 'comicpress' ); ?>
            <br />
            <br />
            <?php _e( 'Widgets can be added by going to your dashboard (wp-admin) &#10132; Appearance &#10132; Widgets, drag a widget you want to see into one of the appropriate sidebars.', 'comicpress' ); ?>
            <br />
        </div>
        <?php }  ?>
    </div>
</div>
