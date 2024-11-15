function datatableShowDetailsMetadata(data) {
    let html = ``

    html += `<div class="col-12 col-md-4 mt-3">
                <div class="card card-flush h-xl-100">
                    <div class="card-header pt-7">
                        <h3 class="card-title align-items-start flex-column">
                            <span class="card-label fw-bold text-dark">${localize.language.metadata.components.metadata_card.title}</span>
                        </h3>
                    </div>
                    <div class="card-body pt-2">
                        <div class="row">
                            <div class="col-12">`
                                $.each(data.metas, function(key, meta) {
                                    $.each(meta, function(meta_key, value) {
                                        html += `<div class="col-12">
                                                    <div class="d-flex justify-content-between align-items-center border border-dashed border-hover-secondary p-3">
                                                        <div>${eval(`localize.taxonomy.metadata.${meta_key}.label`)}</div>
                                                        <div>${value}</div>
                                                    </div>
                                                </div>`
                                    })
                                })
                    html += `</div>
                        </div>
                    </div>
                </div>
            </div>`

    return html
}
