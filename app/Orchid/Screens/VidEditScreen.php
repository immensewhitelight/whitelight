<?php

namespace App\Orchid\Screens;

use App\Vid;
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


class VidEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new vid';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '"Vid" is info post with link to a vid.';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @param Vid $vid
     *
     * @return array
     */
    public function query(Vid $vid): array
    {
        $this->exists = $vid->exists;

        if($this->exists){
            $this->name = 'Edit vid';
        }

        return [
            'vid' => $vid
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
            Button::make('Create vid')
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
                Input::make('vid.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this vid.'),

                TextArea::make('vid.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Relation::make('vid.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),
				
                Quill::make('vid.body')
                    ->maxlength(1000)
                    ->placeholder('')
                    ->title('Main text'),
                    
                Input::make('vid.url')
                    ->title('Bitchute video')
                    ->placeholder('Bitchute video')
                    ->help('ie: bitchute.com/video/ciHGtYgFrtgg/'),
                     
            ])
        ];
    }

    /**
     * @param Vid    $vid
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Vid $vid, Request $request)
    {
        $vid->fill($request->get('vid'))->save();

        Alert::info('You have successfully created an vid.');

        return redirect()->route('platform.vid.list');
    }

    /**
     * @param Vid $vid
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Vid $vid)
    {
        $vid->delete()
            ? Alert::info('You have successfully deleted the vid.')
            : Alert::warning('An error has occurred')
        ;

        return redirect()->route('platform.vid.list');
    }
   
}
