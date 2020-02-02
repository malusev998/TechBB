<?php

namespace App\Services;

use App\Dto\SubscriberDto;
use App\Models\Subscriber;
use App\Exceptions\ModelAlreadyExists;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SubscriberService
{
    /**
     * Paginates all the subscribers from the database
     *
     * @param  int  $page
     * @param  int  $perPage
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getSubscribers(int $page, int $perPage): LengthAwarePaginator
    {
        return Subscriber::query()->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Gets single subscriber from the database
     *
     * @param  int  $id
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getSubscriber(int $id)
    {
        return Subscriber::query()->findOrFail($id);
    }

    /**
     * Creates new subscriber
     *
     * @throws \Throwable
     *
     * @param  \App\Dto\SubscriberDto  $data
     *
     * @return \App\Models\Subscriber
     */
    public function create(SubscriberDto $data): Subscriber
    {
        if (Subscriber::query()->where('email', $data->email)->exists()) {
            throw new ModelAlreadyExists('Subscriber with email'.$data->email.' already exists');
        }

        $subscriber = new Subscriber($data->toArray());

        $subscriber->saveOrFail();

        return $subscriber;
    }

    public function delete(int $id)
    {
        return Subscriber::query()->where('id', $id)->delete();
    }
}
