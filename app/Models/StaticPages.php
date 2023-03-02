<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class StaticPages extends Model
{
    protected $table = 'static_pages';
    protected $fillable = [
        'id', 'title', 'description', 'image', 'status','is_deleted'
    ]; 
}