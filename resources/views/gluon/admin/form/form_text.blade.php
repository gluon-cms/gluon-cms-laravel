
<div>
    {{ $propertyName }} (Type: {{ $type }})

    @foreach ($value->getValues() as $key => $finalValue)
        {{ $key }} : <textarea name="entity[{{ $entity->id }}][{{ $type }}__{{ $propertyName }}__{{ $key }}]">{{ $finalValue }}</textarea> -- 
    @endforeach

    Entity : {{ $entity->id }}

</div>
