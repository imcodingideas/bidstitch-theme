<input
  {{ $attributes->merge(['class' => 'cursor-pointer h-4 w-4 text-black focus:ring-black border-gray-300 rounded-sm']) }}
  {{ $attributes }} type="checkbox" 
  @if (isset($defaultValue) && $defaultValue)
    value="{{ esc_attr_e($defaultValue) }}"
  @endif
  @if (isset($isChecked) && $isChecked)
    checked="checked"
  @endif
/>
