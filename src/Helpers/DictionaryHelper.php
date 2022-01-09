<?php

namespace Samchentw\Common\Helpers;

class DictionaryHelper
{
    /**
     * 將陣列物件轉成自訂陣列
     * 
     * @param array $array 陣列物件
     * @param string $keyColumn 要當key值的欄位名稱
     * @param string|null $valueColumn 要當value的欄位，可為空為空將回傳整個物件
     * @example example: 
     * $input=[["name"=>"sam","age"=>25],["name"=>"vivian","age"=>24]]  
     * use funtion: toDictionary($input,'name','age')  
     * output: ["sam"=>25,"vivian"=>24]; 
     */
    public static function toDictionary(array $array, string $keyColumn, $valueColumn = null)
    {
        $collection = collect($array);

        $result = $collection->mapWithKeys(function ($item) use ($keyColumn, $valueColumn) {
            $value = $item;
            if (isset($valueColumn)) $value = $item[$valueColumn];
            return [$item[$keyColumn] => $value];
        })->all();

        return $result;
    }

}
