<?php
/**
 * The header for our theme
 *
 * @package Nova_UI_Akira
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- Begin page -->
<div class="wrapper">

    <!-- Sidebar Menu Start -->
    <div class="sidenav-menu">

        <!-- Brand Logo -->
        <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
            <?php 
            // Use our advanced logo system
            if (function_exists('nova_get_advanced_logo')) {
                echo nova_get_advanced_logo();
            } else {
                // Fallback to standard WordPress logo
                if (has_custom_logo()) {
                    the_custom_logo();
                } else {
                    echo '<span class="logo-light"><span class="logo-lg">' . get_bloginfo('name') . '</span></span>';
                    echo '<span class="logo-sm text-center">' . esc_html(substr(get_bloginfo('name'), 0, 1)) . '</span>';
                }
            }
            ?>
        </a>

        <!-- Sidebar Hover Menu Toggle Button -->
        <button class="button-sm-hover">
            <i class="ti ti-circle align-middle"></i>
        </button>

        <!-- Full Sidebar Menu Close Button -->
        <button class="button-close-fullsidebar">
            <i class="ti ti-x align-middle"></i>
        </button>

        <div data-simplebar>

            <!--- Sidenav Menu -->
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
                            echo '<a data-bs-toggle="collapse" href="#sidebar-' . esc_attr($parent_item->ID) . '" aria-expanded="false" aria-controls="sidebar-' . esc_attr($parent_item->ID) . '" class="side-nav-link">';
                            echo '<span class="menu-icon"><i class="ti ti-folder"></i></span>';
                            echo '<span class="menu-text"> ' . esc_html($parent_item->title) . ' </span>';
                            echo '<span class="menu-arrow"></span>';
                            echo '</a>';
                            echo '<div class="collapse" id="sidebar-' . esc_attr($parent_item->ID) . '">';
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

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Sidenav Menu End -->

    <!-- Topbar Start -->
    <header class="app-topbar">
        <div class="page-container topbar-menu">
            <div class="d-flex align-items-center gap-2">

                <?php if (get_theme_mod('nova_show_logo_topbar', true)) : ?>
                <!-- Brand Logo in Topbar -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="logo">
                    <?php 
                    // Use our advanced logo system
                    if (function_exists('nova_get_advanced_logo')) {
                        echo nova_get_advanced_logo();
                    } else {
                        // Fallback to standard WordPress logo
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            echo '<span class="logo-light"><span class="logo-lg">' . get_bloginfo('name') . '</span></span>';
                            echo '<span class="logo-sm text-center">' . esc_html(substr(get_bloginfo('name'), 0, 1)) . '</span>';
                        }
                    }
                    ?>
                </a>
                <?php endif; ?>

                <!-- Sidebar Menu Toggle Button -->
                <button class="sidenav-toggle-button btn btn-secondary btn-icon">
                    <i class="ti ti-menu-deep fs-24"></i>
                </button>

                <!-- Button Trigger Search Modal -->
                <div class="topbar-search text-muted d-none d-xl-flex gap-2 align-items-center" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                    <i class="ti ti-search fs-18"></i>
                    <span class="me-2"><?php esc_html_e('Search something..', 'nova-ui-akira'); ?></span>
                </div>

                <?php if (has_nav_menu('topbar')) : ?>
                <!-- Mega Menu Dropdown -->
                <div class="topbar-item d-none d-md-flex">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'topbar',
                        'container'      => 'div',
                        'container_class'=> 'dropdown',
                        'menu_class'     => 'dropdown-menu dropdown-menu-xxl p-0',
                        'items_wrap'     => '<a href="#" class="topbar-link btn btn-link px-2 dropdown-toggle drop-arrow-none fw-medium" data-bs-toggle="dropdown" data-bs-trigger="hover" data-bs-offset="0,24" aria-haspopup="false" aria-expanded="false">' . esc_html__('Menu', 'nova-ui-akira') . ' <i class="ti ti-chevron-down ms-1"></i></a><div class="dropdown-menu dropdown-menu-xxl p-0"><div class="row g-0">%3$s</div></div>',
                        'depth'          => 2,
                        'walker'         => new Nova_Topbar_Walker(),
                    ));
                    ?>
                </div>
                <?php endif; ?>
            </div>

            <div class="d-flex align-items-center gap-2">
                <!-- Search for small devices -->
                <div class="topbar-item d-flex d-xl-none">
                    <button class="topbar-link btn btn-outline-primary btn-icon" data-bs-toggle="modal" data-bs-target="#searchModal" type="button">
                        <i class="ti ti-search fs-22"></i>
                    </button>
                </div>

                <!-- Topbar Icons Menu -->
                <?php if (class_exists('Nova_Topbar_Icons')) : ?>
                    <?php Nova_Topbar_Icons::render_topbar_icons(); ?>
                <?php endif; ?>
                
                <!-- Light/Dark Mode Button -->
                <div class="topbar-item d-none d-sm-flex">
                    <button class="topbar-link btn btn-outline-primary btn-icon" id="light-dark-mode" type="button">
                        <i class="ti ti-moon fs-22"></i>
                    </button>
                </div>

                <?php if (is_user_logged_in()) : ?>
                <!-- User Dropdown -->
                <div class="topbar-item">
                    <div class="dropdown">
                        <a class="topbar-link btn btn-outline-primary dropdown-toggle drop-arrow-none" data-bs-toggle="dropdown" data-bs-offset="0,22" type="button" aria-haspopup="false" aria-expanded="false">
                            <?php echo get_avatar(get_current_user_id(), 24, '', '', array('class' => 'rounded-circle me-lg-2 d-flex')); ?>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <?php echo esc_html(wp_get_current_user()->display_name); ?>
                            </span>
                            <i class="ti ti-chevron-down d-none d-lg-block align-middle ms-2"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <?php 
                            if (class_exists('Nova_User_Menu')) {
                                Nova_User_Menu::render_user_menu();
                            } else {
                                // Fallback for user menu
                                ?>
                                <a class="dropdown-item" href="<?php echo esc_url(admin_url('profile.php')); ?>">
                                    <i class="ti ti-user me-1"></i> <?php esc_html_e('Profile', 'nova-ui-akira'); ?>
                                </a>
                                <a class="dropdown-item" href="<?php echo esc_url(wp_logout_url(home_url())); ?>">
                                    <i class="ti ti-logout me-1"></i> <?php esc_html_e('Logout', 'nova-ui-akira'); ?>
                                </a>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php else : ?>
                <!-- Login Button -->
                <div class="topbar-item">
                    <a href="<?php echo esc_url(wp_login_url(home_url())); ?>" class="btn btn-primary">
                        <i class="ti ti-login me-1"></i> <?php esc_html_e('Login', 'nova-ui-akira'); ?>
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </header>
    <!-- Topbar End -->

    <!-- Search Modal -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content bg-transparent">
                <div class="card mb-0 shadow-none">
                    <div class="px-3 py-2 d-flex flex-row align-items-center" id="top-search">
                        <i class="ti ti-search fs-22"></i>
                        <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                            <input type="search" class="form-control border-0" id="search-modal-input" name="s" placeholder="<?php esc_attr_e('Search &hellip;', 'nova-ui-akira'); ?>" value="<?php echo get_search_query(); ?>">
                        </form>
                        <button type="button" class="btn p-0" data-bs-dismiss="modal" aria-label="Close">[esc]</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->