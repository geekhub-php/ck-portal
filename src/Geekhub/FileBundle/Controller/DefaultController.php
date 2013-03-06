<?php

namespace Geekhub\FileBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function uploadFileAction()
    {
        $fileUploader = $this->get('geekhub.file_bundle.file_uploader');

        $fileUploader->allowedExtensions = array();
        $fileUploader->sizeLimit = 10 * 1024 * 1024;
        $fileUploader->inputName = 'qqfile';
        $fileUploader->chunksFolder = 'chunks';
        $result = $fileUploader->handleUpload('uploads');
        $result['uploadName'] = $fileUploader->getUploadName();
        $result['mimeType'] = $fileUploader->getMimeType('uploads');
        $result['fileSize'] = $fileUploader->getFileSize('uploads');
        $result =  json_encode($result);

        return new Response($result, 200, array('Content-Type' => 'text/plain'));
    }
}