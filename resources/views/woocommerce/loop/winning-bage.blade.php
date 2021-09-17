@if ($badge)
    <div data-auction_id="{{ esc_attr($badge->product_id) }}" data-user_id="{{ esc_attr($badge->user_id) }}" class="absolute top-3 left-3 inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium bg-green-100 text-green-800">{{ _e('Winning', 'sage') }}</div>
@endif