<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use MongoDB\Laravel\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'description',
        'regular_price',
        'sale_price',
        'SKU',
        'stock_status',
        'featured',
        'quantity',
        'category_id',
        'brand_id',
    ];

    protected function images(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // $value هو القيمة الخام من قاعدة البيانات (سلسلة JSON أو null)
                if (empty($value)) {
                    return []; // إرجاع مصفوفة فارغة إذا كانت القيمة null أو فارغة
                }
                $decoded = json_decode($value, true); // true لتحويلها لمصفوفة PHP

                // التحقق من أن فك الترميز تم بنجاح وأن الناتج مصفوفة
                if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                    return $decoded;
                }

                // كاحتياطي: إذا فشل فك ترميز JSON (ربما بيانات قديمة كانت نصية؟)
                // يمكنك محاولة explode هنا أو فقط إرجاع مصفوفة فارغة لمنع الأخطاء
                // Log::warning("Product ID {$this->id}: Could not decode images JSON: " . $value);
                return []; // الأفضل إرجاع فارغة لتجنب مشاكل لاحقة
            }
        // لا تحتاج لـ set هنا لأنك تتعامل معه في الكونترولر بـ json_encode
        );
    }


    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function brand(){
        return $this->belongsTo(Brand::class);
    }
}
