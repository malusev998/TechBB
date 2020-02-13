<?php


namespace App\Controllers;


use App\Dto\SubscriberDto;
use App\Core\Annotations\Can;
use App\Services\SubscriberService;
use App\Exceptions\ModelAlreadyExists;
use App\Core\Annotations\Authenticate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @Authenticate()
     * @Can(permissions={"admin"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getSubscribers(Request $request): Response
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('perPage', 15);
        return $this->ok($this->subscriberService->getSubscribers($page, $perPage));
    }

    public function getSubscriber(int $id): ?Response
    {
        try {
            return $this->ok($this->subscriberService->getSubscriber($id));
        }catch (ModelNotFoundException $e) {
            return $this->notFound(['message' => "Subscriber with id: {$id} is not found"]);
        }
    }

    /**
     * @throws \Throwable
     *
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
        }
    }

    public function unsubscribe(Request $request): Response
    {
        return $this->ok($request->query->get('email'));
    }

}
