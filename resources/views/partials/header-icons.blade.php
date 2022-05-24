<ul class="flex space-x-2 h-full justify-center items-center">

  @if ($inbox)
    <li class="relative lg:flex">
      <a href="{{ $inbox }}" title="inbox">
        <svg width="24" height="14" viewBox="0 0 18 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M0.0132028 4.15129C-3.38676e-10 4.69022 0 5.30205 0 6V8C0 10.8284 0 12.2426 0.87868 13.1213C1.75736 14 3.17157 14 6 14H12C14.8284 14 16.2426 14 17.1213 13.1213C18 12.2426 18 10.8284 18 8V6C18 5.30205 18 4.69022 17.9868 4.15129L9.97129 8.60436C9.36724 8.93994 8.63276 8.93994 8.02871 8.60436L0.0132028 4.15129ZM0.242967 2.02971C0.325845 2.05052 0.407399 2.08237 0.485643 2.12584L9 6.85604L17.5144 2.12584C17.5926 2.08237 17.6742 2.05052 17.757 2.02971C17.6271 1.55619 17.4276 1.18491 17.1213 0.87868C16.2426 0 14.8284 0 12 0H6C3.17157 0 1.75736 0 0.87868 0.87868C0.572448 1.18491 0.372942 1.55619 0.242967 2.02971Z" fill="black"/>
        </svg>
        <span id="header-inbox-count-wrapper" class="hidden -translate-y-2 absolute  right-0 top-0 transform translate-x-2">
          <span id="header-inbox-count" class="bg-yellow-400 rounded-full text-xs w-4 flex h-4 items-center justify-center leading-none"></span>
        </span>
      </a>
    </li>
  @endif

  @if ($favorites)
    <li class="hidden lg:flex">
      <a href="{{ $favorites }}" title="favorites">       
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M4.45067 13.9082L11.4033 20.4395C11.6428 20.6644 11.7625 20.7769 11.9037 20.8046C11.9673 20.8171 12.0327 20.8171 12.0963 20.8046C12.2375 20.7769 12.3572 20.6644 12.5967 20.4395L19.5493 13.9082C21.5055 12.0706 21.743 9.0466 20.0978 6.92607L19.7885 6.52734C17.8203 3.99058 13.8696 4.41601 12.4867 7.31365C12.2913 7.72296 11.7087 7.72296 11.5133 7.31365C10.1304 4.41601 6.17972 3.99058 4.21154 6.52735L3.90219 6.92607C2.25695 9.0466 2.4945 12.0706 4.45067 13.9082Z" fill="black" stroke="black" stroke-width="2"/>
        </svg>
      </a>
    </li>
  @endif

  @if ($notifications)
    <li id="header-notifications-icon" class="relative">
      <a href="{{ $notifications }}" title="notifications" class="relative block">  
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd" d="M13.7942 3.29494C13.2296 3.10345 12.6258 3 12 3C9.15347 3 6.76217 5.14032 6.44782 7.96942L6.19602 10.2356L6.18957 10.2933C6.06062 11.417 5.69486 12.5005 5.11643 13.4725L5.08664 13.5222L4.5086 14.4856C3.98405 15.3599 3.72177 15.797 3.77839 16.1559C3.81607 16.3946 3.93896 16.6117 4.12432 16.7668C4.40289 17 4.91267 17 5.93221 17H18.0678C19.0873 17 19.5971 17 19.8756 16.7668C20.061 16.6117 20.1839 16.3946 20.2216 16.1559C20.2782 15.797 20.0159 15.3599 19.4914 14.4856L18.9133 13.5222L18.8835 13.4725C18.4273 12.7059 18.1034 11.8698 17.9236 10.9994C15.1974 10.9586 13 8.73592 13 6C13 5.00331 13.2916 4.07473 13.7942 3.29494ZM16.2741 4.98883C16.0999 5.28551 16 5.63109 16 6C16 6.94979 16.662 7.74494 17.5498 7.94914C17.4204 6.82135 16.9608 5.80382 16.2741 4.98883Z" fill="black"/>
        <path d="M9 17C9 17.394 9.0776 17.7841 9.22836 18.1481C9.37913 18.512 9.6001 18.8427 9.87868 19.1213C10.1573 19.3999 10.488 19.6209 10.8519 19.7716C11.2159 19.9224 11.606 20 12 20C12.394 20 12.7841 19.9224 13.1481 19.7716C13.512 19.6209 13.8427 19.3999 14.1213 19.1213C14.3999 18.8427 14.6209 18.512 14.7716 18.1481C14.9224 17.7841 15 17.394 15 17L12 17H9Z" fill="black"/>
        <circle cx="18" cy="6" r="2.5" fill="black" stroke="black"/>
      </svg>
        <span id="header-notifications-count-wrapper" class="-translate-y-2 absolute  right-0 top-0 transform translate-x-2 hidden">
          <span id="header-notifications-count" class="bg-yellow-400 rounded-full text-xs w-4 flex h-4 items-center justify-center leading-none"></span>
        </span>
      </a>
      {{-- rendered with ajax, see resources/scripts/header-notifications.js --}}
      <div id="header-notifications" class="absolute hidden top-6 right-0 w-72 z-10 bg-white p-4 shadow-lg rounded overflow-y-auto">
        {{-- @include('partials.header-notifications') --}}
      </div>
    </li>
  @endif

  @include('partials.cart-icon')

</ul>
