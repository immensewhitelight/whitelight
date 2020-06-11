<?php

namespace App\Orchid\Layouts;

use App\Video;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class VideoListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'videos';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::set('title', 'Title')
                ->render(function (Video $video) {
                    return Link::make($video->title)
                        ->route('platform.video.edit', $video);
                }),

            TD::set('created_at', 'Created'),
            TD::set('updated_at', 'Last edit'),
        ];
    }
}
