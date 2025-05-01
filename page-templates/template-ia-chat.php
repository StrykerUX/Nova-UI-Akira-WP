<?php
/**
 * Template Name: IA Chat
 * Description: A special template for AI chat interfaces.
 *
 * @package Nova_UI_Akira
 */

get_header();
?>

<!-- Mobile Menu Overlay - Only shows on responsive view -->
<div class="nova-mobile-menu-overlay">
    <div class="nova-mobile-menu">
        <div class="nova-mobile-menu-header">
            <h5><?php esc_html_e('Menu', 'nova-ui-akira'); ?></h5>
            <button class="nova-mobile-menu-close">
                <i class="ti ti-x"></i>
            </button>
        </div>
        <div class="nova-mobile-menu-content">
            <!-- Sidebar Menu in Mobile -->
            <div class="nova-mobile-sidebar-menu">
                <h6><?php esc_html_e('Navigation', 'nova-ui-akira'); ?></h6>
                <ul class="side-nav">
                    <li class="side-nav-item">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="side-nav-link">
                            <span class="menu-icon"><i class="ti ti-dashboard"></i></span>
                            <span class="menu-text"> <?php esc_html_e('Home', 'nova-ui-akira'); ?> </span>
                        </a>
                    </li>
                    <?php
                    // Display WordPress Menu in the sidebar
                    if (has_nav_menu('primary')) {
                        $menu_items = wp_get_nav_menu_items(get_nav_menu_locations()['primary']);
                        $parent_items = array_filter($menu_items, function($item) {
                            return $item->menu_item_parent == 0;
                        });

                        foreach ($parent_items as $parent_item) {
                            $children = array_filter($menu_items, function($item) use ($parent_item) {
                                return $item->menu_item_parent == $parent_item->ID;
                            });

                            // Check if item has a custom icon
                            $icon_attr = '';
                            if (isset($parent_item->icon) && !empty($parent_item->icon)) {
                                $icon_attr = ' data-icon="' . esc_attr($parent_item->icon) . '"';
                            }

                            echo '<li class="side-nav-item"' . $icon_attr . '>';
                            if (empty($children)) {
                                echo '<a href="' . esc_url($parent_item->url) . '" class="side-nav-link">';
                                echo '<span class="menu-icon"><i class="ti ti-file"></i></span>';
                                echo '<span class="menu-text"> ' . esc_html($parent_item->title) . ' </span>';
                                echo '</a>';
                            } else {
                                echo '<a data-bs-toggle="collapse" href="#mobile-sidebar-' . esc_attr($parent_item->ID) . '" aria-expanded="false" aria-controls="mobile-sidebar-' . esc_attr($parent_item->ID) . '" class="side-nav-link">';
                                echo '<span class="menu-icon"><i class="ti ti-folder"></i></span>';
                                echo '<span class="menu-text"> ' . esc_html($parent_item->title) . ' </span>';
                                echo '<span class="menu-arrow"></span>';
                                echo '</a>';
                                echo '<div class="collapse" id="mobile-sidebar-' . esc_attr($parent_item->ID) . '">';
                                echo '<ul class="sub-menu">';
                                
                                foreach ($children as $child) {
                                    echo '<li class="side-nav-item">';
                                    echo '<a href="' . esc_url($child->url) . '" class="side-nav-link">';
                                    echo '<span class="menu-text">' . esc_html($child->title) . '</span>';
                                    echo '</a>';
                                    echo '</li>';
                                }
                                
                                echo '</ul>';
                                echo '</div>';
                            }
                            echo '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>

            <!-- Topbar Icons in Mobile Menu -->
            <div class="nova-mobile-topbar-icons">
                <h6><?php esc_html_e('Quick Actions', 'nova-ui-akira'); ?></h6>
                <div class="d-flex flex-wrap">
                    <?php if (class_exists('Nova_Topbar_Icons')) : ?>
                        <?php 
                        // Modify the output to fit mobile menu
                        add_filter('wp_nav_menu_items', function($items, $args) {
                            if ($args->theme_location === 'topbar_icons') {
                                $items = str_replace('topbar-item d-none d-sm-flex', 'mobile-topbar-item', $items);
                                $items = str_replace('btn-outline-primary btn-icon', 'btn-sm btn-outline-primary me-2 mb-2', $items);
                            }
                            return $items;
                        }, 10, 2);
                        
                        Nova_Topbar_Icons::render_topbar_icons(); 
                        
                        // Remove the filter to avoid affecting other menus
                        remove_filter('wp_nav_menu_items', function(){}, 10);
                        ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="page-content ia-chat-template">
    <div class="page-container ia-chat-container">
        <div class="row">
            <div class="col-12">
                <div class="page-title-head d-flex align-items-sm-center flex-sm-row flex-column">
                    <div class="flex-grow-1">
                        <h4 class="fs-18 text-uppercase fw-bold m-0"><?php echo get_the_title(); ?></h4>
                    </div>
                    <div class="mt-3 mt-sm-0">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="<?php echo esc_url(home_url('/')); ?>"><?php esc_html_e('Home', 'nova-ui-akira'); ?></a></li>
                                <li class="breadcrumb-item active" aria-current="page"><?php the_title(); ?></li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu toggle button - Only visible on small screens -->
        <div class="nova-mobile-menu-toggle d-block d-md-none mb-3">
            <button class="btn btn-primary w-100">
                <i class="ti ti-menu-2 me-1"></i> <?php esc_html_e('Menu', 'nova-ui-akira'); ?>
            </button>
        </div>

        <div class="row ia-chat-content-row">
            <div class="col-12 ia-chat-content-col">
                <?php
                while (have_posts()) :
                    the_post();
                    ?>
                    <div class="card ia-chat-card">
                        <div class="card-body ia-chat-card-body">
                            <?php the_content(); ?>
                        </div>
                    </div>
                <?php
                endwhile;
                ?>
            </div>
        </div>
    </div>
</div>

<?php
get_footer();
