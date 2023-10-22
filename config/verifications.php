<?php

return [

    "add" => [
        "title" => "Verifications",
        "subtitle" => "Add new verification to selected requirement",
    ],

    "list" => [
        "title" => "Requirements",
        "subtitle" => "List of all requirements",
        "addButton" => [
            "text"=>"Add Requirement",
            "route"=>"/requirements/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "id"=> [
                "title" => "#",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "project_id"=> [
                "title" => "Project",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "type"=> [
                "title" => "Type",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],
            "text"=> [
                "title" => "Requirement Text",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "created_at"=> [
                "title" => "Created On",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ]

        ],
        "actions" => [
            "r" => "/requirements/view/",
            "w" => "/requirements/form/",
            "x" => "/requirements/delete/"
        ],
        "noitem" => "No verifications found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this verification from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Verifications",
        "subtitle" => "Create a New Verification",
        "submitText" => "Add Verification",
    ],

    "read" => [
        "title" => "Requirements",
        "subtitle" => "View Requirement Parameters",
        "submitText" => "Add Requirement",
    ],

    "update" => [
        "title" => "Verifications",
        "subtitle" => "Edit Verification Properties",
        "submitText" => "Update Verification",
    ],




];
