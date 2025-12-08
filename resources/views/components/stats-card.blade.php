<div class="bg-white rounded-xl shadow-md card-border p-4">
  <div class="flex items-center justify-between">
    <div>
      <div class="text-xs text-gray-500">{{ $title ?? 'Title' }}</div>
      <div class="text-2xl font-semibold mt-1">{{ $value ?? '0' }}</div>
      @if(!empty($subtitle))
        <div class="text-xs text-gray-400 mt-1">{{ $subtitle }}</div>
      @endif
    </div>
    <div class="p-3 rounded bg-[color:var(--clr-6)]">
      {!! $icon ?? '' !!}
    </div>
  </div>
</div>
