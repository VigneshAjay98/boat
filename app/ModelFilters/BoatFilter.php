<?php

namespace App\ModelFilters;

use EloquentFilter\ModelFilter;

class BoatFilter extends ModelFilter
{
    /**
    * Related Models that have ModelFilters as well as the method on the ModelFilter
    * As [relationMethod => [input_key1, input_key2]].
    *
    * @var array
    */
    public $relations = [];

    public function name($name)
    {
        return $this->where('boat_name', $name);
    }

    public function category($name)
    {
        return $this->join('categories','categories.id','=','boats.category_id')->where('categories.name', $name);
    }

    public function yearFrom($year)
    {
        return $this->where('year', '<=' , $year);
    }

    public function yearTo($year)
    {
        return $this->where('year', '>=' , $year);
    }

    public function brand($brand)
    {
        return $this->join('brands','brands.id','=','boats.brand_id')->where('brands.name', $brand);
    }

    public function model($model)
    {
        return $this->where('model', $model);
    }
}
