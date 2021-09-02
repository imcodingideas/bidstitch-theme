<form method="post" class="pace-y-4 lg:space-y-6">
  @foreach ($methods as $method)
    <div class="grid space-y-2">
      <h3 class="font-bold">{{ $method['title'] }}</h3>
      {!! call_user_func($method['callback'], $store_info) !!}
    </div>
  @endforeach
  <div class="flex space-x-4 items-center">
    <input type="submit" class="btn btn--black btn--md cursor-pointer" value="{{ esc_attr_e('Next Step', 'sage') }}"
      name="save_step" />
    {!! wp_nonce_field('dokan-seller-setup') !!}
  </div>
</form>
