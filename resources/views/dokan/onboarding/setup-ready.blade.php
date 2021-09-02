<div class="space-y-4 grid justify-center">
  <span class="mx-auto w-12 h-12 flex items-center justify-center rounded-full border-2 bg-black border-black">
    <svg class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
      aria-hidden="true">
      <path fill-rule="evenodd"
        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
        clip-rule="evenodd"></path>
    </svg>
  </span>
  <h1 class="text-center text-2xl font-bold">{{ _e('Your Store is Ready!', 'sage') }}</h1>
  <a class="btn btn--black btn--md"
    href="{{ esc_url($dashboard_link) }}">{{ _e('Go to your Store Dashboard!', 'sage') }}</a>
</div>
