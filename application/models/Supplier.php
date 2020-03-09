<?php

class Supplier extends ActiveRecord\Model
{
    public static $table_name = 'supplier';

    public static $belongs_to = array(
        array('bank', 'foreign_key' => 'bank_id'),
    );

    public static $has_many = array(
    );

    public static function supplierCategoriesStr($categories){
        $cats = explode(',', $categories);

        $cats_names = [];

        foreach ($cats as $cat){
            $sup_cat = SupplierCategory::find($cat);
            array_push($cats_names, $sup_cat->name);
        }

        return implode(', ', $cats_names);
    }
}
