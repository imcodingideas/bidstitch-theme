<input {{ $attributes->merge(['class' => 'cursor-pointer h-4 w-4 text-black border-gray-300 focus:ring-gray-500']) }}
  {{ $attributes }} type="radio" {{ $defaultValue ? "value='$defaultValue'" : '' }}
  {{ $isChecked ? 'checked' : '' }} />
