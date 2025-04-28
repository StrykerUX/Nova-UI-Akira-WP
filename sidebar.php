<?php
/**
 * The sidebar containing the main widget area
 *
 * @package Nova_UI_Akira
 */

if (!is_active_sidebar('sidebar-1')) {
    return;
}
?>

<div class="col-auto info-sidebar">
    <?php dynamic_sidebar('sidebar-1'); ?>
</div>