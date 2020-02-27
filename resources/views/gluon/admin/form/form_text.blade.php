<p>
    <label>{{ $propertyName }}</label>

    @foreach ($value->getValues() as $key => $finalValue)
        {{ $key }} : <textarea name="entity[{{ $type }}.{{ $propertyName }}][{{ $key }}]">{{ $finalValue }}</textarea>
    @endforeach

</p>