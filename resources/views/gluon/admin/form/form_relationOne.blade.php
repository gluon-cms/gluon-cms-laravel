<p>
    <strong>{{ $propertyName }}:</strong>
    Id:<input type="text" value="{{ $value->id }}" name="entity[{{ $type }}.{{ $propertyName }}]" /> ({{ $value->type }} - {{ $value }})
</p>
