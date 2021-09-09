<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class FormRadio extends Component
{
    /**
     * The default field value
     *
     * @var string
     */
    public $defaultValue;

    /**
     * The default checked status
     *
     * @var string
     */
    public $isChecked;

    /**
     * Create the component instance.
     *
     * @param string $defaultValue
     * @param string $isChecked
     * @return void
     */
    
    public function __construct($defaultValue = '', $isChecked = '')
    {
        $postdata = wc_clean($_POST);

        $this->defaultValue = ($defaultValue && isset($postdata[$defaultValue]) && !empty($postdata[$defaultValue])) ? esc_attr(wp_unslash($postdata[$defaultValue])) : '';
        $this->isChecked = $isChecked === 'checked';
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */

    public function render()
    {
        return $this->view('components.form-radio');
    }
}
