<input
  {{ $attributes->merge(['class' => 'cursor-pointer h-4 w-4 text-black focus:ring-black border-gray-300 rounded-sm']) }}
  {{ $attributes }} type="checkbox" {{ $defaultValue ? "value='$defaultValue'" : '' }}
  {{ $isChecked ? 'checked' : '' }} />
