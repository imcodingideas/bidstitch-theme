<div
  class="woof_meta_select_container woof_container woof_container__{{ esc_attr($key) }} woof_container_select__{{ esc_attr($key) }}">
  <div data-css-class="woof_meta_select_container" class="woof_container_inner woof_container_inner_meta_select">
    <h4>{{ $name }}</h4>
    <div class="woof_block_html_items">
      <select
        class="text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black woof_meta_select woof_meta_select__{{ esc_attr($key) }}"
        name="{{ esc_attr($key) }}">
        <option value="0">{{ _e('All', 'sage') }}</option>
        @if ($options)
          @foreach ($options as $option)
            <option value="{{ esc_attr($option->value) }}" {{ selected($option->selected, true) }}>
              {{ esc_html_e($option->label) }}</option>
          @endforeach
        @endif
      </select>
      <input type="hidden" name="{{ esc_attr($key) }}" value="{{ $name }}">
    </div>
  </div>
</div>
