<?php

namespace App\Tests\Service;

use App\Service\UploadFile;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class UploadFileTest extends TestCase
{
    public function testUpload() {
        $uploadFile = new UploadFile('public/uploads/images/');
        $path = 'public/uploads/images/backflip-2.jpeg';
        $image = new UploadedFile(
            $path,
            'backflip-2.jpeg',
            'image/jpeg',
            null
        );

        $result = $uploadFile->upload($image);

        $this->assertEquals('backflip-2.jpeg', $result);
    }
}
