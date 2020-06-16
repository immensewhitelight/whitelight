<?php

namespace App\Orchid\Layouts;

use App\Assorted;
use Orchid\Screen\TD;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;

class AssortedListLayout extends Table
{
    /**
     * Data source.
     *
     * @var string
     */
    public $target = 'assorteds';

    /**
     * @return TD[]
     */
    public function columns(): array
    {
        return [
            TD::set('title', 'Title')
                ->render(function (Assorted $assorted) {
                    return Link::make($assorted->title)
                        ->route('platform.assorted.edit', $assorted);
                }),

            TD::set('created_at', 'Created'),
            TD::set('updated_at', 'Last edit'),
        ];
    }
}
