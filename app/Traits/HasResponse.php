<?php

namespace App\Traits;

trait HasResponse
{
    protected function responseData($data = [], $msg = '')
    {
        $msg = $msg ?: __('notify.success');
        return response([
            'status' => 1,
            'type'   => 'success',
            'data'   => $data,
            'msg'    => $msg
        ]);
    }

    protected function responseSuccess($msg = '')
    {
        $msg = $msg ?: __('notify.success');
        return response([
            'type'   => 'success',
            'msg'    => $msg
        ]);
    }

    protected function responseError($msg = '', $errors = [])
    {
        if(empty($msg)){
            $msg = [__('notify.error')];
        } else if (!is_array($msg)){
            $msg = [$msg];
        }

        return response([
            'type'   => 'error',
            'errors' => $errors,
            'msg'    => $msg
        ], 400);
    }
}
