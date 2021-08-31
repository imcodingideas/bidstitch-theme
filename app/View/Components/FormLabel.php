<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class FormLabel extends Component
{
    /**
     * The required status
     *
     * @var boolean
     */
    public $required;

    /**
     * Create the component instance.
     *
     * @param  boolean  $required
     * @return void
     */
    public function __construct($required = false)
    {
        $this->required = $required;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.form-label');
    }
}
