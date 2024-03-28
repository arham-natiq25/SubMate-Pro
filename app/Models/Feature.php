<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    use HasFactory;

    protected $guarded =[];

    public function planFeatures()
    {
        return $this->hasMany(PlanFeature::class, 'feature_id');
    }

    // Define the inverse relationship with Plan
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_features', 'feature_id', 'plan_uuid');
    }
}
