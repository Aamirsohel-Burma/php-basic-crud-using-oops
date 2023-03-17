<?php
class FileUploader{
    private $targetDir;
    private $allowedTypes;
    private $maxSize;

    public function __construct($targetDir, $allowedTypes = array(), $maxSize = 500000)
    {
        $this->targetDir = $targetDir;
        $this->allowedTypes = $allowedTypes;
        $this->maxSize = $maxSize;
        
        /** If directory is not exist than it will create directory automatically */
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
    }

    public function upload($file)
    {
        $fileName = uniqid('', true) . '.' . pathinfo($file['name'], PATHINFO_EXTENSION);
        $targetFile = $this->targetDir . $fileName;
        $fileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if file already exists
        if (file_exists($targetFile)) {
            throw new Exception('Sorry, file already exists.');
        }

        // Check file size
        if ($file['size'] > $this->maxSize) {
            throw new Exception('Sorry, your file is too large.');
        }

        // Allow certain file formats
        if (!in_array($fileType, $this->allowedTypes)) {
            throw new Exception('Sorry, only ' . implode(',', $this->allowedTypes) . ' files are allowed.');
        }

        // Move the file to the target directory
        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return $fileName;
        } else {
            throw new Exception('Sorry, there was an error uploading your file.');
        }
    }
}
