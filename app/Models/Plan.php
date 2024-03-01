<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;


    protected $guarded =[];

    // protected $fillable = [
    //     'uuid', // make sure 'uuid' is in your fillable array
    //     'name',
    //     'short_description',
    //     'monthly_price',
    //     'year_price',
    //     'trial',
    // ];

      // Specify the column to use for route model binding
    //   public function getRouteKeyName()
    //   {
    //       return 'uuid';
    //   }
}
