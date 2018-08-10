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
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(JobRequest $jobRequest)
    {
        return [
            'title' => $jobRequest->title,
            'description' => $jobRequest->description,
            'zip' => $jobRequest->zip,
            'city' => $jobRequest->city,
            'deadline' => $jobRequest->deadline,
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
}
