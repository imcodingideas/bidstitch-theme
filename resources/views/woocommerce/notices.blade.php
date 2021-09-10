@if ($notice_types)
  @foreach ($notice_types as $type => $notices)
    @foreach ($notices as $notice)
      <x-alert type="{{ $type }}">
        {!! $notice['notice'] !!}
      </x-alert>
    @endforeach
  @endforeach
@endif
