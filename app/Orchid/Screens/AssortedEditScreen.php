<?php

namespace App\Orchid\Screens;

use App\Assorted;
use App\User;
use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Quill;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Fields\Upload;
use Orchid\Screen\Layout;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

use Orchid\Support\Facades\Alert;


class AssortedEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new assorted';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '"Assorted" is info post with link to a assorted set.';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @param Assorted $assorted
     *
     * @return array
     */
    public function query(Assorted $assorted): array
    {
        $this->exists = $assorted->exists;

        if($this->exists){
            $this->name = 'Edit assorted';
        }

        return [
            'assorted' => $assorted
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
            Button::make('Create assorted')
                ->icon('icon-pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->exists),

            Button::make('Update')
                ->icon('icon-note')
                ->method('createOrUpdate')
                ->canSee($this->exists),

            Button::make('Remove')
                ->icon('icon-trash')
                ->method('remove')
                ->canSee($this->exists), 
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
            Layout::rows([
                Input::make('assorted.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this assorted.'),

                TextArea::make('assorted.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Relation::make('assorted.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),
				
                Quill::make('assorted.body')
                    ->maxlength(1000)
                    ->placeholder('')
                    ->title('Main text'),
                    
                Input::make('assorted.bitchute_channel')
                    ->title('Bitchute channel')
                    ->placeholder('Bitchute channel')
                    ->help('ie: bitchute.com/channel/ciHGtYgFrtgg/'),
                     
            ])
        ];
    }

    /**
     * @param Assorted    $assorted
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Assorted $assorted, Request $request)
    {
        $assorted->fill($request->get('assorted'))->save();

        Alert::info('You have successfully created an assorted.');

        return redirect()->route('platform.assorted.list');
    }

    /**
     * @param Assorted $assorted
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Assorted $assorted)
    {
        $assorted->delete()
            ? Alert::info('You have successfully deleted the assorted.')
            : Alert::warning('An error has occurred')
        ;

        return redirect()->route('platform.assorted.list');
    }
}
