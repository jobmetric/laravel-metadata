<!--begin::Metadata-->
<div class="card card-flush py-4 mb-10">
    <div class="card-header">
        <div class="card-title">
            <span class="fs-5 fw-bold">{{ trans('metadata::base.components.metadata_card.title') }}</span>
        </div>
    </div>
    <div class="card-body">
        @foreach($items as $metadata_key => $metadata_value)
            <div class="mb-10">
                <label class="form-label d-flex justify-content-between align-items-center">
                    <span>{{ trans($metadata_value['label']) }}</span>
                    <div class="text-gray-600 fs-7 d-none d-md-block d-lg-none d-xl-block">{{ trans($metadata_value['info']) }}</div>
                </label>

                @if($metadata_value['type'] === 'textarea')
                    <textarea name="metadata[{{ $metadata_key }}]" class="form-control" rows="3" placeholder="{{ trans($metadata_value['placeholder']) }}">{{ $values[$metadata_key] ?? '' }}</textarea>
                @endif
                @if($metadata_value['type'] === 'text')
                    <input type="text" name="metadata[{{ $metadata_key }}]" class="form-control" placeholder="{{ trans($metadata_value['placeholder']) }}" value="{{ $values[$metadata_key] ?? '' }}">
                @endif
                @if($metadata_value['type'] === 'number')
                    <input type="number" name="metadata[{{ $metadata_key }}]" class="form-control" placeholder="{{ trans($metadata_value['placeholder']) }}" value="{{ $values[$metadata_key] ?? '' }}">
                @endif

                @error('metadata.' . $metadata_key)
                    <div class="form-errors text-danger fs-7 mt-2">{{ $message }}</div>
                @enderror
            </div>
        @endforeach
    </div>
</div>
<!--end::Metadata-->
