<?php

namespace Samchentw\Common\Helpers;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

class SortHelper
{
    /**
     * Add default sort set columns to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function columns($table)
    {
        $table->integer('sort')->default(0);
    }

    /**
     * Drop sort columns.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function dropColumns($table)
    {
        $table->integer('sort');
    }
}
