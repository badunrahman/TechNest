<?php

namespace App\Controllers;

use App\Helpers\FileUploadHelper;
use App\Helpers\FlashMessage;
use App\Helpers\SessionManager;
use DI\Container;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UploadController extends BaseController
{
    //TODO: Add a constructor that calls the parent constructor.
    public function __construct(Container  $container)
    {
        parent::__construct($container);
    }
    /**
     * Display the upload form.
     */
    public function index(Request $request, Response $response, array $args): Response
    {
        // TODO: Create a $data array with 'title' => 'File Upload Demo'
        $data = [
            'title' => 'File Upload Demo',

        ];
        // TODO: Render the 'upload/uploadView.php' view and pass the data array to that view.
        return $this->render($response, 'upload/uploadView.php', $data);
    }

    /**
     * Process file upload.
     */
    public function upload(Request $request, Response $response, array $args): Response
    {
        // TODO: Get the uploaded files from the request using getUploadedFiles()
        $uploadedFiles = $request->getUploadedFiles();
        // TODO: Extract the 'myfile' uploaded file from the array
        $uploadedFile = $uploadedFiles['myfile'] ?? null;
        // TODO: Create a $config array with the following settings:

        //       - 'directory' => Use APP_BASE_DIR_PATH constant + '/public/uploads/images'
        //       - 'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif']
        //       - 'maxSize' => 2 * 1024 * 1024 (2MB in bytes)
        //       - 'filenamePrefix' => 'upload_'

        $config = [
            'directory' =>  APP_BASE_DIR_PATH . '/public/uploads/images',
            'allowedTypes' => ['image/jpeg', 'image/png', 'image/gif'],
            'maxSize' => 2 * 1024 * 1024,
            'filenamePrefix' => 'upload_'
        ];

        // TODO: Call FileUploadHelper::upload() with the uploaded file and config
        $result =  FileUploadHelper::upload($uploadedFile, $config);
        // TODO: Check if the result is successful using isSuccess()
        // If successful:
        //   - TODO: Get the filename from the result data using getData()['filename']
        //   - TODO: Use SessionManager to check if 'uploaded_files' exists, if not initialize it as an empty array
        //   - TODO: Get the current 'uploaded_files' array from SessionManager, add the new filename, and save it back
        //   - TODO: Display a success message using FlashMessage::success() with the result message and filename
        // If not successful:
        //   - TODO: Display an error message using FlashMessage::error() with the result message

        if ($result->isSuccess()) {
            $data = $result->getData();
            $filename = $data['filename'] ?? null;

            if ($filename !== null) {
                if (!SessionManager::has('uploaded_files')) {
                    SessionManager::set('uploaded_files', []);
                }
            }

            $uploadedFileList = SessionManager::get('uploaded_files', []);
            $uploadedFileList[] = $filename;
            SessionManager::set('uploaded_files', $uploadedFileList);
        }
        FlashMessage::success($result->getMessage() . $filename ?? 'error');
        // TODO: Redirect back to 'upload.index' using the redirect() method
        return $this->redirect($request, $response, 'upload.index');
    }
}
