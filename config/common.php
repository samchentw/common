<?php

return [

    /**
     * 設定使用SORT的排序
     * asc：由小至大排序
     * desc：由大至小排序
     */
    "model_sort" => env('MODEL_SORT','asc'),

    /**
     * 產生router-list用
     * 指令：php artisan output:router-list
     */
    "router_list_methods" => [
        "GET",
        "HEAD",
        "POST",
        "PUT",
        "PATCH",
        "DELETE"
    ]
];
