<?php

namespace Geekhub\UserBundle\UserProvider;

use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use FOS\UserBundle\Model\UserManagerInterface;

abstract class AbstractSocialNetworkUserProvider
{
    protected $response;

    protected $userManager;

    protected $propertyServiceUserId;

    protected $propertyServiceAccessToken;

    public function __construct (UserManagerInterface $userManager )
    {
        $this->userManager = $userManager;
//        $this->response = $response;
//
//        $service = $response->getResourceOwner()->getName();
//
//        $setter = 'set'.ucfirst($service);
//        $this->propertyServiceUserId = $setter.'Id';
//        $this->propertyServiceAccessToken = $setter.'AccessToken';
    }

    abstract public function setUserFromResponse(UserResponseInterface $response);


    protected function getObjDateFromString($format ,$stringDate, $separator)
    {
        $dateArray = explode($separator, $stringDate);

        if (count($dateArray) > 3) {
            throw new \Exception('String date invalid');
        }

        $date = date($format, $stringDate);

        return new \DateTime($date);
    }
}