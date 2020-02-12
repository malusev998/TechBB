<?php


namespace App\Controllers;


use Throwable;
use App\Dto\SubscriberDto;
use App\Core\Annotations\Can;
use App\Services\SubscriberService;
use App\Exceptions\ModelAlreadyExists;
use App\Core\Annotations\Authenticate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribeController extends ApiController
{
    protected SubscriberService $subscriberService;

    /**
     * SubscribeController constructor.
     *
     * @param  \App\Services\SubscriberService  $subscriberService
     */
    public function __construct(SubscriberService $subscriberService)
    {
        $this->subscriberService = $subscriberService;
    }


    /**
     * @param  \App\Dto\SubscriberDto  $data
     *
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function subscribe(SubscriberDto $data): ?Response
    {
        try {
            return $this->created($this->subscriberService->create($data));
        } catch (ModelAlreadyExists $e) {
            return $this->badRequest(['message' => $e->getMessage()]);
        } catch (Throwable $e) {
            return $this->serverError(['message' => 'An error has occurred']);
        }
    }

    public function unsubscribe(Request $request): Response
    {
        return $this->ok($request->query->get('email'));
    }

}
