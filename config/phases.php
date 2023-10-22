<?php

return [

    "list" => [
        "title" => "Project Phases",
        "subtitle" => "List of all project phases",
        "addButton" => [
            "text"=>"Add Phase",
            "route"=>"/projects-phases/form"
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


            "code"=> [
                "title" => "Phase Code",
                "sortable" => true,
                "align" => "left",
                "direction" => "asc"
            ],

            "name"=> [
                "title" => "Phase Title",
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
            "r" => "/projects-phases/view/",
            "w" => "/projects-phases/form/",
            "x" => "/projects-phases/delete/"
        ],
        "noitem" => "No project phases found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this project phase from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],


    "create" => [
        "title" => "Project Phases",
        "subtitle" => "Create a New Project Phase",
        "submitText" => "Add Project Phase",
    ],

    "read" => [
        "title" => "Project Phases",
        "subtitle" => "View Project Phase Parameters",
        "submitText" => "Add Project Phase",
    ],

    "update" => [
        "title" => "Project Phases",
        "subtitle" => "Edit Project PhaseProperties",
        "submitText" => "Update Project Phase",
    ],

];


