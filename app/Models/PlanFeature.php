<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanFeature extends Model
{
    use HasFactory;
    protected $guarded =[];
    public function plan() {
        return $this->belongsTo(Plan::class, 'plan_uuid', 'id');
    }

    public function feature() {
        return $this->belongsTo(Feature::class, 'feature_id', 'id');
    }
}
