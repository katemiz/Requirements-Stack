<?php

return [

    "list" => [
        "title" => "Project Witnesses",
        "subtitle" => "List of all Witnesses",
        "addButton" => [
            "text"=>"Add Witness",
            "route"=>"/projects-witnesses/form"
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

            "project_name"=> [
                "title" => "Project",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "end_product_name"=> [
                "title" => "End Product",
                "sortable" => false,
                "align" => "left",
                "direction" => "asc"
            ],            

            "code"=> [
                "title" => "Code",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],
            "name"=> [
                "title" => "Title",
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
            "r" => "/projects-witnesses/view/",
            "w" => "/projects-witnesses/form/",
            "x" => "/projects-witnesses/delete/"
        ],
        "noitem" => "No witnesses found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this witnesses from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Project Witnesses",
        "subtitle" => "Create a Witnesses",
        "submitText" => "Add Witnesses",
    ],

    "read" => [
        "title" => "Project Witnesses",
        "subtitle" => "View Witnesses Parameters",
        "submitText" => "Add Witnesses",
    ],

    "update" => [
        "title" => "Project Witnesses",
        "subtitle" => "Edit Witnesses Properties",
        "submitText" => "Update Witnesses",
    ]
];


