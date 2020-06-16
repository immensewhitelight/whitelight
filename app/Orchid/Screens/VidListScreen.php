<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\VidListLayout;
use App\Vid;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class VidListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Vid';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All vid';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'vids' => Vid::paginate()
        ];
    }

    /**
     * Button commands.
     *
     * @return Link[]
     */
    public function commandBar(): array
    {
        return [
            Link::make('Create new')
                ->icon('icon-pencil')
                ->route('platform.vid.edit'),         
        ];
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    {
        return [
            VidListLayout::class
        ];
    }
    
}
