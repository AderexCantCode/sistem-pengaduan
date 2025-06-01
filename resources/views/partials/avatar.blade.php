@php
    $size = isset($size) ? intval($size) * 4 : 32;
    $fontSize = $size / 2;
    $firstInitial = strtoupper(substr($user->name, 0, 1) ?? '?');
@endphp

<div class="rounded-full bg-indigo-500 text-white flex items-center justify-center font-bold shadow"
     style="width: {{ $size }}px; height: {{ $size }}px; font-size: {{ $fontSize }}px;">
    {{ $firstInitial }}
</div>
