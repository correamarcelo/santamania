<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Filter extends Model
{
    static $filtersDefault = null;
    /**
     * @var array
     */
    protected $fillable = ['name', 'active', 'default'];

    public static function getFiltersDefault()
    {
        if (is_null(self::$filtersDefault)) {
            self::$filtersDefault = self::query()->where([
                'active'  => 1,
                'default' => 1,
            ])->get()->modelKeys();
        }

        return self::$filtersDefault;
    }

    /**
     * @return array
     */
    public static function productFilterTable(Array $ids = [])
    {
        $query = self::query()->where('active', 1);
        if (count($ids)) {
            $query->whereIn('id', $ids);
        }
//        else {
//            $query->whereIn('id', [3]);
//        }

        $filters = $query->get();

        $data = [];
        if ($filters->count()) {
            foreach ($filters as $filter) {
                $data['header'][$filter->id] = $filter->name;
            }
        }
        $categories = Product::listProductsFront();
        if ($categories->count()) {
            foreach ($categories as $category) {

                $rowProduct = [];
                foreach ($category['products'] as $product) {

                    $value = [];
                    foreach ($data['header'] as $id => $name) {
                        /** @var \App\Models\ProductFilter $productFilter */
                        if ($productFilter = $product->productFilters->where('filter_id', $id)->first()) {

                            $value[$productFilter->filter_id] = $productFilter->value;
                        } else {
                            $value[$id] = 0;
                        }
                    }

                    $rowProduct[$product->id] = ['product' => $product, 'values' => $value];
                }

                $data['categories'][] = ['category' => $category['category'], 'products' => $rowProduct];
            }
        }

        return $data;
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($item) {
            $uid = uniqid();
            while (self::query()->where('uid', '=', $uid)->count() > 0) {
                $uid = uniqid();
            }
            $item->uid = $uid;
        });
    }
}
