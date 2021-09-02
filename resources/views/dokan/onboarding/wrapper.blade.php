<div class="bg-gray-100 min-h-screen">
  <div class="container">
    <div class="mx-auto w-full max-w-lg py-8 lg:py-16 space-y-4">
      <h1 class="text-center text-2xl font-bold">{{ $title }}</h1>
      <div class="bg-white rounded shadow-md overflow-hidden mx-auto p-4 lg:p-8">
        {!! call_user_func($content) !!}
      </div>
    </div>
  </div>
</div>
