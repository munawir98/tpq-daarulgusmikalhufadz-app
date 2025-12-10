@props(['name', 'class' => 'w-5 h-5'])

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" {{
    $attributes->merge(['class' => $class]) }}>

    @switch($name)

    @case('home')
    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9v9a2 2 0 01-2 2H5a2 2 0 01-2-2v-9z" />
    @break

    @case('document-text')
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0
               002-2V9l-5-5z" />
    @break

    @case('user-group')
    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20v-2a4 4 0 00-3-3.87M9
               14.13A4 4 0 006 18v2m9-14a3 3 0 11-6 0
               3 3 0 016 0z" />
    @break

    @case('academic-cap')
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
    @break

    @case('chevron-double-left')
    <path stroke-linecap="round" stroke-linejoin="round" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
    @break

    @case('moon')
    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3a9 9 0 109 9 7 7 0 01-9-9z" />
    @break

    @endswitch

</svg>
