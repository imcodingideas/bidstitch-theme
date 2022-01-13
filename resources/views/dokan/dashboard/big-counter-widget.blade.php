@php
/**
 *  Dashboard Widget Template
 *
 *  Dashboard Big Counter widget template
 *
 *  @since 2.4
 *
 *  @author weDevs <info@wedevs.com>
 *
 *  @package dokan
 */
@endphp
<div class="dashboard-widget big-counter">
    <ul class="list-inline">
         <li>
            <div class="title">{{ esc_html( 'Sales', 'dokan-lite' ) }}</div>
            <div class="count">{!! wp_kses_post( wc_price( $earning ) ) !!}</div>
        </li>
        <li>
            <div class="title">{{ esc_html( 'Earning', 'dokan-lite' ) }}</div>
            <div class="count">{!! wp_kses_post( dokan_get_seller_earnings( dokan_get_current_user_id() ) ) !!}</div>
        </li>
        <li>
            <div class="title">{{ esc_html( 'Order', 'dokan-lite' ) }}</div>
            <div class="count">{{ esc_html( number_format_i18n( $total, 0 ) ) }}</div>
        </li>

        @php do_action( 'dokan_seller_dashboard_widget_counter' ) @endphp
    </ul>
</div> <!-- .big-counter -->
