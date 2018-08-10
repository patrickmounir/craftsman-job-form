<?php

namespace App\Transformers;

use App\JobRequest;
use League\Fractal\TransformerAbstract;

class JobRequestTransformer extends TransformerAbstract
{
    /**
     * The Default included relations.
     *
     * @var array
     */
    protected $defaultIncludes = ['service'];

    /**
     * Available relations
     *
     * @var array
     */
    protected $availableIncludes = ['user'];
    /**
     * A Fractal transformer.
     *
     * @param JobRequest $jobRequest
     *
     * @return array
     */
    public function transform(JobRequest $jobRequest)
    {
        return [
            'id' => $jobRequest->id,
            'title' => $jobRequest->title,
            'description' => $jobRequest->description,
            'zip' => $jobRequest->zip,
            'city' => $jobRequest->city,
            'deadline' => $jobRequest->deadline,
            'created_at' => (string) $jobRequest->created_at,
            'updated_at' => (string) $jobRequest->updated_at,
        ];
    }

    /**
     * Include service in the fractal transformer.
     *
     * @param JobRequest $jobRequest
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeService(JobRequest $jobRequest)
    {
        return $this->item($jobRequest->service, new ServiceTransformer());
    }

    /**
     * Include user in the fractal transformer.
     *
     * @param JobRequest $jobRequest
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(JobRequest $jobRequest)
    {
        return $this->item($jobRequest->user, new UserTransformer());
    }
}
