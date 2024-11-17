<div class="modal fade" id="{{ $modalToggle }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route($action, $id) }}" method="POST" class="w-100">
        @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">{{ $title }} {{ $name }} ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        @include('components.input', [
                            'value' => old('payment'),
                            'name' => 'payment',
                            'type' => 'text',
                            'label' => 'payment',
                            'placeholder' => '123',
                        ])
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" aria-label="Close">
                        No
                    </button>
                        <button type="submit" class="btn btn-primary d-flex align-items-center gap-2">Yes</button>
                </div>
            </div>
        </form>
    </div>
</div>
