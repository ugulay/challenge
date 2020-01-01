<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Utils\Responser;

use App\Media;

class MediaController extends Controller
{

    /**
     * $id Parametresinde belirtilen değere göre Media ve ona bağlı olan Category ile Favorites bilgilerini getirir.
     *
     * @param  int  $id
     * @return App\Utils\Responder
     */
    public function show($media)
    {

        $media = Media::find($media);

        $res = new Responser;
        return $res->status(200)->write($media, $media->category, $media->favorite);
    }
}
