<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Orchid\Screen\AsSource;

class Video extends Model
{
    use AsSource;

    /**
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'body',
        'author',
        'bitchute_channel',
        'urls'
		
    ];
    
    // required because the urls field is json encoded
    // this will auto decode urls when it is fetched from Video model
    protected $casts = [
		'urls' => 'array',
		];

}
