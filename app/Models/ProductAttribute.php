<?php
// app/Models/ProductAttribute.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    protected $fillable = ['name', 'type'];

    public function values()
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }
}



