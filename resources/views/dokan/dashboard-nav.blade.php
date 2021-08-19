<div class=" dokan-dash-sidebar-left">
  <h4 class="main-title-my-profile uppercase">{{ _e('My Profile', 'sage') }}</h4>
  <ul class="list-title-a list-profile-account-dokan ">
    @if (count($account_menu))
      @foreach ($account_menu as $item)
        <li class="{{ $item['class'] }}">
          <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
      @endforeach
    @endif
  </ul>
  <h4 class="main-title-my-shop">{{ $title_my_shop }}</h4>
  @if (count($settings_menu))
    <ul class="list-title-a list-profile-account list-dokan-dashboard">
      @foreach ($settings_menu as $item)
        <li class="{{ $item['class'] }}">
          <a href="{{ $item['url'] }}">{!! $item['icon'] !!}{{ $item['label'] }}</a>
        </li>
      @endforeach
    </ul>
  @else
    <ul class="list-title-a list-profile-account list-dokan-dashboard dokan-dashboard-menu">
      @foreach ($default_menu as $item)
        <li class="title {{ $item['class'] }}">
          <a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
        </li>
      @endforeach
    </ul>
  @endif
</div>
