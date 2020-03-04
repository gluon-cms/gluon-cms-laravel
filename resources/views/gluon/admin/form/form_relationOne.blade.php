<div class="formItem text">
    <h2 class="formItem__label">{{ $key }}</h2>

    <div class="formItem__widget">
        <input type="text" value="{{ $value ? $value->id : null }}" name="entity[{{ $type }}.{{ $key }}]" width="5" />
        @if($value) <p>{{ $value }}</p> @endif
    </div>

</div>
