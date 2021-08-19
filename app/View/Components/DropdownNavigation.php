<?php

namespace App\View\Components;

use Roots\Acorn\View\Component;

class DropdownNavigation extends Component
{
    /**
     * The navigation type.
     *
     * @var string
     */
    public $type;

    /**
     * The navigation array.
     *
     * @var array
     */
    public $navigation;
    
    /**
     * The dropdown types.
     *
     * @var array
     */
    public $types = [
        'left' => 'left-0',
        'right' => 'right-0',
        'center' => 'transform left-1/2 right-auto -translate-x-1/2',
    ];

    /**
     * Create the component instance.
     *
     * @param  string  $type
     * @param  array  $navigation
     * @return void
     */
    public function __construct($type = 'center', $navigation = [])
    {
        $this->type = $this->types[$type] ?? $this->types['center'];
        $this->navigation = $navigation;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return $this->view('components.dropdown-navigation');
    }
}
