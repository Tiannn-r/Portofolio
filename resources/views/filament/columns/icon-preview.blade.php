@php
    $record = $getRecord();
    $icon = trim($record->icon ?? '');
    $isSvg = str_starts_with($icon, '<svg');
    $iconUrl = $record->icon_url ?? null;
@endphp

<div class="flex items-center justify-center w-9 h-9 p-1 rounded-lg bg-gray-900 border border-gray-700 overflow-hidden">
    @if($isSvg)
        <div class="w-full h-full flex items-center justify-center [&>svg]:w-full [&>svg]:h-full [&>svg]:object-contain">
            {!! $icon !!}
        </div>
    @elseif($iconUrl)
        <img src="{{ $iconUrl }}" alt="{{ $record->name ?? $record->title ?? 'Icon' }}" class="w-full h-full object-contain" loading="lazy" />
    @else
        <span class="text-[10px] text-gray-500 font-mono">No icon</span>
    @endif
</div>
