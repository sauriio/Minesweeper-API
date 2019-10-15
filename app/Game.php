<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    /**
     * use timestamps.
     *
     * @var bool
     */
    public $timestamps = true;
    /**
     * table name.
     *
     * @var string
     */
    protected $table = 'game';
    /**
     * primary key of table.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'paused',
        'rows',
        'columns',
        'mines',
        'payload',
        'initializated',
        'seconds_played',
        'is_over',
    ];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'payload',
    ];
    /**
     * cast table rows.
     *
     * @var array
     */
    protected $casts = [
        'paused' => 'boolean',
        'initializated' => 'boolean',
        'is_over' => 'boolean',
    ];
}
