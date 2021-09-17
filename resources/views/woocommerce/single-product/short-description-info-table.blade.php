<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 mt-4">
  @if ($terms_size)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Size', 'sage') }}</span>
      <span class="text-sm">{{ $terms_size[0]->name }}</span>
    </div>
  @endif

  @if ($terms_color)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Color', 'sage') }}</span>
      <span class="text-sm">{{ $terms_color[0]->name }}</span>
    </div>
  @endif

  @if ($terms_condition)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Condition', 'sage') }}</span>
      <span class="text-sm">{{ $terms_condition[0]->name }}</span>
    </div>
  @endif

  @if ($tees_tip)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Pit to Pit', 'sage') }}</span>
      <span class="text-sm">{{ $tees_tip }}</span>
    </div>
  @endif

  @if ($tees_length)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Length', 'sage') }}</span>
      <span class="text-sm">{{ $tees_length }}</span>
    </div>
  @endif

  @if ($tees_tag_type)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Tag Type', 'sage') }}</span>
      <span class="text-sm">{{ $tees_tag_type }}</span>
    </div>
  @endif

  @if ($tees_stitching)
    <div class="text-center bg-gray-100 grid align-start gap-y-1 p-3">
      <span class="font-bold text-sm">{{ _e('Stitching', 'sage') }}</span>
      <span class="text-sm">{{ $tees_stitching }}</span>
    </div>
  @endif
</div>
