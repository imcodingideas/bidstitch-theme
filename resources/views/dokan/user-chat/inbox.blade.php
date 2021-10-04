<div class="w-full grid space-y-8">
  <h1 class="text-2xl font-extrabold tracking-tight text-gray-900 sm:text-3xl">
    {{ _e('Messages', 'sage') }}
  </h1>
  <div class="aspect-w-4 aspect-h-3 w-full">
    <div class="message__inbox__wrapper">
      <div class="animate-pulse h-full w-full grid grid-cols-12 gap-x-4 message__inbox__loading">
        <div class="col-span-5 rounded-sm bg-gray-200 hidden md:block"></div>
        <div class="col-span-12 rounded-sm bg-gray-200 md:col-span-7"></div>
      </div>
    </div>
  </div>
</div>
