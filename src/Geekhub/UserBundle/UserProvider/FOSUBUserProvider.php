<?php

namespace Geekhub\UserBundle\UserProvider;

use Symfony\Component\Security\Core\User\UserInterface;
use HWI\Bundle\OAuthBundle\OAuth\Response\UserResponseInterface;
use HWI\Bundle\OAuthBundle\Security\Core\User\FOSUBUserProvider as BaseClass;

class FOSUBUserProvider extends BaseClass
{

    private $vkontakteProvider;

    private $facebookProvider;

    private $odnoklassnikiProvider;

    private $session;

    /**
     * {@inheritDoc}
     */
    public function connect(UserInterface $user, UserResponseInterface $response)
    {
        $property = $this->getProperty($response);
        $username = $response->getUsername();

        //on connect - get the access token and the user ID
        $service = $response->getResourceOwner()->getName();

        $setter = 'set'.ucfirst($service);
        $setter_id = $setter.'Id';
        $setter_token = $setter.'AccessToken';

        //we "disconnect" previously connected users
        if (null !== $previousUser = $this->userManager->findUserBy(array($property => $username))) {
            $previousUser->$setter_id(null);
            $previousUser->$setter_token(null);
            $this->userManager->updateUser($previousUser);
        }

        //we connect current user
        $user->$setter_id($username);
        $user->$setter_token($response->getAccessToken());

        $this->userManager->updateUser($user);
    }

    /**
     * {@inheritdoc}
     */
    public function loadUserByOAuthUserResponse(UserResponseInterface $response)
    {
        $service = $response->getResourceOwner()->getName();
        $property = $service.'Provider';
        $userProvider = $this->$property;

        $username = $response->getUsername();

        $user = $this->userManager->findUserBy(array($this->getProperty($response) => $username));
        if (null === $user) {
            $user = $userProvider->setUserFromResponse($response);
        }

        //if user exists - go with the HWIOAuth way
        $user = parent::loadUserByOAuthUserResponse($response);

        $serviceName = $response->getResourceOwner()->getName();
        $setter = 'set' . ucfirst($serviceName) . 'AccessToken';

        //update access token
        $user->$setter($response->getAccessToken());

        //if user is banned
        if (!$user->isAccountNonLocked() && $user->getBanReason()) {
            $this->session->getFlashBag()->add('notice', 'Ваш акаунт заблоковано.');
            $this->session->getFlashBag()->add('notice', 'Коментар адміністратора: ' . $user->getBanReason());
        }

        return $user;
    }

    public function setVkontakteProvider(VkontakteUserProvider $vkontakteProvider)
    {
        $this->vkontakteProvider = $vkontakteProvider;
    }

    public function setFacebookProvider(FacebookUserProvider $facebookProvider)
    {
        $this->facebookProvider = $facebookProvider;
    }

    public function setOdnoklassnikiProvider(OdnoklassnikiUserProvider $odnoklassnikiProvider)
    {
        $this->odnoklassnikiProvider = $odnoklassnikiProvider;
    }

    public function setSession($session)
    {
        $this->session = $session;
    }


}