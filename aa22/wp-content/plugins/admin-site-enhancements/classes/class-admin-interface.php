<?php

namespace ASENHA\Classes;

use  WP_Admin_Bar ;
use  ArrayObject ;
/**
 * Class related to Admin Interface features
 *
 * @since 1.2.0
 */
class Admin_Interface
{
    /**
     * Modify admin bar menu for Admin Interface >> Hide or Modify Elements feature
     *
     * @param $wp_admin_bar object The admin bar.
     * @since 1.9.0
     */
    public function modify_admin_bar_menu( $wp_admin_bar )
    {
        $options = get_option( ASENHA_SLUG_U, array() );
        // Hide WP Logo Menu
        
        if ( array_key_exists( 'hide_ab_wp_logo_menu', $options ) && $options['hide_ab_wp_logo_menu'] ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_wp_menu', 10 );
            // priority needs to match default value. Use QM to reference.
        }
        
        // Hide Customize Menu
        
        if ( array_key_exists( 'hide_ab_customize_menu', $options ) && $options['hide_ab_customize_menu'] ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_customize_menu', 40 );
            // priority needs to match default value. Use QM to reference.
        }
        
        // Hide Updates Counter/Link
        
        if ( array_key_exists( 'hide_ab_updates_menu', $options ) && $options['hide_ab_updates_menu'] ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_updates_menu', 50 );
            // priority needs to match default value. Use QM to reference.
        }
        
        // Hide Comments Counter/Link
        
        if ( array_key_exists( 'hide_ab_comments_menu', $options ) && $options['hide_ab_comments_menu'] ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_comments_menu', 60 );
            // priority needs to match default value. Use QM to reference.
        }
        
        // Hide New Content Menu
        
        if ( array_key_exists( 'hide_ab_new_content_menu', $options ) && $options['hide_ab_new_content_menu'] ) {
            remove_action( 'admin_bar_menu', 'wp_admin_bar_new_content_menu', 70 );
            // priority needs to match default value. Use QM to reference.
        }
        
        // Hide 'Howdy' text
        
        if ( array_key_exists( 'hide_ab_howdy', $options ) && $options['hide_ab_howdy'] ) {
            // Remove the whole my account sectino and later rebuild it
            remove_action( 'admin_bar_menu', 'wp_admin_bar_my_account_item', 7 );
            $current_user = wp_get_current_user();
            $user_id = get_current_user_id();
            $profile_url = get_edit_profile_url( $user_id );
            $avatar = get_avatar( $user_id, 26 );
            // size 26x26 pixels
            $display_name = $current_user->display_name;
            $class = 'with-avatar';
            $wp_admin_bar->add_menu( array(
                'id'     => 'my-account',
                'parent' => 'top-secondary',
                'title'  => $display_name . $avatar,
                'href'   => $profile_url,
                'meta'   => array(
                'class' => $class,
            ),
            ) );
        }
    
    }
    
    /**
     * Wrapper for admin notices being output on admin screens
     *
     * @since 1.2.0
     */
    public function admin_notices_wrapper()
    {
        if ( current_user_can( 'manage_options' ) ) {
            echo  '<div class="asenha-admin-notices-drawer" style="display:none;"><h2>Admin Notices</h2></div>' ;
        }
    }
    
    /**
     * Admin bar menu item for the hidden admin notices
     *
     * @link https://developer.wordpress.org/reference/classes/wp_admin_bar/add_menu/
     * @link https://developer.wordpress.org/reference/classes/wp_admin_bar/add_node/
     * @since 1.2.0
     */
    public function admin_notices_menu( WP_Admin_Bar $wp_admin_bar )
    {
        if ( current_user_can( 'manage_options' ) ) {
            $wp_admin_bar->add_menu( array(
                'id'     => 'asenha-hide-admin-notices',
                'parent' => 'top-secondary',
                'grou'   => null,
                'title'  => 'Notices<span class="asenha-admin-notices-counter" style="opacity:0;">0</span>',
                'meta'   => array(
                'class' => 'asenha-admin-notices-menu',
                'title' => 'Click to view hidden admin notices',
            ),
            ) );
        }
    }
    
