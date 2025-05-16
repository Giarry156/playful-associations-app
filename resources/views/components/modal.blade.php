<div class="modal-layer active {{ $className ?? '' }}">
    <div class="modal">
        <div class="modal-body">
            <div class="modal-main">
                <h2>{{$modalTitle}}</h2>
                <div class="modal-content">
                    {{$slot}}
                </div>
            </div>
            <div class="modal-actions">
                {{$actions}}
            </div>
        </div>
    </div>
</div>
