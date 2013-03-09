<?php

namespace Geekhub\UserBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class OdnoklassnikiUserProvider extends AbstractSocialNetworkUserProvider
{

    private $appKeys;



    public function setUserFromResponse(UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $uid = $responseArray['uid'];
        $firstName = $responseArray['first_name'];
        $lastName = $responseArray['last_name'];
        $name = $responseArray['name'];
        $gender = $responseArray['gender'];
        $username = $responseArray['name'];
        $token = $response->getAccessToken();
        $tokenArray = str_split($token, rand(5, 10));

        $user = $this->userManager->createUser();

        $result = $this->doApiRequest('photos.getUserPhotos', $token);
        $resultObj = json_decode($result);

        $profilePicture = null;
        if ($resultObj->photos[0]->standard_url) {
            $profilePicture = $this->copyImgFromRemote($resultObj->photos[0]->standard_url, md5('ok'.$uid).'.jpg');
        }

        $user->setName($name);
        $user->setGender($gender);
        $user->setOdnoklassnikiId($uid);
        $user->setOdnoklassnikiAccessToken($token);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setOdnoklassnikiProfile('http://www.odnoklassniki.ru/profile/'.$uid);
        $user->setEmail($uid.'@odnoklassniki.ru');
        $user->setUsername($tokenArray[0]);
        $user->setPlainPassword($tokenArray[1]);
        $user->setProfilePicture($profilePicture);
        $user->setEnabled(true);

        $this->userManager->updateUser($user);
    }

    /**
     * @param string $method Method from Odnoklassniki REST API http://dev.odnoklassniki.ru/wiki/display/ok/Odnoklassniki+REST+API+ru
     * @param string $token Security token
     * @param array  $parameters Array parameters for current method
     */
    private function doApiRequest($method, $token, $parameters = array())
    {
        $odnoklassniki_app_secret = $this->appKeys['odnoklassniki_app_secret'];
        $odnoklassniki_app_key = $this->appKeys['odnoklassniki_app_key'];

        $url = 'http://api.odnoklassniki.ru/fb.do?method='.$method;
        $sig = md5(
            'application_key=' . $odnoklassniki_app_key .
            'method=' . $method .
            md5($token . $odnoklassniki_app_secret)
        );

        $arrayParameters = array(
            'access_token' => $token,
            'application_key' => $odnoklassniki_app_key,
            'sig' => $sig,
        );

        $arrayParameters = array_merge($parameters, $arrayParameters);

        $url .= '&' . http_build_query($arrayParameters);
        return file_get_contents($url);
    }

    private function getProfileAlbum($uid, $token)
    {
    }

    public function setAppKeys($appKeys)
    {
        $this->appKeys = $appKeys;
    }
}