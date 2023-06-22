<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Menu;

class Restaurant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'city',
        'address',
    ];

    protected $guarded = ['created_at','updated_at'];

    //* Relationship
    public function menus(){
        return $this->hasMany(Menu::class);
    }
}
