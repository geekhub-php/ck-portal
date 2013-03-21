<?php

namespace Geekhub\DreamBundle;

use JMS\Serializer\Serializer;
use Guzzle\Http\Client;

class LikeManager
{
    public function getDreamShareCount($url)
    {
        $vkShareCount = $this->getVkShareCount($url);
        $okShareCount = $this->getOkShareCount($url);
        $fbShareCount = $this->getFbShareCount($url);
        $twShareCount = $this->getTwShareCount($url);
        $allShareCount = $vkShareCount + $okShareCount + $fbShareCount + $twShareCount;

        return $allShareCount;
    }

    public function getVkShareCount($url)
    {
        $url = 'http://vk.com/share.php?act=count&index=1&url='.$url.'&format=json';

        $client = new Client($url);
        $request = $client->get();
        $response = $request->send();
        $substr = explode(',', $response->getBody(true));

        return (int)trim(str_replace('};', '', $substr[1]));
    }

    public function getOkShareCount($url)
    {
        $url = 'http://www.odnoklassniki.ru/dk?st.cmd=shareData&ref='.$url.'&cb=mailru.share.ok.init';

        $client = new Client($url);
        $request = $client->get();
        $response = $request->send();
        $substr = explode('count":"', $response->getBody(true));

        return (int)str_replace('"})', '', $substr[1]);
    }

    public function getFbShareCount($url)
    {
        $url = 'http://api.ak.facebook.com/restserver.php?v=1.0&method=links.getStats&urls='.$url.'&format=json';

        $client = new Client($url);
        $request = $client->get();
        $response = $request->send();
        $responseArray = $response->json();

        return $responseArray[0]['share_count'];
    }

    public function getTwShareCount($url)
    {
        $url = 'http://urls.api.twitter.com/1/urls/count.json?url='.$url;

        $client = new Client($url);
        $request = $client->get();
        $response = $request->send();
        $responseArray = $response->json();

        return $responseArray['count'];
    }
}