<?php

return [

    "list" => [
        "title" => "Milestones/Decision Gates",
        "subtitle" => "List of all Milestones/Decision Gates",
        "addButton" => [
            "text"=>"Add Milestone/Decision Gates",
            "route"=>"/projects-gates/form"
        ],
        "filterText" => "Search ...",
        "listCaption" => false,

        "headers" => [

            // "id"=> [
            //     "title" => "#",
            //     "sortable" => true,
            //     "align" => "left",
            //     "direction" => "asc"
            // ],

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
            "r" => "/projects-gates/view/",
            "w" => "/projects-gates/form/",
            "x" => "/projects-gates/delete/"
        ],
        "noitem" => "No Milestones/Decision Gates found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this milestones/decision gate from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],


    "create" => [
        "title" => "Milestones/Decision Gates",
        "subtitle" => "Create a New Milestone/Decision Gate",
        "submitText" => "Add Milestone/Decision Gate",
    ],

    "read" => [
        "title" => "Milestones/Decision Gates",
        "subtitle" => "View Milestone/Decision Gate Parameters",
        "submitText" => "Add Milestone/Decision Gate",
    ],

    "update" => [
        "title" => "Milestones/Decision Gates",
        "subtitle" => "Edit Milestone/Decision Gate Properties",
        "submitText" => "Update Milestone/Decision Gate",
    ]
];


