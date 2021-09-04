<?php

namespace Samchentw\Common\Helpers;

use Illuminate\Support\Traits\Macroable;
use Illuminate\Http\Request;

class SearchHelper
{
    /**
     * And 搜尋
     * @example  如下：
     * input:  $key = ['name','email','phone_number']  
     * output:  
     * [
     *      ['name','like',''.$request->name.''],
     *      ['email','like',''.$request->email.''],
     *      ['phone_number','like',''.$request->phone_number.'']
     * ]
     * 
     */
    public static function whereLikeMap(Request $request, $keys)
    {
        $body = $request->only($keys);
        $input = array_filter($body);
        $searchInput = collect($input)->map(function ($value, $key) {
            return [$key, 'like', '%' . $value . '%'];
        })->values()->all();
        return $searchInput;
    }
}
