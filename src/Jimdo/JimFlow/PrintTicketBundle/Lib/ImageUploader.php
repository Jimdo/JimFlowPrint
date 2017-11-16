<?php

namespace Jimdo\JimFlow\PrintTicketBundle\Lib;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;

class ImageUploader
{
    /**
     * @var string
     */
    private $publicDir;

    /**
     * @var string
     */
    private $webDir;

    public function __construct($publicDir, $webDir)
    {
        $this->publicDir = $publicDir;
        $this->webDir = $webDir;
    }

    /**
     * @param UploadedFile $file
     * @param string $fileName
     * 
     * @return string
     */
    public function upload(UploadedFile $file, $fileName = null)
    {
        if (!$fileName) {
            $fileName = md5(uniqid());
        }

        $fileName .= '.' . $file->guessExtension();

        $file->move($this->getSystemDir(), $fileName);

        return $fileName;
    }

    /**
     * @param File $file
     * 
     * @return bool
     */
    public function delete(File $file)
    {
        return unlink($file->getRealPath());
    }

    /**
     * @param string $fileName
     * 
     * @return File
     */
    public function getFileObject($fileName)
    {
        return new File($this->getSystemDir() . '/' . $fileName);
    }

    /**
     * @param string $fileName
     * 
     * @return string
     */
    public function getImageSrc($fileName)
    {
        return $this->publicDir . '/' . $fileName;
    }

    /**
     * @return string
     */
    public function getSystemDir()
    {
        return $this->webDir . '/' . $this->publicDir;
    }
}