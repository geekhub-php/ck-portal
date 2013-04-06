<?php

namespace Geekhub\FileBundle;

use Geekhub\FileBundle\Entity\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{
    /**
     * Process the upload.
     * @param $request Request
     * @param $fileEntity File
     */
    public function handleUpload(Request $request, File $fileEntity)
    {
        /* @var $uploadedFile UploadedFile */
        $uploadedFile = $request->files->get('qqfile');

        if (!file_exists($fileEntity->getUploadDir())) {
            mkdir($fileEntity->getUploadDir());
        }

        if ($this->isValid($fileEntity, $uploadedFile)) {
            $ext = explode('.', $uploadedFile->getClientOriginalName());
            $uniqueName = md5(microtime(1).$uploadedFile->getClientOriginalName()) .'.'. $ext[count($ext)-1];

            $fileEntity->setPath($fileEntity->getUploadDir() . $uniqueName);
            $fileEntity->setOriginalName($uploadedFile->getClientOriginalName());
            $fileEntity->setSize($uploadedFile->getSize());
            $fileEntity->setMimeType($uploadedFile->getClientMimeType());

            $uploadedFile->move($fileEntity->getUploadDir(), $uniqueName);
        }

        return true;
    }

    public function copyRemoteImage($remoteImage, $destination)
    {
        if (!file_exists($destination)) {
            mkdir($destination);
        }

        $ext = explode('.', $remoteImage);
        $uniqueName = md5(microtime(1).$ext[count($ext)-2]) .'.'. $ext[count($ext)-1];
        $dest = fopen($destination.$uniqueName, "wb");
        $src = file_get_contents($remoteImage);
        fwrite($dest, $src, strlen($src));
        fclose($dest);

        return $videoThumbnail = $destination.$uniqueName;
    }

    protected function isValid(File $file, UploadedFile $uploadedFile)
    {
        if (!isset($_SERVER['CONTENT_TYPE'])) {
            $file->setError("No files were uploaded.");
            return false;
        }
        else if (strpos(strtolower($_SERVER['CONTENT_TYPE']), 'multipart/') !== 0) {
            $file->setError("Server error. Not a multipart request. Please set forceMultipart to default value (true).");
            return false;
        }

        if (!is_writable($file->getUploadDir()) || !is_executable($file->getUploadDir())) {
            $file->setError("Server error. Uploads directory isn't writable or executable.");
            return false;
        }

        if (null === $uploadedFile) {
            $file->setError("Don't find uploaded file, or uploaded file is too large.");
            return false;
        }

        // Validate file mimeType
        $pathinfo = pathinfo($uploadedFile->getClientOriginalName());
        $ext = isset($pathinfo['extension']) ? $pathinfo['extension'] : NULL;

        if($file->getAllowedExtensions() && !in_array(strtolower($ext), array_map("strtolower", $file->getAllowedExtensions()))){
            $these = implode(', ', $file->getAllowedExtensions());
            $file->setError("File has an invalid extension, it should be one of ". $these .". Your file extension is ". $ext);
            return false;
        }

        // Check that the max upload size specified in class configuration does not
        // exceed size allowed by server config
        if ($uploadedFile->getMaxFilesize() < $file->getSizeLimit()
        ) {
            $size = max(1, $file->getSizeLimit() / 1024 / 1024) . 'M';
            $file->setError("Server error. Increase upload_max_filesize to " . $size . "Now it is - " . $uploadedFile->getMaxFilesize());
            return false;
        }

        // Validate name
        if ($uploadedFile->getClientOriginalName() === null || $uploadedFile->getClientOriginalName() === '') {
            $file->setError('File name empty.');
            return false;
        }

        if ($uploadedFile->getSize() == 0) {
            $file->setError('File is empty.');
            return false;
        }

        if ($uploadedFile->getSize() > $file->getSizeLimit()) {
            $file->setError('File is too large.');
            return false;
        }

        return true;
    }

    /**
     * Converts a given size with units to bytes.
     * @param string $str
     */
    protected function toBytes($str)
    {
        $val = trim($str);
        $last = strtolower($str[strlen($str) - 1]);
        switch ($last) {
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }
        return $val;
    }
}