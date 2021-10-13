@if ($endpoints)
  <div id="posttype-dokan-endpoints" class="posttypediv">
    <div id="tabs-panel-dokan-endpoints" class="tabs-panel tabs-panel-active">
      <ul id="dokan-endpoints-checklist" class="categorychecklist form-no-clear">
        @php $i = -1; @endphp

        @foreach ($endpoints as $key => $value)
          <li>
            <label class="menu-item-title">
              <input type="checkbox" class="menu-item-checkbox" name="menu-item[{{ esc_attr($i) }}][menu-item-object-id]" value="{{ esc_attr($i) }}" />
              {{ esc_html($value['title']) }}
            </label>
            <input type="hidden" class="menu-item-type" name="menu-item[{{ esc_attr($i) }}][menu-item-type]" value="custom">
            <input type="hidden" class="menu-item-title" name="menu-item[{{ esc_attr($i) }}][menu-item-title]" value="{{ esc_attr($value['title']) }}" />
            <input type="hidden" class="menu-item-classes" name="menu-item[{{ esc_attr($i) }}][menu-item-classes]"/>
            @if ($store_url)
              <input type="hidden" class="menu-item-url" name="menu-item[{{ esc_attr($i) }}][menu-item-url]" value="{{ esc_url($key == 'view-store' ? $store_url :  $value['url']) }}" />
            @else
              <input type="hidden" class="menu-item-url" name="menu-item[{{ esc_attr($i) }}][menu-item-url]" value="{{ esc_url($value['url']) }}" />
            @endif
          </li>

          @php $i--; @endphp
        @endforeach
      </ul>
    </div>
    <p class="button-controls">
      <span class="list-controls">
        <a href="{{ esc_url(admin_url('nav-menus.php?page-tab=all&selectall=1#posttype-dokan-endpoints')) }}" class="select-all">{{ esc_html_e('Select all', 'sage') }}</a>
      </span>
      <span class="add-to-menu">
        <button type="submit" class="button-secondary submit-add-to-menu right" value="{{ esc_attr_e('Add to menu', 'sage') }}" name="add-post-type-menu-item" id="submit-posttype-dokan-endpoints">{{ esc_html_e('Add to menu', 'sage') }}</button>
        <span class="spinner"></span>
      </span>
    </p>
  </div>
@endif
