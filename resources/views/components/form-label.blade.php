<label {{ $attributes->merge(['class' => 'text-sm font-medium text-gray-700']) }} {{ $attributes }}>
  {{ $slot }}
  @if ($required)
    <sup>*</sup>
  @endif
</label>
