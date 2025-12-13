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
    ],

    'events' => [
        'metadata_stored' => [
            'group' => 'متادیتا',
            'title' => 'ذخیره متادیتا',
            'description' => 'هنگامی که متادیتا ذخیره می‌شود، این رویداد فعال می‌شود.',
        ],

        'metadata_storing' => [
            'group' => 'متادیتا',
            'title' => 'در حال ذخیره متادیتا',
            'description' => 'هنگامی که متادیتا در حال ذخیره است، این رویداد فعال می‌شود.',
        ],

        'metadata_deleted' => [
            'group' => 'متادیتا',
            'title' => 'حذف متادیتا',
            'description' => 'هنگامی که متادیتا حذف می‌شود، این رویداد فعال می‌شود.',
        ],

        'metadata_deleting' => [
            'group' => 'متادیتا',
            'title' => 'در حال حذف متادیتا',
            'description' => 'هنگامی که متادیتا در حال حذف است، این رویداد فعال می‌شود.',
        ],
    ],

];
