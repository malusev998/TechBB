<?php


namespace App\Controllers;


use App\Dto\SubjectDto;
use App\Core\Annotations\Can;
use App\Services\SubjectService;
use App\Core\Annotations\Authenticate;
use App\Exceptions\ModelAlreadyExists;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class SubjectController extends ApiController
{
    protected SubjectService $subjectService;

    public function __construct(SubjectService $subjectService)
    {
        $this->subjectService = $subjectService;
    }

    public function get(Request $request): Response
    {
        $withMessages = (bool)$request->query->get('include-messages', false);

        if ($withMessages) {
            return $this->ok($this->subjectService->getWithMessages());
        }

        return $this->ok($this->subjectService->get());
    }


    /**
     * @Authenticate()
     * @Can(permissions={"admin"})
     *
     * @throws \Throwable
     *
     * @param  \App\Dto\SubjectDto  $data
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(SubjectDto $data): ?Response
    {
        try {
            return $this->ok($this->subjectService->create($data->name));
        } catch (ModelAlreadyExists $e) {
            return $this->badRequest(['message' => "Subject with name{$data->name} already exists"]);
        }
    }

    /**
     * @param  int  $id
     * @param  \App\Dto\SubjectDto  $data
     * @Authenticate()
     * @Can(permissions={"admin"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function update(int $id, SubjectDto $data): Response
    {
        $this->subjectService->update($id, $data->name);
        return $this->noContent();
    }


    /**
     * @param  int  $id
     * @Authenticate()
     * @Can(permissions={"admin"})
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function delete(int $id): ?Response
    {
        $this->subjectService->delete($id);

        return $this->noContent();
    }

}
