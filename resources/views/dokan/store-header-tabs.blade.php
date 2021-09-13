<div class="row max-w-screen-xl mx-auto dokan-store-tabs{{ $no_banner_class_tabs }}">
  <div class="dokan-list-wapper">
    <ul class="dokan-list-inline">
      <li><a href="{{ $dokan_get_store_url }}"
          class="{{ $dokan_get_store_url_class }}">{{ _e('Shop listings', 'dokan-lite') }}</a></li>
      {{-- <li><a href="{{  $dokan_get_review_url }}" class="{{ $dokan_get_review_url_class }}">{{  _e('Reviews ', 'dokan-lite') }} ({{  count($all_comments) }}) </a></li> --}}
      @php do_action( 'dokan_after_store_tabs', $store_user_id ) @endphp
    </ul>
  </div>
</div>
