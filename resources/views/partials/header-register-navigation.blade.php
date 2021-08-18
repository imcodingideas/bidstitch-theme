<nav class="h-full">
  <ul class="flex h-full">
    <li class="h-full">
      <a href="{{ esc_url(wp_login_url(home_url())) }}"
        class="h-full border-l flex items-center text-sm font-bold relative uppercase px-3 lg:px-4 transition-colors hover:bg-gray-100">Login</a>
    </li>
    <li class="h-full">
      <a href="{{ esc_url(wp_registration_url(home_url())) }}"
        class="h-full border-l border-r flex items-center text-sm font-bold relative uppercase px-3 lg:px-4 transition-colors hover:bg-gray-100">Sign
        Up</a>
    </li>
  </ul>
</nav>
