<?php
namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class QueryFilter
{

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Builder
     */
    protected $builder;

    /**
     * QueryFilter constructor.
     *
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @param Builder $builder
     *
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->filters() as $key => $value) {
            if (method_exists($this, $key)) {
                call_user_func([$this, $key], $value);
            }
        }

        return $this->builder;
    }

    /**
     *
     *
     * @return array
     */
    private function filters()
    {
        return $this->request->except(get_class_methods(self::class));
    }
}