<?php

namespace App\Nova\Metrics;

use App\Models\Post;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Metrics\Trend;
use Laravel\Nova\Metrics\TrendResult;

class PostsPerDay extends Trend
{

    public function name()
    {
        return 'Posts Per Month';
    }

    /**
     * Calculate the value of the metric.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return mixed
     */
    public function calculate(NovaRequest $request)
    {
        return (new TrendResult)->trend([
            'Day 1' => 1,
            'Day 2' => 200,
            'Day 3' => 50,
        ]);
    }

    /**
     * Get the ranges available for the metric.
     *
     * @return array
     */
    public function ranges()
    {
        return [
            6 => __('6 Months'),
            12 => __('12 Months'),
        ];
    }

    /**
     * Determine the amount of time the results of the metric should be cached.
     *
     * @return \DateTimeInterface|\DateInterval|float|int|null
     */
    public function cacheFor()
    {
        // return now()->addMinutes(5);
    }

    /**
     * Get the URI key for the metric.
     *
     * @return string
     */
    public function uriKey()
    {
        return 'posts-per-day';
    }
}
