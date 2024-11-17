<div class="modal fade" id="{{ $modalToggle }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route($action, $id) }}" method="POST" class="w-100">
        @csrf
        @method('delete')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalToggleLabel">{{ $title }} {{ $name }} ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <div class="modal-body">Show a second modal and hide this one with the button below.
            </div> --}}
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
