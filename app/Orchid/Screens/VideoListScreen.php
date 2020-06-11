<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\VideoListLayout;
use App\Video;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;

class VideoListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Video';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All video';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'videos' => Video::paginate()
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
                ->route('platform.video.edit'),
                
            Button::make('Retrieve video urls ')
                ->icon('icon-star')
                ->method('retrieveVideoUrls'),
                     
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
            VideoListLayout::class
        ];
    }
    
    /**
    * using a bitchute channel page, extract each video title and video page url
	* using the video page url, extract the name of the seed of the mp4
    * using the name of the seed, build the url to the mp4
    * store each url in array and save to urls field in db.
    */
    public function retrieveVideoUrls(Video $video)
    {
		$videos =  \App\Video::latest()->get();
				
		foreach($videos as $video) {
				
			$channelPage = file_get_contents($video['bitchute_channel']);
			
			$doc = new \DOMDocument;
			$doc->preserveWhiteSpace = false;
			@$doc->loadHTML($channelPage);
			$xpath = new \DOMXpath($doc);
			$videoPages = $xpath->query("//div[@class='channel-videos-title']");
			
			$links = array();
				
			// add each url to the array
			foreach($videoPages as $contextNode) {
				
				// title
				$text = $xpath->evaluate("string(./a[1])",$contextNode);
				
				// video page 
				$href = $xpath->evaluate("string(./a[1]/@href)",$contextNode);
				
				// video page as string
				$videoPageUrl = "https://www.bitchute.com" . $href;
				$videoPage = file_get_contents($videoPageUrl);
				
				// find the mp4 link in the string
				// push to array
				$out = array();
				preg_match('/https:\/\/seed.*mp4/', $videoPage, $out);
				
				$mp4 = $out[0];
				
				$link = '<a href=' . '"' .  $mp4 . '"' . 'target='. '"' . '_blank' .'"' .  '>' . $text . '</a>'; 
				$links[] = $link;
			}
			// save to db
			$video->urls = $links;
			$video->save();  
			
     }
   } 
}
