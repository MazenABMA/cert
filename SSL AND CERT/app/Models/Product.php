<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model  {

	protected $fillable = [
        'code', 'name', 'model', 'description', 'price', 'photo', 'stock'
    ];
    
    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    /**
     * Get the average rating for the product
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?: 0;
    }
    
    /**
     * Get the total number of reviews for the product
     */
    public function getReviewsCountAttribute()
    {
        return $this->reviews()->count();
    }
}
