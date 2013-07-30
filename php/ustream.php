<?php

class Ustream
{

	private $request;
    private $devkey;
    private $format;

    public function __construct($devkey, $format = 'php')
    {
        $this->request = 'http://api.ustream.tv';
        $this->devkey  = $devkey;
        $this->format  = $format;
    }


    public function GetVideoInfo($videoId)
    {
        return $this->Request('video', $videoId, 'getInfo');
    }

    public function GetChannelInfo($id)
    {
        return $this->Request('channel', $id, 'getInfo');
    }

    public function GetUserVideos($userId)
    {
        return $this->Request('user', $userId, 'listAllVideos');
    }


    public function GetUserStreams($userId)
    {
        return $this->Request('user', $userId, 'listAllChannels');
    }


    public function SearchVideos($searchString, $page = 1, $limit = 5)
    {
        return $this->Request('video', 'all', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchRecentVideos($searchString, $page = 1, $limit = 5)
    {
        return $this->Request('video', 'recent', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchNewestVideos($searchString, $page = 1, $limit = 5)
    {
        return $this->Request('video', 'newest', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchLiveVideos($searchString, $page = 1, $limit = 5)
    {
        return $this->Request('video', 'live', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchPopularVideos($searchString, $page = 1, $limit = 5)
    {
        return $this->Request('video', 'popular', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function GetAllNewStreams($page=1, $limit = 5)
    {
        return $this->Request('stream', 'all', 'getAllNew', false, $page, $limit);
    }

    public function GetRecentStreams($page=1, $limit = 5)
    {
        return $this->Request('stream', 'all', 'getRecent', false, $page, $limit);
    }

    public function SearchStreams($searchString, $page=1, $limit = 5)
    {
        return $this->Request('stream', 'all', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchRecentStreams($searchString, $page=1, $limit = 5)
    {
        return $this->Request('stream', 'recent', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchNewestStreams($searchString, $page=1, $limit = 5)
    {
        return $this->Request('stream', 'newest', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchLiveStreams($searchString, $page=1, $limit = 5)
    {
        return $this->Request('stream', 'live', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchPopularStreams($searchString, $page=1, $limit = 5)
    {
        return $this->Request('stream', 'popular', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchChannel($searchString, $page=1, $limit = 5)
    {
        return $this->Request('channel', 'all', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchRecentChannel($searchString, $page=1, $limit = 5)
    {
        return $this->Request('channel', 'recent', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchNewestChannel($searchString, $page=1, $limit = 5)
    {
        return $this->Request('channel', 'newest', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchLiveChannel($searchString, $page=1, $limit = 5)
    {
        return $this->Request('channel', 'live', 'search', 'title:like:'.$searchString, $page, $limit);
    }

    public function SearchPopularChannel($searchString, $page=1, $limit = 5)
    {
        return $this->Request('channel', 'popular', 'search', 'title:like:'.$searchString, $page, $limit);
    }

	public function MakeSimpeLinkHtmlTag($resultString)
	{
		$count = count($resultString['results']);

		if ($count > 0) {

//			echo '<ul>';

			for ($i = 0; $i < $count; $i++) {
				$url   = $resultString['results'][$i]['url'];
				$title = $resultString['results'][$i]['title'];

				if (strlen($url) > 0 && strlen($title) > 0) {
					echo '<a href="';
					echo $url;
					echo '">';
					echo $title;
					echo '</a><br />';
				}
			}

//			echo '</ul>';
		} else {
			// for Debug
			print_r($resultString);
		}
	}

    private function Request($subject, $uid, $command, $params = false, $page=1, $limit = 5)
    {
        $request =  $this->request;
        $format = $this->format;   // this can be xml, json, html, or php
        $args = 'subject='.$subject;
        $args .= '&uid='.$uid;
        $args .= '&command='.$command;
        if ($params) {
            $args .= '&params='.$params;
        }
        $args .= '&page='.$page;
        $args .= '&limit='.$limit;
        $args .= '&key='.$this->devkey;


        $session = curl_init($request.'/'.$format.'?'.$args);
        curl_setopt($session, CURLOPT_HEADER, false);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($session);
        curl_close($session);

        return unserialize($response);
    }
}

?>
