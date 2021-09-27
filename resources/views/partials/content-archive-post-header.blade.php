<header class="grid gap-y-1 md:gap-y-2">
  @if ($category)
    <div class="flex">
      <span
        class="inline-flex items-center px-3 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-800 md:text-sm">
        {{ $category }}
      </span>
    </div>
  @endif
  <h2 class="text-sm md:text-lg font-bold">{!! $title !!}</h2>
</header>
