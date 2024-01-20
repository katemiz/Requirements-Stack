<?php

return [

    "list" => [
        "title" => "Proof of Compliances (POC)",
        "subtitle" => "List of all Proof of Compliances (POC)",
        "addButton" => [
            "text"=>"Add Proof of Compliances (POC)",
            "route"=>"/pocs/form"
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
            "r" => "/pocs/view/",
            "w" => "/pocs/form/",
            "x" => "/pocs/delete/"
        ],
        "noitem" => "No POC/Proof of Compliance found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this POC from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "POC - Proof of Compliance",
        "subtitle" => "Create a New POC - Proof of Compliance",
        "submitText" => "Add POC - Proof of Compliance",
    ],

    "read" => [
        "title" => "POC - Proof of Compliance",
        "subtitle" => "View POC - Proof of Compliance Parameters",
        "submitText" => "Add POC - Proof of Compliance",
    ],

    "update" => [
        "title" => "POC - Proof of Compliance",
        "subtitle" => "Edit POC - Proof of Compliance Properties",
        "submitText" => "Update POC - Proof of Compliance",
    ]
];


