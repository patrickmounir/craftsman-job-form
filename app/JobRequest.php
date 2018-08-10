<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JobRequest extends Model
{
    /**
     * Fields allowed for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'service_id', 'title', 'deadline', 'description', 'city', 'zip'];

    /**
     * Relation between JobRequest and Service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
