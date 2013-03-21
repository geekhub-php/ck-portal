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
        $url = 'https://api.vk.com/method/likes.getList?type=sitepage&filter=copies&owner_id=3423353&page_url='.$url;

        $client = new Client($url);
        $request = $client->get();
        $response = $request->send();
        $responseArray = $response->json();

        if (isset($responseArray['error'])) {
            return '0';
        }

        return $responseArray['response']['count'];
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