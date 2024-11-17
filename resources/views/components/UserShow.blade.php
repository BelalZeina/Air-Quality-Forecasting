<div class="modal fade" id="{{ $modalToggle }}" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
            @php
                $user=App\Models\User::find($id);
            @endphp
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="d-flex justify-content-start align-items-center mb-6">
                        <div class="avatar me-3">
                            <img src="{{ image_url($user?->img) }}" alt="Avatar" class="rounded-circle">
                        </div>
                        <div class="d-flex flex-column">
                            <h6 class="mb-0">{{ $user?->name }}</h6>
                            <span>{{ __('home.Customer ID:') }} #{{ $user?->id }}</span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-6 mt-2">
                    </div>
                    <div class="d-flex justify-content-between  mt-2">
                        <h6 class="mb-1">{{ __('home.Contact info') }}</h6>
                    </div>
                    {{-- <p class=" mb-1">{{ __('home.Email:') }} {{ $user?->email }}</p> --}}
                    <p class=" mb-0">{{ __('home.Mobile:') }} {{ $user?->mobile }}</p>
                    <p class=" mb-1">{{ __('job') }}: {{__( $user?->job) }}</p>
                </div>

            </div>
    </div>
</div>
