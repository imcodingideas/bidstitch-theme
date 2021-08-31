<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class FormInput extends Component
{
    /**
     * The default field value
     *
     * @var boolean
     */
    public $defaultValue;

    /**
     * Create the component instance.
     *
     * @param  boolean  $required
     * @return void
     */
    public function __construct($defaultValue = '')
    {
        $postdata = wc_clean($_POST);

        $this->defaultValue = ($defaultValue && !empty($postdata[$defaultValue])) ? esc_attr(wp_unslash($postdata[$defaultValue])) : '';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.form-input');
    }
}