    /**
     * Inline CSS for the admin bar notices menu
     *
     * @since 1.2.0
     */
    public function admin_notices_menu_inline_css()
    {
        
        if ( current_user_can( 'manage_options' ) ) {
            wp_add_inline_style( 'admin-bar', '

				#wpadminbar .asenha-admin-notices-counter {
					box-sizing: border-box;
					margin: 1px 0 -1px 6px ;
					padding: 2px 6px 3px 5px;
					min-width: 18px;
					height: 18px;
					border-radius: 50%;
					background-color: #ca4a1f;
					color: #fff;
					font-size: 11px;
					line-height: 1.6;
					text-align: center;
				}

			' );
            // Below we pre-emptively hide notices to avoid having them shown briefly before being moved into the notices panel via JS
            ?>
			<style type="text/css">
				#wpbody-content .notice:not(.system-notice,.update-message),
				#wpbody-content .notice-error,
				#wpbody-content .error,
				#wpbody-content .notice-info,
				#wpbody-content .notice-information,
				#wpbody-content #message,
				#wpbody-content .notice-warning:not(.update-message),
				#wpbody-content .notice-success:not(.update-message),
				#wpbody-content .notice-updated,
				#wpbody-content .updated:not(.active, .inactive, .plugin-update-tr),
				#wpbody-content .update-nag,
				#wpbody-content > .wrap > .notice:not(.system-notice),
				#wpbody-content > .wrap > .notice-error,
				#wpbody-content > .wrap > .error,
				#wpbody-content > .wrap > .notice-info,
				#wpbody-content > .wrap > .notice-information,
				#wpbody-content > .wrap > #message,
				#wpbody-content > .wrap > .notice-warning,
				#wpbody-content > .wrap > .notice-success,
				#wpbody-content > .wrap > .notice-updated,
				#wpbody-content > .wrap > .updated,
				#wpbody-content > .wrap > .update-nag,
				#wpbody-content > .wrap > div > .notice:not(.system-notice),
				#wpbody-content > .wrap > div > .notice-error,
				#wpbody-content > .wrap > div > .error,
				#wpbody-content > .wrap > div > .notice-info,
				#wpbody-content > .wrap > div > .notice-information,
				#wpbody-content > .wrap > div > #message,
				#wpbody-content > .wrap > div > .notice-warning,
				#wpbody-content > .wrap > div > .notice-success,
				#wpbody-content > .wrap > div > .notice-updated,
				#wpbody-content > .wrap > div > .updated,
				#wpbody-content > .wrap > div > .update-nag,
				#wpbody-content > div > .wrap > .notice:not(.system-notice),
				#wpbody-content > div > .wrap > .notice-error,
				#wpbody-content > div > .wrap > .error,
				#wpbody-content > div > .wrap > .notice-info,
				#wpbody-content > div > .wrap > .notice-information,
				#wpbody-content > div > .wrap > #message,
				#wpbody-content > div > .wrap > .notice-warning,
				#wpbody-content > div > .wrap > .notice-success,
				#wpbody-content > div > .wrap > .notice-updated,
				#wpbody-content > div > .wrap > .updated,
				#wpbody-content > div > .wrap > .update-nag,
				#wpbody-content > .update-nag,
				#wpbody-content > .notice,
				#wpbody-content > .jp-connection-banner,
				#wpbody-content > .jitm-banner,
				#wpbody-content > .jetpack-jitm-message,
				#wpbody-content > .ngg_admin_notice,
				#wpbody-content > .imagify-welcome,
				#wpbody-content #wordfenceAutoUpdateChoice,
				#wpbody-content #easy-updates-manager-dashnotice {
					display: none !important;
				}
			</style>
			<?php 
        }
    
    }
    
    /**
     * Disable dashboard widgets
     *
     * @since 4.2.0
     */
    public function disable_dashboard_widgets()
    {
        global  $wp_meta_boxes ;
        // Get list of disabled widgets
        $options = get_option( ASENHA_SLUG_U, array() );
        $disabled_dashboard_widgets = $options['disabled_dashboard_widgets'];
        // Store default widgets in extra options. This will be referenced from settings field.
        $dashboard_widgets = $this->get_dashboard_widgets();
        $extra_options = get_option( 'admin_site_enhancements_extra', array() );
        $extra_options['dashboard_widgets'] = $dashboard_widgets;
        update_option( 'admin_site_enhancements_extra', $extra_options );
        // Disable widgets
        if ( is_array( $disabled_dashboard_widgets ) || is_object( $disabled_dashboard_widgets ) ) {
            foreach ( $disabled_dashboard_widgets as $disabled_widget_id_context_priority => $is_disabled ) {
                // e.g. dashboard_activity__normal__core => true/false
                
                if ( $is_disabled ) {
                    $disabled_widget = explode( '__', $disabled_widget_id_context_priority );
                    $widget_id = $disabled_widget[0];
                    $widget_context = $disabled_widget[1];
                    $widget_priority = $disabled_widget[2];
                    // remove_meta_box( $widget_id, get_current_screen()->base, $widget_context );
                    unset( $wp_meta_boxes['dashboard'][$widget_context][$widget_priority][$widget_id] );
                }
            
            }
        }
    }
    
    /**
     * Get dashboard widgets
     *
     * @since 4.2.0
     */
    public function get_dashboard_widgets()
    {
        global  $wp_meta_boxes ;
        $dashboard_widgets = array();
        
        if ( !isset( $wp_meta_boxes['dashboard'] ) ) {
            $extra_options = get_option( 'admin_site_enhancements_extra', array() );
            
            if ( !array_key_exists( 'dashboard_widgets', $extra_options ) ) {
                require_once ABSPATH . '/wp-admin/includes/dashboard.php';
                set_current_screen( 'dashboard' );
                wp_dashboard_setup();
            }
        
        }
        
        if ( isset( $wp_meta_boxes['dashboard'] ) ) {
            foreach ( $wp_meta_boxes['dashboard'] as $context => $priorities ) {
                foreach ( $priorities as $priority => $widgets ) {
                    foreach ( $widgets as $widget_id => $data ) {
                        $widget_title = ( isset( $data['title'] ) ? wp_strip_all_tags( preg_replace( '/ <span.*span>/im', '', $data['title'] ) ) : 'Undetectable' );
                        $dashboard_widgets[$widget_id] = array(
                            'id'       => $widget_id,
                            'title'    => $widget_title,
                            'context'  => $context,
                            'priority' => $priority,
                        );
                    }
                }
            }
        }
        $dashboard_widgets = wp_list_sort(
            $dashboard_widgets,
            'title',
            'ASC',
            true
        );
        return $dashboard_widgets;
    }
    
    /**
     * Hide admin bar on the frontend for the user roles selected
     *
     * @since 1.3.0
     */
    public function hide_admin_bar_for_roles()
    {
        $options = get_option( ASENHA_SLUG_U );
        $hide_admin_bar = $options['hide_admin_bar'];
        $for_roles = $options['hide_admin_bar_for'];
        $current_user = wp_get_current_user();
        $current_user_roles = (array) $current_user->roles;
        // single dimensional array of role slugs
        // User has no role, i.e. logged-out
        
        if ( count( $current_user_roles ) == 0 ) {
            return false;
            // hide admin bar
        }
        
        // User has role(s). Do further checks.
        
        if ( isset( $for_roles ) && count( $for_roles ) > 0 ) {
            // Assemble single-dimensional array of roles for which admin bar would be hidden
            $roles_admin_bar_hidden = array();
            foreach ( $for_roles as $role_slug => $admin_bar_hidden ) {
                if ( $admin_bar_hidden ) {
                    $roles_admin_bar_hidden[] = $role_slug;
                }
            }
            // Check if any of the current user roles is one for which admin bar should be hidden
            foreach ( $current_user_roles as $role ) {
                
                if ( in_array( $role, $roles_admin_bar_hidden ) ) {
                    return false;
                    // hide admin bar
                }
            
            }
        }
        
        return true;
        // show admin bar
    }
    
    /**
     * Set custom admin menu width
     * 
     * @since 5.2.0
     */
    public function set_custom_menu_width()
    {
        $options = get_option( ASENHA_SLUG_U, array() );
        $custom_width = $options['admin_menu_width'];
        $wp_version = get_bloginfo( 'version' );
        
        if ( version_compare( $wp_version, '5', '>' ) ) {
            require_once ASENHA_PATH . 'includes/admin-menu-width/wp-v5-greater.php';
        } elseif ( version_compare( $wp_version, '4', '>=' ) ) {
            require_once ASENHA_PATH . 'includes/admin-menu-width/wp-v4-greater.php';
        } else {
        }
    
    }
    
    /**
     * Render custom menu order
     *
     * @param $menu_order array an ordered array of menu items
     * @link https://developer.wordpress.org/reference/hooks/menu_order/
     * @since 2.0.0
     */
    public function render_custom_menu_order( $menu_order )
    {
        global  $menu ;
        $options = get_option( ASENHA_SLUG_U );
        // Get current menu order. We're not using the default $menu_order which uses index.php, edit.php as array values.
        $current_menu_order = array();
        foreach ( $menu as $menu_key => $menu_info ) {
            
            if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
                $menu_item_id = $menu_info[2];
            } else {
                $menu_item_id = $menu_info[5];
            }
            
            $current_menu_order[] = array( $menu_item_id, $menu_info[2] );
        }
        // Get custom menu order
        $custom_menu_order = $options['custom_menu_order'];
        // comma separated
        $custom_menu_order = explode( ",", $custom_menu_order );
        // array of menu ID, e.g. menu-dashboard
        // Return menu order for rendering
        $rendered_menu_order = array();
        // Render menu based on items saved in custom menu order
        foreach ( $custom_menu_order as $custom_menu_item_id ) {
            foreach ( $current_menu_order as $current_menu_item_id => $current_menu_item ) {
                if ( $custom_menu_item_id == $current_menu_item[0] ) {
                    $rendered_menu_order[] = $current_menu_item[1];
                }
            }
        }
        // Add items from current menu not already part of custom menu order, e.g. new plugin activated and adds new menu item
        foreach ( $current_menu_order as $current_menu_item_id => $current_menu_item ) {
            if ( !in_array( $current_menu_item[0], $custom_menu_order ) ) {
                $rendered_menu_order[] = $current_menu_item[1];
            }
        }
        return $rendered_menu_order;
    }
    
    /**
     * Apply custom menu item titles
     *
     * @since 2.9.0
     */
    public function apply_custom_menu_item_titles()
    {
        global  $menu ;
        $options = get_option( ASENHA_SLUG_U );
        // Get custom menu item titles
        $custom_menu_titles = $options['custom_menu_titles'];
        $custom_menu_titles = explode( ',', $custom_menu_titles );
        foreach ( $menu as $menu_key => $menu_info ) {
            
            if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
                $menu_item_id = $menu_info[2];
            } else {
                $menu_item_id = $menu_info[5];
            }
            
            // Get defaul/custom menu item title
            foreach ( $custom_menu_titles as $custom_menu_title ) {
                // At this point, $custom_menu_title value looks like toplevel_page_snippets__Code Snippets
                $custom_menu_title = explode( '__', $custom_menu_title );
                
                if ( $custom_menu_title[0] == $menu_item_id ) {
                    $menu_item_title = $custom_menu_title[1];
                    // e.g. Code Snippets
                    break;
                    // stop foreach loop so $menu_item_title is not overwritten in the next iteration
                } else {
                    $menu_item_title = $menu_info[0];
                }
            
            }
            $menu[$menu_key][0] = $menu_item_title;
        }
    }
    
    /**
     * Hide menu items by adding a class to hide them (part of WP Core's common.css)
     *
     * @since 2.0.0
     */
    public function hide_menu_items()
    {
        global  $menu ;
        $common_methods = new Common_Methods();
        $menu_hidden_by_toggle = $common_methods->get_menu_hidden_by_toggle();
        // indexed array
        foreach ( $menu as $menu_key => $menu_info ) {
            
            if ( false !== strpos( $menu_info[4], 'wp-menu-separator' ) ) {
                $menu_item_id = $menu_info[2];
            } else {
                $menu_item_id = $menu_info[5];
            }
            
            // Append 'hidden' class to hide menu item until toggled
            if ( in_array( $menu_item_id, $menu_hidden_by_toggle ) ) {
                $menu[$menu_key][4] = $menu_info[4] . ' hidden asenha_hidden_menu';
            }
        }
    }
    
    /**
     * Add toggle to show hidden menu items
     *
     * @since 2.0.0
     */
    public function add_hidden_menu_toggle()
    {
        global  $current_user ;
        // Get menu items hidden by toggle
        $common_methods = new Common_Methods();
        $menu_hidden_by_toggle = $common_methods->get_menu_hidden_by_toggle();
        // Get user capabilities the "Show All/Less" toggle should be shown for
        $user_capabilities_to_show_menu_toggle_for = $common_methods->get_user_capabilities_to_show_menu_toggle_for();
        // Get current user's capabilities from the user's role(s)
        $current_user_capabilities = '';
        $current_user_roles = $current_user->roles;
        // indexed array of role slugs
        foreach ( $current_user_roles as $current_user_role ) {
            $current_user_role_capabilities = get_role( $current_user_role )->capabilities;
            $current_user_role_capabilities = array_keys( $current_user_role_capabilities );
            // indexed array
            $current_user_role_capabilities = implode( ",", $current_user_role_capabilities );
            $current_user_capabilities .= $current_user_role_capabilities;
        }
        $current_user_capabilities = array_unique( explode( ",", $current_user_capabilities ) );
        // Maybe show "Show All/Less" toggle
        $show_toggle_menu = false;
        foreach ( $user_capabilities_to_show_menu_toggle_for as $user_capability_to_show_menu_toggle_for ) {
            
            if ( in_array( $user_capability_to_show_menu_toggle_for, $current_user_capabilities ) ) {
                $show_toggle_menu = true;
                break;
            }
        
        }
        
        if ( !empty($menu_hidden_by_toggle) && $show_toggle_menu ) {
            add_menu_page(
                'Show All',
                'Show All',
                'read',
                'asenha_show_hidden_menu',
                function () {
                return false;
            },
                "dashicons-arrow-down-alt2",
                300
            );
            add_menu_page(
                'Show Less',
                'Show Less',
                'read',
                'asenha_hide_hidden_menu',
                function () {
                return false;
            },
                "dashicons-arrow-up-alt2",
                301
            );
        }
    
    }
    
    /**
     * Script to toggle hidden menu itesm
     *
     * @since 2.0.0
     */
    public function enqueue_toggle_hidden_menu_script()
    {
        // Get menu items hidden by toggle
        $common_methods = new Common_Methods();
        $menu_hidden_by_toggle = $common_methods->get_menu_hidden_by_toggle();
        if ( !empty($menu_hidden_by_toggle) ) {
            // Script to set behaviour and actions of the sortable menu
            wp_enqueue_script(
                'asenha-toggle-hidden-menu',
                ASENHA_URL . 'assets/js/toggle-hidden-menu.js',
                array(),
                ASENHA_VERSION,
                false
            );
        }
    }
    
    /**
     * Hide the Help tab and drawer
     *
     * @since 4.5.0
     */
    public function hide_help_drawer()
    {
        
        if ( is_admin() ) {
            $screen = get_current_screen();
            $screen->remove_help_tabs();
        }
    
    }
    
    /**
     * Current post type. For Content Admin >> Show Custom Taxonomy Filters functionality.
     */
    public  $post_type ;
    /**
     * Show featured images column in list tables for pages and post types that support featured image
     *
     * @since 1.0.0
     */
    public function show_featured_image_column()
    {
        $post_types = get_post_types( array(
            'public' => true,
        ), 'names' );
        foreach ( $post_types as $post_type_key => $post_type_name ) {
            
            if ( post_type_supports( $post_type_key, 'thumbnail' ) ) {
                add_filter( "manage_{$post_type_name}_posts_columns", [ $this, 'add_featured_image_column' ], 999 );
                add_action(
                    "manage_{$post_type_name}_posts_custom_column",
                    [ $this, 'add_featured_image' ],
                    10,
                    2
                );
            }
        
        }
    }
    
    /**
     * Add a column called Featured Image as the first column
     *
     * @param mixed $columns
     * @return void
     * @since 1.0.0
     */
    public function add_featured_image_column( $columns )
    {
        $new_columns = array();
        foreach ( $columns as $key => $value ) {
            if ( 'title' == $key ) {
                // We add featured image column before the 'title' column
                $new_columns['asenha-featured-image'] = 'Featured Image';
            }
            if ( 'thumb' == $key ) {
                // For WooCommerce products, we add featured image column before it's native thumbnail column
                $new_columns['asenha-featured-image'] = 'Product Image';
            }
            $new_columns[$key] = $value;
        }
        // Replace WooCommerce thumbnail column with ASE featured image column
        if ( array_key_exists( 'thumb', $new_columns ) ) {
            unset( $new_columns['thumb'] );
        }
        return $new_columns;
    }
    
    /**
     * Echo featured image's in thumbnail size to a column
     *
     * @param mixed $column_name
     * @param mixed $id
     * @since 1.0.0
     */
    public function add_featured_image( $column_name, $id )
    {
        if ( 'asenha-featured-image' === $column_name ) {
            
            if ( has_post_thumbnail( $id ) ) {
                $size = 'thumbnail';
                echo  get_the_post_thumbnail( $id, $size, '' ) ;
            } else {
                echo  '<img src="' . esc_url( plugins_url( 'assets/img/default_featured_image.jpg', __DIR__ ) ) . '" />' ;
            }
        
        }
    }
    
    /**
     * Show excerpt column in list tables for pages and post types that support excerpt.
     *
     * @since 1.0.0
     */
    public function show_excerpt_column()
    {
        $post_types = get_post_types( array(
            'public' => true,
        ), 'names' );
        foreach ( $post_types as $post_type_key => $post_type_name ) {
            
            if ( post_type_supports( $post_type_key, 'excerpt' ) ) {
                add_filter( "manage_{$post_type_name}_posts_columns", [ $this, 'add_excerpt_column' ] );
                add_action(
                    "manage_{$post_type_name}_posts_custom_column",
                    [ $this, 'add_excerpt' ],
                    10,
                    2
                );
            }
        
        }
    }
    
    /**
     * Add a column called Featured Image as the first column
     *
     * @param mixed $columns
     * @return void
     * @since 1.0.0
     */
    public function add_excerpt_column( $columns )
    {
        $new_columns = array();
        foreach ( $columns as $key => $value ) {
            $new_columns[$key] = $value;
            if ( $key == 'title' ) {
                $new_columns['asenha-excerpt'] = 'Excerpt';
            }
        }
        return $new_columns;
    }
    
    /**
     * Echo featured image's in thumbnail size to a column
     *
     * @param mixed $column_name
     * @param mixed $id
     * @since 1.0.0
     */
    public function add_excerpt( $column_name, $id )
    {
        
        if ( 'asenha-excerpt' === $column_name ) {
            $excerpt = get_the_excerpt( $id );
            // about 310 characters
            $excerpt = substr( $excerpt, 0, 160 );
            // truncate to 160 characters
            $short_excerpt = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
            echo  wp_kses_post( $short_excerpt ) ;
        }
    
    }
    
    /**
     * Add ID column list table of pages, posts, custom post types, media, taxonomies, custom taxonomies, users amd comments
     *
     * @since 1.0.0
     */
    public function show_id_column()
    {
        // For pages and hierarchical post types list table
        add_filter( 'manage_pages_columns', [ $this, 'add_id_column' ] );
        add_action(
            'manage_pages_custom_column',
            [ $this, 'add_id_echo_value' ],
            10,
            2
        );
        // For posts and non-hierarchical custom posts list table
        add_filter( 'manage_posts_columns', [ $this, 'add_id_column' ] );
        add_action(
            'manage_posts_custom_column',
            [ $this, 'add_id_echo_value' ],
            10,
            2
        );
        // For media list table
        add_filter( 'manage_media_columns', [ $this, 'add_id_column' ] );
        add_action(
            'manage_media_custom_column',
            [ $this, 'add_id_echo_value' ],
            10,
            2
        );
        // For list table of all taxonomies
        $taxonomies = get_taxonomies( [
            'public' => true,
        ], 'names' );
        foreach ( $taxonomies as $taxonomy ) {
            add_filter( 'manage_edit-' . $taxonomy . '_columns', [ $this, 'add_id_column' ] );
            add_action(
                'manage_' . $taxonomy . '_custom_column',
                [ $this, 'add_id_return_value' ],
                10,
                3
            );
        }
        // For users list table
        add_filter( 'manage_users_columns', [ $this, 'add_id_column' ] );
        add_action(
            'manage_users_custom_column',
            [ $this, 'add_id_return_value' ],
            10,
            3
        );
        // For comments list table
        add_filter( 'manage_edit-comments_columns', [ $this, 'add_id_column' ] );
        add_action(
            'manage_comments_custom_column',
            [ $this, 'add_id_echo_value' ],
            10,
            3
        );
    }
    
    /**
     * Add a column called ID
     *
     * @param mixed $columns
     * @return void
     * @since 1.0.0
     */
    public function add_id_column( $columns )
    {
        $columns['asenha-id'] = 'ID';
        return $columns;
    }
    
    /**
     * Echo post ID value to a column
     *
     * @param mixed $column_name
     * @param mixed $id
     * @since 1.0.0
     */
    public function add_id_echo_value( $column_name, $id )
    {
        if ( 'asenha-id' === $column_name ) {
            echo  esc_html( $id ) ;
        }
    }
    
    /**
     * Return post ID value to a column
     *
     * @param mixed $value
     * @param mixed $column_name
     * @param mixed $id
     * @since 1.0.0
     */
    public function add_id_return_value( $value, $column_name, $id )
    {
        if ( 'asenha-id' === $column_name ) {
            $value = $id;
        }
        return $value;
    }
    
    /**
     * Add ID in the action row of list tables for pages, posts, custom post types, media, taxonomies, custom taxonomies, users amd comments
     *
     * @since 4.7.4
     */
    public function show_id_in_action_row()
    {
        add_filter(
            'page_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'post_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'cat_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'tag_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'media_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'comment_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
        add_filter(
            'user_row_actions',
            array( $this, 'add_id_in_action_row' ),
            10,
            2
        );
    }
    
    /**
     * Output the ID in the action row
     *
     * @since 4.7.4
     */
    public function add_id_in_action_row( $actions, $object )
    {
        
        if ( current_user_can( 'edit_posts' ) ) {
            // For pages, posts, custom post types, media/attachments, users
            if ( property_exists( $object, 'ID' ) ) {
                $id = $object->ID;
            }
            // For taxonomies
            if ( property_exists( $object, 'term_id' ) ) {
                $id = $object->term_id;
            }
            // For comments
            if ( property_exists( $object, 'comment_ID' ) ) {
                $id = $object->comment_ID;
            }
            $actions['asenha-list-table-item-id'] = '<span class="asenha-list-table-item-id">ID: ' . $id . '</span>';
        }
        
        return $actions;
    }
    
    /**
     * Hide comments column in list tables for pages, post types that support comments, and alse media/attachments.
     *
     * @since 1.0.0
     */
    public function hide_comments_column()
    {
        $post_types = get_post_types( array(
            'public' => true,
        ), 'names' );
        foreach ( $post_types as $post_type_key => $post_type_name ) {
            if ( post_type_supports( $post_type_key, 'comments' ) ) {
                
                if ( 'attachment' != $post_type_name ) {
                    // For list tables of pages, posts and other post types
                    add_filter( "manage_{$post_type_name}_posts_columns", [ $this, 'remove_comment_column' ] );
                } else {
                    // For list table of media/attachment
                    add_filter( 'manage_media_columns', [ $this, 'remove_comment_column' ] );
                }
            
            }
        }
    }
    
    /**
     * Add a column called ID
     *
     * @param mixed $columns
     * @return void
     * @since 1.0.0
     */
    public function remove_comment_column( $columns )
    {
        unset( $columns['comments'] );
        return $columns;
    }
    
    /**
     * Hide tags column in list tables for posts.
     *
     * @since 1.0.0
     */
    public function hide_post_tags_column()
    {
        $post_types = get_post_types( array(
            'public' => true,
        ), 'names' );
        foreach ( $post_types as $post_type_key => $post_type_name ) {
            if ( $post_type_name == 'post' ) {
                add_filter( "manage_posts_columns", [ $this, 'remove_post_tags_column' ] );
            }
        }
    }
    
    /**
     * Add a column called ID
     *
     * @param mixed $columns
     * @return void
     * @since 1.0.0
     */
    public function remove_post_tags_column( $columns )
    {
        unset( $columns['tags'] );
        return $columns;
    }
    
    /**
     * Show custom (hierarchical) taxonomy filter(s) for all post types.
     *
     * @since 1.0.0
     */
    public function show_custom_taxonomy_filters( $post_type )
    {
        $post_taxonomies = get_object_taxonomies( $post_type, 'objects' );
        // Only show custom taxonomy filters for post types other than 'post'
        if ( 'post' != $post_type ) {
            array_walk( $post_taxonomies, [ $this, 'output_taxonomy_filter' ] );
        }
    }
    
    /**
     * Output filter on the post type's list table for a taxonomy
     *
     * @since 1.0.0
     */
    public function output_taxonomy_filter( $post_taxonomy )
    {
        // Only show taxonomy filter when the taxonomy is hierarchical
        if ( true === $post_taxonomy->hierarchical ) {
            wp_dropdown_categories( array(
                'show_option_all' => sprintf( 'All %s', $post_taxonomy->label ),
                'orderby'         => 'name',
                'order'           => 'ASC',
                'hide_empty'      => false,
                'hide_if_empty'   => true,
                'selected'        => filter_input( INPUT_GET, $post_taxonomy->query_var, FILTER_SANITIZE_STRING ),
                'hierarchical'    => true,
                'name'            => $post_taxonomy->query_var,
                'taxonomy'        => $post_taxonomy->name,
                'value_field'     => 'slug',
            ) );
        }
    }

}