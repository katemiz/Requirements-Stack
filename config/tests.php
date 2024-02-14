<?php

return [

    "list" => [

        "title" => "Tests",
        "subtitle" => "List of all Tests",
        "addButton" => [
            "text"=>"Add Test",
            "route"=>"/Tests/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            "test_no"=> [
                "title" => "Type",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "remarks"=> [
                "title" => "Test Title",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc",
                "is_html" => true
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
        "title" => "Tests",
        "subtitle" => "Create a New Test",
        "submitText" => "Add Test",
    ],

    "read" => [
        "title" => "Tests",
        "subtitle" => "View Test Parameters",
        "submitText" => "Add Test",
    ],

    "update" => [
        "title" => "Tests",
        "subtitle" => "Edit Test Properties",
        "submitText" => "Update Test",
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
