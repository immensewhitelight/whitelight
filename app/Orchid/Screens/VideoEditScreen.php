<?php

namespace App\Orchid\Screens;

use App\Video;
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


class VideoEditScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Creating a new video';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = '"Video" is info post with link to a video set.';

    /**
     * @var bool
     */
    public $exists = false;

    /**
     * Query data.
     *
     * @param Video $video
     *
     * @return array
     */
    public function query(Video $video): array
    {
        $this->exists = $video->exists;

        if($this->exists){
            $this->name = 'Edit video';
        }

        return [
            'video' => $video
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
            Button::make('Create video')
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
                Input::make('video.title')
                    ->title('Title')
                    ->placeholder('Attractive but mysterious title')
                    ->help('Specify a short descriptive title for this video.'),

                TextArea::make('video.description')
                    ->title('Description')
                    ->rows(3)
                    ->maxlength(200)
                    ->placeholder('Brief description for preview'),

                Relation::make('video.author')
                    ->title('Author')
                    ->fromModel(User::class, 'name'),
				
                Quill::make('video.body')
                    ->maxlength(1000)
                    ->placeholder('')
                    ->title('Main text'),
                    
                Input::make('video.bitchute_channel')
                    ->title('Bitchute channel')
                    ->placeholder('Bitchute channel')
                    ->help('ie: bitchute.com/channel/ciHGtYgFrtgg/'),
                     
            ])
        ];
    }

    /**
     * @param Video    $video
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(Video $video, Request $request)
    {
        $video->fill($request->get('video'))->save();

        Alert::info('You have successfully created an video.');

        return redirect()->route('platform.video.list');
    }

    /**
     * @param Video $video
     *
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function remove(Video $video)
    {
        $video->delete()
            ? Alert::info('You have successfully deleted the video.')
            : Alert::warning('An error has occurred')
        ;

        return redirect()->route('platform.video.list');
    }
    
   
    
    
}
