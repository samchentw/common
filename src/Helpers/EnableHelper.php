<?php

namespace Samchentw\Common\Helpers;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Http\Request;
use Illuminate\Database\Schema\Blueprint;

class EnableHelper
{
  /**
     * Add default enable set columns to the table.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function columns($table)
    {
        $table->boolean('enable')->default(true);
    }

    /**
     * Drop enable columns.
     *
     * @param \Illuminate\Database\Schema\Blueprint $table
     */
    public static function dropColumns($table)
    {
        $table->dropColumn('enable');
    }

}
