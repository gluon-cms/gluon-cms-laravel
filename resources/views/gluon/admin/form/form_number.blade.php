<div class="formItem number">
    <h2 class="formItem__label">{{ $key }}</h2>

    <div class="formItem__widget">
        <gluon-parameter-number 
            :initial-value='@json($value)'
            :constraints='@json($constraints)'
            input-name-prefix="entity[number.{{ $key }}]"
        / >
    </div>

</div>



