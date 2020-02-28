<p>
    <strong>{{ $propertyName }}:</strong>

    @foreach($value as $index => $entity)
    <li>Id:
        <input type="text" value="{{ $entity->id }}" name="entity[{{ $type }}.{{ $propertyName }}][{{ $index }}][id]" /> rank : 
        <input type="text" value="{{ $index }}" name="entity[{{ $type }}.{{ $propertyName }}][{{ $index }}][rank]">

        ({{ $entity->type }} - {{ $entity }})
    </li>
    @endforeach

    
</p>
