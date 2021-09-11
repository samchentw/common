<?php

namespace Samchentw\Common\Traits\Supports;


trait HasEnable
{

    /**
     * Initialize the trait
     * 
     * @return void
     */
    public function initializeHasEnable()
    {
        $this->fillable[] = 'enable';
        $this->casts['enable'] = 'boolean';
    }


    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnableTrueQuery($query)
    {
        return $query->where('enable', true);
    }

    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnableFalseQuery($query)
    {
        return $query->where('enable', false);
    }


    /**
     * Scope a query to only include popular users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param boolean $enable
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEnableQuery($query, $enable)
    {
        return $query->where('enable', $enable);
    }
}
