<?php

namespace Geekhub\UserBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;

class FacebookUserProvider extends AbstractSocialNetworkUserProvider
{

    public function setUserFromResponse(UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $uid = $responseArray['id'];
        $firstName = $responseArray['first_name'];
        $lastName = $responseArray['last_name'];
        $name = $firstName.' '.$lastName;
        $gender = $responseArray['gender'];
        $email = $responseArray['email'];
        $profile = $responseArray['link'];
        $username = $responseArray['username'];
        $token = $response->getAccessToken();
        $tokenArray = str_split($token, rand(10, 20));

        $user = $this->userManager->createUser();

        $remoteImg = 'http://graph.facebook.com/'.$username.'/picture?width=200&height=200';
        $profilePicture = $this->copyImgFromRemote($remoteImg, md5('fb'.$uid).'.jpg');

        $user->setName($name);
        $user->setGender($gender);
        $user->setFacebookId($uid);
        $user->setFacebookAccessToken($token);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setFacebookProfile($profile);
        $user->setEmail($email);
        $user->setUsername($tokenArray[0]);
        $user->setPlainPassword($tokenArray[1]);
        isset($responseArray['website']) ? $user->setWebsite($responseArray['website']) : $user->setWebsite('');
        $user->setProfilePicture($profilePicture);
        $user->setEnabled(true);

        $this->userManager->updateUser($user);
    }

    private function getAlbums($uid, $token)
    {
        $result = file_get_contents('https://graph.facebook.com/'.$uid.'/albums?access_token='.$token);
        $result = json_decode($result, true);

        return $result['data'];
    }

    private function getProfileAlbum($uid, $token)
    {
        $albums = $this->getAlbums($uid, $token);

        if (!$albums) {
            return null;
        }

        $profileAlbum = null;
        foreach ($albums['data'] as $album) {
            if ($album['name'] == 'Profile Pictures') {
                $profileAlbum = $album;
                break;
            }
        }

        return $profileAlbum;
    }
}