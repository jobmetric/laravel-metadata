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

    'events' => [
        'metadata_stored' => [
            'group' => 'Metadata',
            'title' => 'Metadata Stored',
            'description' => 'This event is triggered when metadata is stored.',
        ],

        'metadata_storing' => [
            'group' => 'Metadata',
            'title' => 'Metadata Storing',
            'description' => 'This event is triggered when metadata is being stored.',
        ],

        'metadata_deleted' => [
            'group' => 'Metadata',
            'title' => 'Metadata Deleted',
            'description' => 'This event is triggered when metadata is deleted.',
        ],

        'metadata_deleting' => [
            'group' => 'Metadata',
            'title' => 'Metadata Deleting',
            'description' => 'This event is triggered when metadata is being deleted.',
        ],
    ],

];
