@if ($archive_title)
  <div class="grid gap-y-2 border-b border-t py-4 md:border-t-0 md:pt-0">
    <h1 class="text-xl md:text-3xl font-bold uppercase">{{ $archive_title }}</h1>

    @if ($archive_description)
      <p class="text-sm">{{ $archive_description }}</p>
    @endif
  </div>
@endif
