<?php

return [

    "list" => [
        "title" => "Application Roles",
        "subtitle" => "List of all Application Roles",
        "addButton" => [
            "text"=>"Add Role",
            "route"=>"/admin-roles/form"
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

            "name"=> [
                "title" => "Name",
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
            "r" => "/admin-roles/view/",
            "w" => "/admin-roles/form/",
            "x" => "/admin-roles/delete/"
        ],
        "noitem" => "No roles found in database yet!",
        "delete_confirm" => [
            "question" => "Do you want to delete this role from database?",
            "last_warning" => "When done, it is not possible to revert back."
        ]
    ],


    "create" => [
        "title" => "Roles",
        "subtitle" => "Create a Role",
        "submitText" => "Add Role",
    ],

    "read" => [
        "title" => "Roles",
        "subtitle" => "View Role Parameters",
        "submitText" => "Add Role",
    ],

    "update" => [
        "title" => "Roles",
        "subtitle" => "Edit Role Properties",
        "submitText" => "Update Role",
    ],


];


