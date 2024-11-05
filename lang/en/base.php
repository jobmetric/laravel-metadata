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
        "exist" => "The :field already exists.",
    ],

    "exceptions" => [
        "key_not_found" => "Metadata key ':key' not found!",
        "key_not_allowed" => "Model ':model' not allowed ':key' in function 'metadataAllowFields'",
        "trait_not_found" => "Model ':model' not use 'JobMetric\Metadata\HasMeta' Trait!",
        "interface_not_found" => "Model ':model' not implements 'JobMetric\Metadata\Contracts\MetaContract' interface!",
    ],

    "components" => [
        'metadata_card' => [
            'title' => 'Additional Information',
        ],
    ],

];
