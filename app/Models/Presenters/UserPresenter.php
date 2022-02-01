<?php

namespace App\Models\Presenters;

use Illuminate\Support\Facades\Storage;
use TheHiveTeam\Presentable\Presenter;

class UserPresenter extends Presenter
{
    /**
     * This is a example.
     *
     * @return string
     */
    public function name()
    {
        return $this->model->name;
    }

    public function photourl()
    {
        return Storage::disk('s3')->url($this->model->photo);
    }
}
