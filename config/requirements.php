<?php

return [

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

            "requirement_no"=> [
                "title" => "No",
                "sortable" => true,
                "class" => "has-text-left is-narrow",
                "direction" => "asc"
            ],

            // "rtype"=> [
            //     "title" => "Type",
            //     "sortable" => true,
            //     "align" => "left",
            //     "direction" => "asc"
            // ],

            // "requirement_no"=> [
            //     "title" => "No",
            //     "sortable" => true,
            //     "align" => "left",
            //     "direction" => "asc"
            // ],

            // "revision"=> [
            //     "title" => "Rev",
            //     "sortable" => true,
            //     "align" => "left",
            //     "direction" => "asc"
            // ],

            "project_name"=> [
                "title" => "Project",
                "sortable" => false,
                "class" => "has-text-left",
                "direction" => "asc"
            ],


            "text"=> [
                "title" => "Requirement Text",
                "sortable" => true,
                "class" => "has-text-left",
                "direction" => "asc",
                "is_html" => true
            ],

            "created_at"=> [
                "title" => "Created On",
                "sortable" => true,
                "class" => "has-text-left",
                "direction" => "asc"
            ]

        ],
        "actions" => [
            "r" => "/requirements/view/",
            "w" => "/requirements/form/",
            "x" => "/requirements/delete/"
        ],

        "noitem" => "No requirements found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this requirement from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],

    "create" => [
        "title" => "Requirements",
        "subtitle" => "Create a New Requirement",
        "submitText" => "Add Requirement",
    ],

    "read" => [
        "title" => "Requirements",
        "subtitle" => "View Requirement Parameters",
        "submitText" => "Add Requirement",
    ],

    "update" => [
        "title" => "Requirements",
        "subtitle" => "Edit Requirement Properties",
        "submitText" => "Update Requirement",
    ],

    "cu_route" => "/requirements/store/",

    "form" => [

        "project"=> [
            "label" => "Project",
            "name" => "project",
            "options" => ""
        ],


        "rtype" => [
            "label" => "Requirement Type",
            "name" => "rtype",
            "placeholder" => "Enter project title/description",
            "value" => "",
            "options" => [
                "GR" => 'General Requirement',
                "TR" => 'Technical Requirement',
                "DEF" => 'Definition',
            ]
        ],

        "cross_ref_no" => [
            "label" => "Cross Reference Number",
            "name" => "cross_ref_no",
            "placeholder" => "Requirement number for referencing (optional)",
            "value" => ""
        ],


        "endproduct"=> [
            "label" => "End Products (Select all that apply)",
            "name" => "endproduct",
            "options" => "",
            "nooptions" => 'No End Products exist. All requirements will be linked to current project. If you want to link to End Products, create End Product first'
        ],

        "text" => [
            "label" => "Requirement Description",
            "name" => "text",
            "placeholder" => "Enter requirement text/description",
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
