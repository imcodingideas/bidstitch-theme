<div {{ $attributes->merge(['class' => "rounded $type"]) }}>
  <div class="px-4 py-3">
    {!! $message ?? $slot !!}
  </div>
</div>
