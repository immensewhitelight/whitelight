<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\AssortedListLayout;
use App\Assorted;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Screen;
use Illuminate\Support\Facades\Log;


class AssortedListScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'Assorted';

    /**
     * Display header description.
     *
     * @var string
     */
    public $description = 'All assorted';

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): array
    {
        return [
            'assorteds' => Assorted::paginate()
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
                ->route('platform.assorted.edit'),
                
            Button::make('Retrieve assorted urls ')
                ->icon('icon-star')
                ->method('retrieveAssortedUrls'),
                     
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
            AssortedListLayout::class
        ];
    }
    
    /**
    * using a bitchute channel page, extract each assorted title and assorted page url
	* using the assorted page url, extract the name of the seed of the mp4
    * using the name of the seed, build the url to the mp4
    * store each url in array and save to urls field in db.
    */
    public function retrieveAssortedUrls()
    {
		$assorteds =  \App\Assorted::latest()->get();
				
				
				
		foreach($assorteds as $assorted) {
				
			$channelPage = file_get_contents($assorted['bitchute_channel']);
			
			$doc = new \DOMDocument;
			$doc->preserveWhiteSpace = false;
			@$doc->loadHTML($channelPage);
			$xpath = new \DOMXpath($doc);
			$assortedPages = $xpath->query("//p[@class='video-card-title']");
			
			$links = array();
			
			$limit = 0;
			// add each url to the array
			foreach($assortedPages as $contextNode) {
				
				if (++$limit > 40) break;

				// title
				$text = $xpath->evaluate("string(./a[1])",$contextNode);
				
				// assorted page 
				$href = $xpath->evaluate("string(./a[1]/@href)",$contextNode);
				
				// assorted page as string
				$assortedPageUrl = "https://www.bitchute.com" . $href;
				$assortedPage = file_get_contents($assortedPageUrl);
				
				// find the mp4 link in the string
				// push to array
				$out = array();
				preg_match('/https:\/\/seed.*?mp4/', $assortedPage, $out);
				
				$mp4 = $out[0];
				
				Log::info($mp4);
				
				$array = array();
						
				$link = "<a href=$mp4 target=popup onclick=window.open('$mp4','popup','width=222,height=222'); return false; >$text</a>"; 

				$links[] = $link;
			
			}
			// save to db
			$assorted->urls = $links;
			
			$assorted->save();  
			
     }
   } 
}
