<?php

return [

    "list" => [
        "title" => "Decision Gates / Meetings",
        "subtitle" => "List of all Decision Gates",
        "addButton" => [
            "text"=>"Add Decision Gates",
            "route"=>"/dgates/form"
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

            "company_name"=> [
                "title" => "Company",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "code"=> [
                "title" => "Code",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],
            "title"=> [
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
            "r" => "/dgates/view/",
            "w" => "/dgates/form/",
            "x" => "/dgates/delete/"
        ],
        "noitem" => "No Decision Gates found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this project from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "select_current" => [

        "title" => "Projects",
        "subtitle" => "Select current project",

    ],

    "create" => [
        "title" => "Decision Gates",
        "subtitle" => "Create a New Decision Gate",
        "submitText" => "Add Decision Gate",
    ],

    "read" => [
        "title" => "Projects",
        "subtitle" => "View Project Parameters",
        "submitText" => "Add Project",
    ],

    "update" => [
        "title" => "Projects",
        "subtitle" => "Edit Project Properties",
        "submitText" => "Update Project",
    ],

    "cu_route" => "/projects/store/",


    "form" => [

        "project"=> [
            "label" => "Project",
            "name" => "project",
            "options" => ""
        ],

        "code" => [
            "label" => "decision Gate Code",
            "name" => "code",
            "placeholder" => "Enter Decision Gate Code",
            "value" => ""
        ],

        "title" => [
            "label" => "Decision Gate Title",
            "name" => "title",
            "placeholder" => "Enter decision gate title/description",
            "value" => ""
        ]
    ]
];


