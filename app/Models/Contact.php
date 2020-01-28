<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'subject_id',
        'message'
    ];
}
