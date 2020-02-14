<?php


namespace App\Services;


use App\Dto\ContactDto;
use App\Models\Contact;

use App\Core\Exceptions\ValidationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactService
{
    protected array $operators = ['=', '<>', '>', '<', '>=', '<=', 'LIKE'];

    protected array $column = ['name', 'message', 'subject_id', 'created_at'];

    /**
     * @throws \App\Core\Exceptions\ValidationException
     *
     * @param  int  $perPage
     * @param  array  $filters
     * @param  int  $page
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $page, int $perPage, array $filters = []): LengthAwarePaginator
    {
        $builder = Contact::with(['subject']);

        if (isset($filters['orderBy'])) {
            $builder->orderBy($filters['orderBy'], $filters['orderDirection'] ?? 'desc');
        }

        if (isset($filters['where']) && is_array($filters['where'])) {
            foreach ($filters['where'] as $filter) {
                $errors = [];

                ['column' => $column, 'operator' => $operator, 'value' => $value] = $filter;

                if (!in_array($operator, $this->operators, true)) {
                    $valid = implode(', ', $this->operators);
                    $errors['operator'] = "Operator {$operator} is not in array of valid operators ({$valid})";
                }

                if (!in_array($column, $this->column, true)) {
                    $valid = implode(', ', $this->column);
                    $errors['column'] = "Column {$column} is not in array of valid column ({$valid})";
                }

                if (count($errors) !== 0) {
                    throw new ValidationException($errors);
                }
                $builder->where($column, $operator, $value);
            }
        }

        return $builder->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function get(int $id)
    {
        return Contact::query()->firstOrFail($id);
    }

    /**
     * @throws \Throwable
     *
     * @param  \App\Dto\ContactDto  $data
     *
     * @return \App\Models\Contact
     */
    public function store(ContactDto $data): Contact
    {
        $message = new Contact(
            [
                'name'       => $data['name'],
                'surname'    => $data['surname'],
                'email'      => $data['email'],
                'subject_id' => $data['subject'],
                'message'    => $data['message'],
            ]
        );

        $message->saveOrFail();

        return $message;
    }


    public function delete(int $id)
    {
        return Contact::query()->where('id', '=', $id)->delete();
    }

}
