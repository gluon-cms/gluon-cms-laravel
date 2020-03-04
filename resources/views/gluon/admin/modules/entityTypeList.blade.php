
<ul class="entityTypeList">
    @foreach ($entityTypeList as $type)
    @php($classes = isset($settings[$type]) && isset($settings[$type]['css']) ? $settings[$type]['css'] : '')
    <li class="entityTypeList__entity {{ $type }} {{ $classes }} @if($type==$entityType) selected @endif"><a href="{{ url("admin/list", [$type]) }}">{{ trans("gluon.${type}_plural") }}</a></li>
    @endforeach

</ul>

<ul class="entityTypeList">
    <li class="entityTypeList__entity separated"><a href="">Administrateurs</a></li>
    <li class="entityTypeList__entity"><a href="">Utilisateurs</a></li>
</ul>