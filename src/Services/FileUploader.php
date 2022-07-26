<?php

namespace App\Services;

use Psr\Container\ContainerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileUploader
{

    /**
     * @var ContainerInterface
     */
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function uploadFile(UploadedFile $file): string
    {
        //rename file name
        $filename = md5(uniqid('', true)) . '.' . $file->guessClientExtension();

        $file->move(
        //folder path
            $this->container->getParameter('upload_dir'),
            $filename,
        );

        return $filename;
    }
}
