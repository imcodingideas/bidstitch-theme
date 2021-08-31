@if (wc_notice_count())
  @foreach (wc_get_notices() as $type => $notices)
    @foreach ($notices as $notice)
      <x-alert type="{{ $type }}">
        {!! $notice['notice'] !!}
      </x-alert>
    @endforeach
  @endforeach
@endif
