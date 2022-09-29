<?php

namespace App\Nova;

use App\Nova\Actions\PublishPost;
use App\Nova\Filters\PostCategories;
use App\Nova\Filters\PostPublished;
use App\Nova\Lenses\MostTags;
use App\Nova\Metrics\PostCount;
use App\Nova\Metrics\PostsPerCategory;
use App\Nova\Metrics\PostsPerDay;
use Beyondcode\NovaClock\NovaClock;
use Beyondcode\StringLimit\StringLimit;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Http\Requests\NovaRequest;

class Post extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Post::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'title', 'body'
    ];

    public static function indexQuery(NovaRequest $request, $query)
    {
        return $query->where('user_id', $request->user()->id);
    }

    public function title()
    {
        return $this->title . ' - ' . $this->category;
    }

    public function subtitle()
    {
        return 'Author: ' . $this->user->name;
    }

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),

            StringLimit::make('Title')->rules([
                'required'
            ])->max(10),

            Trix::make('Body')->rules([
                'required'
            ]),

            DateTime::make('Publish Post At', 'publish_at')->hideFromIndex()->rules([
                'after_or_equal:today'
            ]),

            DateTime::make('Publish Until')->hideFromIndex()->rules([
                'after_or_equal:publish_at'
            ]),

            Boolean::make('Is Published')->canSee(function ($request) {
                return true;
            }),

            Select::make('Category')->options([
                'tutorials' => 'Tutorials',
                'news' => 'News',
            ])->hideWhenUpdating()->rules([
                'required'
            ]),

            BelongsTo::make('User')->rules([
                'required'
            ]),

            BelongsToMany::make('Tags'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [
            (new NovaClock)->blink(),
            (new PostCount)->width('1/2'),
            (new PostsPerCategory)->width('1/2'),
            (new PostsPerDay)->width('full'),
        ];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [
            new PostPublished,
            new PostCategories,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [
            new MostTags
        ];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [
            (new PublishPost)->canSee(function ($request) {
                return true;
            })->canRun(function ($request, $post) {
                return $post->id === 3;
            })
        ];
    }
}
