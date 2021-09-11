<?php

namespace Samchentw\Common\Traits\Supports;


trait HasSort
{

    /**
     * Initialize the trait
     * 
     * @return void
     */
    public function initializeHasSort()
    {
        $this->fillable[] = 'sort';
    }

    public function scopeSortByConfig($query)
    {
        if (config('common.model_sort') == 'asc') {
            return $query->orderBy('sort');
        } else if (config('common.model_sort') == 'desc') {
            return $query->orderByDesc('sort');
        }
    }

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
