<input {{ $attributes->merge(['class' => 'cursor-pointer h-4 w-4 text-black border-gray-300 focus:ring-gray-500']) }}
  {{ $attributes }} 
  type="radio"
  @if (isset($defaultValue) && $defaultValue)
      value="{{ esc_attr_e($defaultValue) }}"
  @endif
  @if (isset($isChecked) && $isChecked)
    checked="checked"
  @endif  
/>
