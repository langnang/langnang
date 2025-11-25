<?php
/**
 * Plugin action and row meta links
 */

namespace allai\homer;

if (!defined('ABSPATH')) {
    exit(); // Exit if accessed directly
}

class ActionMetaLinks
{
    public function run()
    {
        add_filter('plugin_action_links_' . allai_HOMER__FILE, [$this, 'homer_action_links']);
        add_filter('plugin_row_meta', [$this, 'homer_meta_links'], 10, 2);
    }

    /**
     * Add plugin_action_links
     */
    public function homer_action_links($links)
    {
        return array_merge(
            [
                '<a href="' .
                admin_url('options-general.php?page=homer') .
                '" title="' .
                __('Features Manager', 'homer') .
                '">' .
                __('Settings', 'homer') .
                '</a>',
            ],
            $links
        );

        return $links;
    }

    /**
     * Add plugin_row_meta links
     */
    public function homer_meta_links($links, $file)
    {
        if ($file == allai_HOMER__FILE) {
            return array_merge($links, [
                '<a target="_blank" href="https://allai.club/contact/">' . __('Contact Us', 'homer') . '</a>',
            ]);
        }

        return $links;
    }
}
