<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class WoofActions extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['woof.actions'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {

        return [
            'reset_button' => $this->reset_button(),
            'filter_button' => $this->filter_button()
        ];
    }

    public function reset_button() {
        global $WOOF;

        $show_button = $WOOF->is_isset_in_request_data($WOOF->get_swoof_search_slug()) 
            || $WOOF->is_isset_in_request_data('min_price') 
            || (class_exists('WOOF_EXT_TURBO_MODE') 
                && isset($WOOF->settings['woof_turbo_mode']['enable']) 
                && $WOOF->settings['woof_turbo_mode']['enable']);
        
        if (!$show_button) return false;

        $label = get_option('woof_reset_btn_txt', '');

        if (empty($label)) {
            $label = 'Reset';
        }

        if ($label === 'none') return false;

        global $woof_link;

        return (object) [
            'label' => $label,
            'link' => $woof_link
        ];
    }

    public function filter_button() {
        $autosubmit = isset($this->data['autosubmit']) ? $this->data['autosubmit'] : '';
        $ajax_redraw = isset($this->data['ajax_redraw']) ? $this->data['ajax_redraw'] : '';

        if (empty($autosubmit) || !empty($ajax_redraw)) {
            $label = get_option('woof_filter_btn_txt', '');

            if (empty($label)) {
                $label = 'Filter';
            }

            return (object) [
                'label' => $label,
            ];
        }

        return false;
    }
}