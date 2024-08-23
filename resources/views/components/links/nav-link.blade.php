@props(['active' => false])

<li><a {{ $attributes }} @class(['active' => $active])> {{ $slot }}</a></li>