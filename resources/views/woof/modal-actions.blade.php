<div class="hidden fixed top-0 left-0 z-40 h-screen w-full bg-black bg-opacity-75 product__filters__overlay">
  <div class="container flex justify-end py-2">
    <button
      class="relative flex items-center justify-center h-8 w-8 focus:outline-none product__filters__toggle product__filters__toggle--close">
      <span class="sr-only">{{ _e('Close Sidebar', 'sage') }}</span>
      <svg class="w-full text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
        stroke="currentColor" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
      </svg>
    </button>
  </div>
</div>
<button class="btn btn--black btn--sm flex mx-auto md:hidden product__filters__toggle product__filters__toggle--open">
  {{ _e('Filter Results', 'sage') }}
</button>
