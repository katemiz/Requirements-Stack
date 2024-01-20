<?php

return [

    "list" => [
        "title" => "Means of Compliances (MOC) / Validation Methods",
        "subtitle" => "List of all Means of Compliances (MOC) / Validation Methods",
        "addButton" => [
            "text"=>"Add Means of Compliances (MOC)",
            "route"=>"/mocs/form"
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
                "sortable" => false,
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
            "r" => "/mocs/view/",
            "w" => "/mocs/form/",
            "x" => "/mocs/delete/"
        ],
        "noitem" => "No MOC/Means of Compliance found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this MOC from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "MOC - Means of Compliance",
        "subtitle" => "Create a New MOC - Means of Compliance",
        "submitText" => "Add MOC",
    ],

    "read" => [
        "title" => "MOC - Means of Compliance",
        "subtitle" => "View MOC - Means of Compliance Parameters",
        "submitText" => "Add MOC",
    ],

    "update" => [
        "title" => "MOC - Means of Compliance",
        "subtitle" => "Edit MOC - Means of Compliance Properties",
        "submitText" => "Update MOC",
    ]
];


