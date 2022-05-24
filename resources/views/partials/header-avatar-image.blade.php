@if (function_exists('get_avatar') && is_user_logged_in())
  {!! get_avatar(get_current_user_id()) !!}
@else
  <svg width="41" height="41" viewBox="0 0 41 41" fill="none" xmlns="http://www.w3.org/2000/svg">
    <ellipse cx="20.5" cy="17.0833" rx="5.125" ry="5.125" fill="black"/>
    <circle cx="20.5" cy="20.5" r="15.375" stroke="black" stroke-width="2"/>
    <path d="M30.5311 32.1308C30.6626 32.0257 30.7157 31.8494 30.6564 31.6919C30.0143 29.9843 28.7228 28.479 26.9599 27.3901C25.1067 26.2454 22.836 25.625 20.5 25.625C18.164 25.625 15.8933 26.2454 14.0401 27.3901C12.2772 28.479 10.9857 29.9843 10.3436 31.6919C10.2843 31.8494 10.3374 32.0257 10.4689 32.1308C16.335 36.8179 24.665 36.8179 30.5311 32.1308Z" fill="black" stroke="black" stroke-width="1.2" stroke-linecap="round"/>
  </svg>
@endif
