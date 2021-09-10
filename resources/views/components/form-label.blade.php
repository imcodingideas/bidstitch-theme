<label {{ $attributes->merge(['class' => 'text-sm font-medium text-gray-700']) }} {{ $attributes }}>
  {{ $slot }}
  @if (isset($required) && $required)
    <sup>*</sup>
  @endif
</label>
