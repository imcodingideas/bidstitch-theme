<input
  {{ $attributes->merge(['class' => 'text-sm appearance-none w-full px-3 py-2 border border-gray-300 rounded-sm placeholder-gray-400 focus:outline-none focus:ring-black focus:border-black']) }}
  {{ $attributes }} 
  @if (isset($defaultValue) && $defaultValue)
    value="{{ esc_attr_e($defaultValue) }}"
  @endif
/>
