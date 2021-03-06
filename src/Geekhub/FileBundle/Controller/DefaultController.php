<?php

namespace Geekhub\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Gedmo\Uploadable\UploadableListener;
use Symfony\Component\HttpFoundation\File\File;
use Geekhub\FileBundle\UploadHandlerWrapper;

use Geekhub\FileBundle\Entity\Image;
use Geekhub\FileBundle\Entity\Document;

class DefaultController extends Controller
{
    public function uploadImageAction(Request $request)
    {
        if (!$request->isXmlHttpRequest()) {
            throw new AccessDeniedException();
        }
        //ToDo Add user check
        $image = new Image();

        $image->setAllowedExtensions($this->container->getParameter('geekhub_file.image.allowed_extensions'));
        $image->setSizeLimit($this->container->getParameter('geekhub_file.image.size_limit'));
        $image->setUploadDir($this->container->getParameter('geekhub_file.image.upload_directory'));

//        $fileUploader = $this->get('geekhub.file_bundle.file_uploader');
//        $fileUploader->handleUpload($request, $image);

//        $serializedImage = $this->container->get('serializer')->serialize($image, 'json');

//        return new Response($serializedImage, 200, array('Content-Type' => 'text/plain'));

        $uploadHendler = new UploadHandlerWrapper(array(
            'image_versions' => array(
                'thumbnail' => array(
                    'crop' => true,
                    'max_width' => 280,
                    'max_height' => 200,
                ),
            ),
            'param_name' => 'fileUpload',
            'upload_dir' => $this->get('kernel')->getRootDir() . '/../web/uploads/images/',
            'upload_url' => $this->get('router')->generate('dream_homepage', array(), true) . 'uploads/images/',
        ));

        //jQuery-file-uploader return json to client, so we must return empty response
        return new Response();
    }

    public function uploadDocumentAction(Request $request)
    {
        //ToDo Add user check
        $document = new Document();

        $document->setAllowedExtensions($this->container->getParameter('geekhub_file.document.allowed_extensions'));
        $document->setSizeLimit($this->container->getParameter('geekhub_file.document.size_limit'));
        $document->setUploadDir($this->container->getParameter('geekhub_file.document.upload_directory'));

        $fileUploader = $this->get('geekhub.file_bundle.file_uploader');
        $fileUploader->handleUpload($request, $document);

        $serializedDocument = $this->container->get('serializer')->serialize($document, 'json');

        return new Response($serializedDocument, 200, array('Content-Type' => 'text/plain'));
    }

    public function getVimeoThumbnailAction($videoId)
    {
        $url = "http://vimeo.com/api/v2/video/$videoId.php";
        $result = unserialize(file_get_contents($url));

        $remoteThumbnail =  $result[0]['thumbnail_large'];

        $fileUploader = $this->get('geekhub.file_bundle.file_uploader');
        $destination = $this->container->getParameter('geekhub_file.video.upload_directory');

        $thumbnail = $fileUploader->copyRemoteImage($remoteThumbnail, $destination);

        $response['remoteThumbnail'] =  $remoteThumbnail;
        $response['thumbnail'] = $thumbnail;
        $response = $this->container->get('serializer')->serialize($response, 'json');

        return new Response($response);
    }

    public function getYoutubeThumbnailAction($videoId)
    {
        $remoteThumbnail = "http://img.youtube.com/vi/".$videoId."/0.jpg";

        $fileUploader = $this->get('geekhub.file_bundle.file_uploader');
        $destination = $this->container->getParameter('geekhub_file.video.upload_directory');

        $thumbnail = $fileUploader->copyRemoteImage($remoteThumbnail, $destination);

        $response['remoteThumbnail'] =  $remoteThumbnail;
        $response['thumbnail'] = $thumbnail;
        $response = $this->container->get('serializer')->serialize($response, 'json');

        return new Response($response);
    }
}