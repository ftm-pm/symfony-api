<?php

namespace App\Controller;

use \GuzzleHttp\Client as HttpClient;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MediaController
 * @package App\Controller
 */
class MediaController extends Controller
{
    /**
     * @Route("/api/media/images", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postDataImagesAction(Request $request)
    {
        $imageFile = $request->files->get('imageFile', null);
        $previews = $request->request->get('previews', null);
        $project = $request->request->get('project', getenv('APP_NAME'));
        $body = [];
        if($imageFile) {
            $body[] = [
                'name'  => 'imageFile',
                'contents' => file_get_contents($imageFile->getRealPath()),
                'filename' => $imageFile->getClientOriginalName()
            ];
        }
        if($previews) {
            $body[] = [
                'name' => 'previews',
                'contents' => $previews
            ];
        }
        if($project) {
            $body[] = [
                'name' => 'project',
                'contents' => $project
            ];
        }
        $method = 'POST';
        $uri = getenv('APP_MEDIA_HOST') . '/api/images';
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('APP_MEDIA_TOKEN'),
            ],
            'multipart' => $body
        ];
        $client = new HttpClient();
        $response = $client->request($method, $uri, $options);

        return new JsonResponse(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }

    /**
     * @Route("/api/media/images/{id}", methods={"DELETE"})
     *
     * @param $id
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteImagesAction($id)
    {
        $method = 'DELETE';
        $uri = getenv('APP_MEDIA_HOST') . '/api/images/' . $id;
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('APP_MEDIA_TOKEN'),
                'Content-type' => 'application/json',
            ],
        ];
        $client = new HttpClient();
        $response = $client->request($method, $uri, $options);

        return new JsonResponse(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }

    /**
     * @Route("/api/media/documents", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function postDataDocumentsAction(Request $request)
    {
        $documentFile = $request->files->get('documentFile', null);
        $project = $request->request->get('project', getenv('APP_NAME'));
        $body = [];
        if($documentFile) {
            $body[] = [
                'name'  => 'documentFile',
                'contents' => file_get_contents($documentFile->getRealPath()),
                'filename' => $documentFile->getClientOriginalName()
            ];
        }
        if($project) {
            $body[] = [
                'name' => 'project',
                'contents' => $project
            ];
        }
        $method = 'POST';
        $uri = getenv('APP_MEDIA_HOST') . '/api/documents';
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('APP_MEDIA_TOKEN'),
            ],
            'multipart' => $body
        ];
        $client = new HttpClient();
        $response = $client->request($method, $uri, $options);

        return new JsonResponse(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }

    /**
     * @Route("/api/media/documents{id}", methods={"DELETE"})
     *
     * @param $id
     * @return JsonResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteDocumentAction($id)
    {
        $method = 'DELETE';
        $uri = getenv('APP_MEDIA_HOST') . '/api/documents/' . $id;
        $options = [
            'headers' => [
                'Authorization' => 'Bearer ' . getenv('APP_MEDIA_TOKEN'),
                'Content-type' => 'application/json',
            ],
        ];
        $client = new HttpClient();
        $response = $client->request($method, $uri, $options);

        return new JsonResponse(json_decode($response->getBody()->getContents()), $response->getStatusCode());
    }
}