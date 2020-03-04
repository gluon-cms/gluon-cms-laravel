<div class="formItem text">
    <h2 class="formItem__label">{{ $key }}</h2>

    <div class="formItem__widget">

        @if($value) 
        @foreach($value as $index => $entity)

        <p>{{ $entity }} 
        <input type="text" value="{{ $entity->id }}" name="entity[{{ $type }}.{{ $key }}][{{ $index }}][id]" /> 
        <input type="text" value="{{ $index }}" name="entity[{{ $type }}.{{ $key }}][{{ $index }}][rank]">
        </p>
        
        
        @endforeach
        @endif

        <p><input type="text" value="" name="entity[{{ $type }}.{{ $key }}][][id]" /> </p>

    </div>

</div>
