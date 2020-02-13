<?php


namespace App\Controllers;


use App\Dto\ContactDto;
use App\Core\Annotations\Can;
use App\Services\ContactService;
use App\Core\Annotations\Authenticate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContactController extends ApiController
{
    protected ContactService $contactService;

    /**
     * ContactController constructor.
     *
     * @param  \App\Services\ContactService  $contactService
     */
    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * @throws \App\Core\Exceptions\ValidationException
     *
     * @param  \Symfony\Component\HttpFoundation\Request  $request
     * @Authenticate()
     * @Can(permissions={"admin"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function paginate(Request $request): Response
    {
        return $this->ok(
            $this->contactService->paginate(
                (int)$request->query->get('page', 1),
                (int)$request->query->get(
                    'perPage',
                    15
                )
            )
        );
    }

    /**
     * @param  int  $id
     *
     * @Authenticate()
     * @Can(permissions={"admin"})
     * @return \Symfony\Component\HttpFoundation\Response|null
     */
    public function get(int $id): ?Response
    {
        try {
            return $this->ok($this->contactService->get($id));
        } catch (ModelNotFoundException $e) {
            return $this->notFound(['message' => 'Contact message is not found']);
        }
    }


    /**
     * @throws \Throwable
     *
     * @param  \App\Dto\ContactDto  $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function contact(ContactDto $data): Response
    {
        return $this->created($this->contactService->store($data));
    }

    /**
     * @param  int  $id
     *
     * @Authenticate()
     * @Can(permissions={"admin"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(int $id): Response
    {
        $this->contactService->delete($id);

        return $this->noContent();
    }
}
