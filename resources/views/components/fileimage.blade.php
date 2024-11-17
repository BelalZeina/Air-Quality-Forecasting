{{--{{ $settings->valueOf('site_main_logo') ? '' : 'image-input-empty' }}--}}
{{--{{ $settings->valueOf('site_main_logo') ? 'false' : 'true' }}--}}
{{--{{ panel_image_url($settings->valueOf('site_main_logo')) }}--}}
<div
    class="image-input image-input-outline {{ @$gallery_image_class ?? 'gallery_image_wrapper' }} {{ $image ? '' : 'image-input-empty' }}"
    data-kt-image-input="{{ $image ? 'false' : 'true' }}"
    style="background-image: url({{asset('assets/images/placeholder.png')}})">
    <!--begin::Image preview wrapper-->
    <div class="image-input-wrapper w-{{@$width ?? '100'}}px h-{{@$height ?? '100'}}px"
         style=" background-image: url('{{ image_url($image) }}');"></div>
    <!--end::Image preview wrapper-->
    <!--begin::Edit button-->
    <label
        class="btn btn-icon btn-circle btn-color-muted btn-active-color-primary w-25px h-25px bg-body shadow custom-file"
        data-multiple="false" data-add-button="true" data-image-wrapper="{{ @$gallery_image_wrapper ?? '.gallery_image_wrapper' }}"
        data-kt-image-input-action="change"
        data-bs-toggle="tooltip"
        data-bs-dismiss="click"
        title="{{ $image ? __('Edit Image') : __('Add Image') }}">
        <i class="bi bi-pencil-fill fs-7"></i>
        <!--begin::Inputs-->
        <input type="file" name="{{ @$name_attr }}"
               accept=".png, .jpg, .jpeg, .webp, .svg"/>
{{--        <input type="text" class="gallery_grud_image_input" name="{{ @$name_attr }}" value="{{ @$image }}" accept=".png, .jpg, .jpeg, .svg"/>--}}

        <input type="hidden" name="main_logo_remove"/>
        <!--end::Inputs-->
    </label>
    <!--end::Edit button-->
</div>
