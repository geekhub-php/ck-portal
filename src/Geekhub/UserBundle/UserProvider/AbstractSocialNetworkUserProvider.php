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

    protected $kernelWebDir;

    protected $imgPath = '/uploads/';

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

    public function setKernelWebDir($kernelWebDir)
    {
        $this->kernelWebDir = $kernelWebDir;
    }

    public function copyImgFromRemote($remoteImg, $localFileName)
    {
        $content = file_get_contents($remoteImg);
        $destination = $this->kernelWebDir.'/../web'.$this->imgPath;

        if (!is_dir($destination)) {
            mkdir($destination);
        }

        $localImg = $destination.$localFileName;

        $fp = fopen($localImg, "w");
        fwrite($fp, $content);
        fclose($fp);

        return $this->imgPath.$localFileName;
    }
}