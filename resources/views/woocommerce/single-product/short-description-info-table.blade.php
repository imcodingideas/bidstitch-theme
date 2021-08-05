<div class="info-wrapper mt-6">
  <table class="info-table font-semibold text-center tracking-wider uppercase w-full">
    <tr class="info-taxonomy-title bg-black text-white">

      @if ($terms_size)
        <th class="p-1 border border-white text-center">{{ _e('Size', 'sage') }}</th>
      @endif

      @if ($terms_color)
        <th class="p-1 border border-white text-center">{{ _e('Color', 'sage') }}</th>
      @endif

      @if ($terms_condition)
        <th class="p-1 border border-white text-center">{{ _e('Condition', 'sage') }}</th>
      @endif

    </tr>
    <tr class="info-taxonomy-value">

      @if ($terms_size)
        <th class="p-1 border border-black text-center">{{ $terms_size[0]->name }}</th>
      @endif

      @if ($terms_color)
        <th class="p-1 border border-black text-center">{{ $terms_color[0]->name }}</th>
      @endif

      @if ($terms_condition)
        <th class="p-1 border border-black text-center">{{ $terms_condition[0]->name }}</th>
      @endif

    </tr>
  </table>

  <table class="info-table font-semibold text-center tracking-wider uppercase w-full mt-6">
    <tr class="info-taxonomy-title bg-black text-white">
      @if ($tees_tip)
        <th class="p-1 border border-white text-center">Pit to pit</th>
      @endif
      @if ($tees_length)
        <th class="p-1 border border-white text-center">Length</th>
      @endif
      @if ($tees_tag_type)
        <th class="p-1 border border-white text-center">Tag type</th>
      @endif
      @if ($tees_stitchig)
        <th class="p-1 border border-white text-center">Stitching</th>
      @endif
    </tr>
    <tr class="info-taxonomy-value">
      @if ($tees_tip)
        <th class="p-1 border border-black text-center">
          {{ $tees_tip }}
        </th>
      @endif
      @if ($tees_length)
        <th class="p-1 border border-black text-center">
          {{ $tees_length }}
        </th>
      @endif

      @if ($tees_tag_type)
        <th class="p-1 border border-black text-center">
          {{ $tees_tag_type }}
        </th>
      @endif
      @if ($tees_stitchig)
        <th class="p-1 border border-black text-center">
          {{ $tees_stitchig }}
        </th>
      @endif
    </tr>
  </table>
</div>
