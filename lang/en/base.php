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
    ],

    "entity_names" => [
        "metadata" => "Metadata",
    ],

    'events' => [
        'metadata_stored' => [
            'title' => 'Metadata Stored',
            'description' => 'This event is triggered when metadata is stored.',
        ],

        'metadata_storing' => [
            'title' => 'Metadata Storing',
            'description' => 'This event is triggered when metadata is being stored.',
        ],

        'metadata_deleted' => [
            'title' => 'Metadata Deleted',
            'description' => 'This event is triggered when metadata is deleted.',
        ],

        'metadata_deleting' => [
            'title' => 'Metadata Deleting',
            'description' => 'This event is triggered when metadata is being deleted.',
        ],
    ],

];
