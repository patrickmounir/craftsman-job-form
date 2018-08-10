<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Filterable;

class JobRequest extends Model
{
    use Filterable;

    /**
     * Fields allowed for mass assignment.
     *
     * @var array
     */
    protected $fillable = ['service_id', 'title', 'deadline', 'description', 'city', 'zip'];

    /**
     * Relation between JobRequests and Service.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Relation between JobRequests and User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
