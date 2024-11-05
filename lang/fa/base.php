<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Base Metadata Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during Metadata for
    | various messages that we need to display to the user.
    |
    */

    "rule" => [
        "exist" => ":field در حال حاضر وجود دارد.",
    ],

    "exceptions" => [
        "key_not_found" => "کلید متادیتا ':key' یافت نشد!",
        "key_not_allowed" => "مدل ':model' در تابع 'metadataAllowFields' ':key' را مجاز نمی داند",
        "trait_not_found" => "مدل ':model' از 'JobMetric\Metadata\HasMeta' Trait استفاده نمی کند!",
        "interface_not_found" => "مدل ':model' از 'JobMetric\Metadata\Contracts\MetaContract' interface پیروی نمی کند!",
    ],

    "components" => [
        'metadata_items' => [
            'title' => 'اطلاعات اضافی',
        ],
    ],

];
