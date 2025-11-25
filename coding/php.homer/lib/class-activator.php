<?php
/**
 * Activator
 *
 * @since 1.0.0
 *
 * @package allai\homer
 */

namespace allai\homer;

// Abort if this file is called directly.
if (!defined('WPINC')) {
    die();
}

/**
 * Class Activator.
 *
 * Runs when the plugin is activated.
 */
class Activator
{
    /**
     * Run Code.
     *
     * @since 1.0.0
     */
    public function run()
    {
        register_activation_hook(allai_HOMER_ROOT, [$this, 'activate']);
    }

    /**
     * Activate
     *
     * Runs code on activation.
     *
     * @since 1.0.0
     */
    public function activate()
    {
        // Set a transient to confirm activation.
        set_transient(allai_HOMER_PREFIX . '_activated', true);
    }
}
