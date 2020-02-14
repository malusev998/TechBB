<?php


namespace App\Services;


use App\Models\Subject;
use App\Exceptions\ModelAlreadyExists;

class SubjectService
{
    public function get()
    {
        return Subject::all();
    }

    public function getWithMessages()
    {
        return Subject::with(['messages'])->get();
    }

    /**
     * @param  int  $id
     *
     * @return \App\Models\Subject
     */
    public function getOne(int $id): Subject
    {
        return Subject::query()->findOrFail($id);
    }

    public function getOneWithMessages(int $id)
    {
        return Subject::with(['messages'])->findOrFail($id);
    }


    /**
     * @throws \Throwable
     * @throws ModelAlreadyExists
     *
     * @param  string  $name
     *
     * @return \App\Models\Subject
     */
    public function create(string $name): Subject
    {
        if (Subject::query()->where('name', '=', $name)->exists()) {
            throw new ModelAlreadyExists();
        }

        $subject = new Subject(['name' => $name]);

        $subject->saveOrFail();

        return $subject;
    }

    /**
     * @param  int  $id
     * @param  string  $name
     *
     * @return int
     */
    public function update(int $id, string $name): int
    {
        return Subject::query()->where('id', '=', $id)->update(['name' => $name]);
    }

    public function delete(int $id)
    {
        return Subject::query()->where('id', '=', $id)->delete();
    }

}

