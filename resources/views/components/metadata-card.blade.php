<!--begin::Metadata-->
<div class="card card-flush py-4 mb-10">
    <div class="card-header">
        <div class="card-title">
            <span class="fs-5 fw-bold">{{ trans('metadata::base.components.metadata_card.title') }}</span>
        </div>
    </div>
    <div class="card-body">
        @foreach($items as $meta)
            @php
                /**
                 * @var \JobMetric\Metadata\ServiceType\Metadata $meta
                 */
            @endphp
            {!! $meta->customField->render($values[$meta->customField->params['uniqName']], hasErrorTagForm: true) !!}
        @endforeach
    </div>
</div>
<!--end::Metadata-->
