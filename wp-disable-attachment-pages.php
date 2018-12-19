<?php
/*
 *  Plugin Name:  WP Disable Attachment Pages
 *  Plugin URI:   https://github.com/msicknick/wp-disable-attachment-pages/
 *  Description:  Disables direct access to attachment pages
 *  Version:      1.2.0
 *  Author:       Magda Sicknick
 *  Author URI:   https://www.msicknick.com/
 *  License:      GPL2
 *  License URI:  https://www.gnu.org/licenses/gpl-2.0.html
 *  Text Domain:  wp-disable-attachments
 */

/**
 * Exit if accessed directly
 * @since 1.1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Redirects attachment pages to the parent post, or home page if no parent post exists.
 * @since 1.0.0
 */
function wpdap_redirect_attachment_page() {
    global $post;
    if (is_attachment()) {
        if ($post && $post->post_parent) {
            // Redirect to parent post if one exists
            wp_redirect(esc_url(get_permalink($post->post_parent)), 301);
            exit;
        } else {
            // Redirect to home page
            wp_redirect(esc_url(home_url('/')), 301);
            exit;
        }
    }
}
add_action('template_redirect', 'wpdap_redirect_attachment_page', 1);

/**
 * Hide permalinks when editing attachments
 * @since 1.1.0
 */
function wpdap_hide_attachment_permalink() {
    global $post;

    if ($post->post_type == "attachment") {
        ?>
        <style type="text/css">
            #titlediv {
                margin-bottom: 10px;
            }
            #edit-slug-box {
                display: none;
            }
        </style>
        <?php

    }
}
add_action('admin_head', 'wpdap_hide_attachment_permalink');

/**
 * Disable 'Link to' option when inserting media to a post/page
 * @since 1.1.0
 */
function wpdap_disable_linkto() {
    ?>
    <style>
        .attachment-display-settings div.setting {
            display: none;
        }
    </style>
    <?php

}
add_action('admin_head', 'wpdap_disable_linkto');

/**
 * Hide 'View attachment page' link when viewing Attachment Details
 * @since 1.2.0
 */
function wpdap_hide_viewattachment() {
    ?>
    <style>
        .actions .view-attachment {
            display: none !important;
        }
    </style>
    <?php

}
add_action('admin_head', 'wpdap_hide_viewattachment');