<?php

namespace Samchentw\Common\Traits\Supports;


trait HasSort
{
     /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortOrderBy($query)
    {
        return $query->orderBy('sort');
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSortOrderByDesc($query)
    {
        return $query->orderByDesc('sort');
    }

}