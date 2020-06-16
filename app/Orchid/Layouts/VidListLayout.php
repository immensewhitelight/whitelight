<?php

namespace App\Orchid\Layouts;

use App\Vid;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class VidListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'vids';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::set('title', 'Title')
                ->render(function (Vid $vid) {
                    return Link::make($vid->title)
                        ->route('platform.vid.edit', $vid);
                }),

            TD::set('created_at', 'Created'),
            TD::set('updated_at', 'Last edit'),
        ];
    }
}
