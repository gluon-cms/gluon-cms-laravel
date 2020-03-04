<div class="formItem text">
    <h2 class="formItem__label">{{ $key }}</h2>

    <div class="formItem__widget">
        <gluon-parameter-text 
        :initial-value='@json($value)'
        :constraints='@json($constraints)'
        input-name-prefix="entity[text.{{ $key }}]"
        / >
    </div>

</div>