<?php

namespace App\Http\Controllers\Api;

use App\Device;
use App\Favorite;
use App\Http\Controllers\Controller;
use App\Media;
use App\Utils\Helper;
use App\Utils\Responser;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;

class FavoritesController extends Controller
{

    /**
     * Kullanıcının Token değerine göre favorileri getirir.
     * 
     * @return \App\Utils\Responser
     */
    public function index(Request $request)
    {

        try {

            $device = $this->getDevice($this->getToken($request));
            
            $items = Favorite::device($device->id)->with('media')->get();

        } catch (\Exception $e) {
            abort(500, Responser::MSG_ERROR);
        }

        $res = new Responser;
        return $res->write($items);
    }

    /**
     * Kullanıcının POST metodu ile gönderdiği 'media_id' anahtarına göre favorilere ekleme yapar.
     * 
     * @return \App\Utils\Responser
     */
    public function store(Request $request)
    {

        try {

            $device = $this->getDevice($this->getToken($request));

            $media_id = $request->post('media_id');

            if (Media::where('id', $media_id)->exists() == false) {
                abort(404, Responser::MSG_ITEM_NOT_FOUND);
            }

            $result = Favorite::create(['media_id' => $media_id, 'device_id' => $device->id]);
        } catch (\Exception $e) {
            abort(500, Responser::MSG_ERROR);
        }

        $res = new Responser;
        return $res->status(201)->write($result);
    }

    /**
     * Kullanıcının DELETE metodu ile göndermiş olduğu istek $id parametresi kontrol edilerek silinir.
     * 
     * @params $id (int) 
     * @return \App\Utils\Responser
     */

    public function destroy(Request $request, $id)
    {

        try {

            $device = $this->getDevice($this->getToken($request));

            $query = Favorite::query();
            $condition = $query->device($device->id)->where('id', $id);

            if (!$condition->exists()) {
                abort(404, Responser::MSG_ITEM_NOT_FOUND);
            }

            $deleteResult = $condition->delete();
        } catch (\Exception $e) {
            abort(500, Responser::MSG_ERROR);
        }

        $res = new Responser;
        return $res->status(200)->write($deleteResult);
    }

    /**
     * Request Header'da bulunan Bearer keyine sahip tokeni getirir.
     * 
     * @return (string) 128 Char Len. Token
     */
    private function getToken(Request $request)
    {
        return $request->header(Helper::TOKEN_HANDLER);
    }

    /**
     * Token değeri verilen Device tablosundaki veriyi getirir.
     * 
     * @return \App\Device
     */
    private function getDevice($token = null)
    {
        return Device::token($token)->firstOrFail();
    }
}
