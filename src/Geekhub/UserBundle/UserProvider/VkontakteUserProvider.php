<?php

namespace Geekhub\UserBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use Geekhub\UserBundle\Entity\User;

class VkontakteUserProvider extends AbstractSocialNetworkUserProvider
{
    public function setUserFromResponse(UserResponseInterface $response)
    {
        $responseArray = $response->getResponse();

        $uid = $responseArray['response']['user_id'];
        $name = $responseArray['response']['user_name'];
        $gender = $this->getGender($responseArray['response']['user_sex']);
        $token = $response->getAccessToken();

        $user = $this->userManager->createUser();

        $user->setName($name);
        $user->setGender($gender);
        $user->setvkontakteId($uid);
        $user->setVkontakteAccessToken($token);
        $user->setPlainPassword($uid);
        $user->setUsername('vk'.$uid);
        $user->setEmail($uid.'@vk.com');
        $user->setEnabled(true);
        $user->setVkontakteProfile('http://vk.com/id'.$uid);

        $user->setFirstName($this->callUsersGet($uid, $token, 'first_name'));
        $user->setLastName($this->callUsersGet($uid, $token, 'last_name'));
        $user->setProfilePicture($this->callUsersGet($uid, $token, 'photo_big'));

        $this->userManager->updateUser($user);
    }

    private function getGender ($sex)
    {
        if ($sex == 2) {
            return 'male';
        }
        elseif ($sex == 1) {
            return 'female';
        }

        return null;
    }

    /**
     * Wrapper for Vk api - http://vk.com/developers.php?oid=-1&p=users.get
     *
     * @string $uid
     * @string $token
     * @string $field
     * @return string or null
     */
    private function callUsersGet($uid, $token, $field)
    {
        $result = file_get_contents('https://api.vk.com/method/getProfiles?uid='.$uid.'&fields='.$field.'&access_token='.$token);
        $result = json_decode($result, true);

        if (isset($result['response'][0][$field])) {
            return $firstName = $result['response'][0][$field];
        }

        return null;
    }

    private function getProfilePhoto($uid, $token)
    {
        $response = file_get_contents('https://api.vk.com/method/photos.getProfile?uid='.$uid.'&access_token='.$token);
        $responseArray = json_decode($response, true);

        $count = count($responseArray['response']);
        $lastProfilePhotoArray = $responseArray['response'][$count-1];

        if (@$lastProfilePhotoArray['src_xxxbig']) {
            return $lastProfilePhotoArray['src_xxxbig'];
        }
        elseif (@$lastProfilePhotoArray['src_xxbig']) {
            return $lastProfilePhotoArray['src_xxbig'];
        }
        elseif (@$lastProfilePhotoArray['src_xbig']) {
            return $lastProfilePhotoArray['src_xbig'];
        }
        elseif (@$lastProfilePhotoArray['src_big']) {
            return $lastProfilePhotoArray['src_big'];
        }
        elseif (@$lastProfilePhotoArray['src_small']) {
            return $lastProfilePhotoArray['src_small'];
        }
        else {
            return null;
        }

    }
}