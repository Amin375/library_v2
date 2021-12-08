<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookCopy extends Model
{
    use HasFactory;

    public $table = 'book_copies';

    protected $fillable = [
        'book_id'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }
}