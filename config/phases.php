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
    
            "project_name"=> [
                "title" => "Project",
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

    "select_current" => [
        "title" => "Projects",
        "subtitle" => "Select current project",
    ],

    "create" => [
        "title" => "Projects",
        "subtitle" => "Create a New Project",
        "submitText" => "Add Project",
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

];


