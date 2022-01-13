<?php

namespace App\View\Composers;

use Roots\Acorn\View\Composer;

class DokanDashboardBigCounterWidget extends Composer
{
    /**
     * List of views served by this composer.
     *
     * @var array
     */
    protected static $views = ['dokan.dashboard.big-counter-widget'];

    /**
     * Data to be passed to view before rendering.
     *
     * @return array
     */
    public function with()
    {
        return [
            'total' => $this->get_total(),
        ];
    }

    protected function get_total()
    {
        $total = 0;
        $status = dokan_withdraw_get_active_order_status();

        foreach ($status as $order_status) {
            if (! isset($orders_count->$order_status)) {
                continue;
            }

            $total += $orders_count->$order_status;
        }

        return $total;
    }
}
