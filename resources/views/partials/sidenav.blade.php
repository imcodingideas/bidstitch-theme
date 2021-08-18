<div class="flex lg:hidden">
  <button
    class="bg-white inline-flex items-center justify-center text-black focus:outline-none sidenav__toggle sidenav__toggle--open">
    <span class="sr-only">Open menu</span>
    <svg class="h-8 w-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
    </svg>
  </button>
  <div class="fixed inset-0 z-40 hidden sidenav pr-20">
    <div class="fixed inset-0 bg-black bg-opacity-75 sidenav__toggle"></div>
    <div class="relative flex max-w-xs w-full bg-white">
      <div class="container fixed top-4 left-0 right-0 flex justify-end">
        <button class="flex items-center justify-center h-8 w-8 focus:outline-none sidenav__toggle">
          <span class="sr-only">Close sidebar</span>
          <svg class="w-full text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
      <div class="h-screen relative overflow-y-auto w-full">
        <nav>
          <ul>
            @if (has_nav_menu('myaccount_navigation') && is_user_logged_in())
              @include('partials.sidenav-myaccount-navigation')
            @endif
            @if (has_nav_menu('primary_navigation'))
              @include('partials.sidenav-primary-navigation')
            @endif
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
