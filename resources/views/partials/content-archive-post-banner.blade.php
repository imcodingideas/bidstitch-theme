<div class="aspect-w-16 aspect-h-9 h-full">
  @if ($thumbnail)
    {!! $thumbnail !!}
  @else
    <div class="bg-gray-100 flex items-center justify-center p-4" aria-hidden="true">
      <div class="header-logo text-xl lg:text-3xl">{{ _e('BidStitch', 'sage') }}</div>
    </div>
  @endif
</div>
