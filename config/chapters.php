<?php

return [

    "list" => [

        "title" => "Requirement Chapters",
        "subtitle" => "List of all Requirement Chapters",
        "addButton" => [
            "text"=>"Add Chapter",
            "route"=>"/Tests/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [



            "title"=> [
                "title" => "Chapter Title",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],


            "project_name"=> [
                "title" => "Project",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "endproduct_name"=> [
                "title" => "End Product",
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
            "r" => "/Tests/view/",
            "w" => "/Tests/form/",
            "x" => "/Tests/delete/"
        ],

        "noitem" => "No Tests found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this Test from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Requirement Chapters",
        "subtitle" => "Create a New Requirement Chapter",
        "submitText" => "Add Chapter",
    ],

    "read" => [
        "title" => "Requirement Chapters",
        "subtitle" => "View Requirement Chapter Parameters",
        "submitText" => "Add Chapter",
    ],

    "update" => [
        "title" => "Requirement Chapters",
        "subtitle" => "Edit Requirement Chapter Properties",
        "submitText" => "Update Chapter",
    ],

    "cu_route" => "/Tests/store/",

    "form" => [

        "project"=> [
            "label" => "Project",
            "name" => "project",
            "options" => ""
        ],


        "rtype" => [
            "label" => "Test Type",
            "name" => "rtype",
            "placeholder" => "Enter project title/description",
            "value" => "",
            "options" => [
                "GR" => 'General Test',
                "TR" => 'Technical Test'
            ]
        ],

        "cross_ref_no" => [
            "label" => "Cross Reference Number",
            "name" => "cross_ref_no",
            "placeholder" => "Test number for referencing (optional)",
            "value" => ""
        ],


        "endproduct"=> [
            "label" => "End Products (Select all that apply)",
            "name" => "endproduct",
            "options" => "",
            "nooptions" => 'No End Products exist. All Tests will be linked to current project. If you want to link to End Products, create End Product first'
        ],

        "text" => [
            "label" => "Test Description",
            "name" => "text",
            "placeholder" => "Enter Test text/description",
            "value" => ""
        ],

        "remarks" => [
            "label" => "Remarks/Notes",
            "name" => "remarks",
            "placeholder" => "Enter remarks/notes",
            "value" => ""
        ]
    ]
];
