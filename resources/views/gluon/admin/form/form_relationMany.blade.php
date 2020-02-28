<p>
    <strong>{{ $propertyName }}:</strong>

    @foreach($value as $entity)
    <li>Id:<input type="text" value="{{ $entity->id }}" name="entity[{{ $type }}.{{ $propertyName }}]" /> ({{ $entity->type }} - {{ $entity }})</li>
    @endforeach

    
</p>
