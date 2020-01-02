<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Utils\Helper;
use App\Utils\Responser;

use PHLAK\SemVer;
use App\Version;
use App\Device;


class DevicesController extends Controller
{
    /**
     * Uygulama bootunda ilk istek için token ve sürüm kontrolünü yapar.
     *
     * @return \Illuminate\Http\Response
     */
    public function splash(Request $request)
    {

        $res = new Responser;

        $updateControl = $this->updateControl($res, $request);
        $tokenControl = $this->tokenControl($res, $request);

        if ($updateControl !== true) {
            return $updateControl;
        }

        if ($tokenControl !== true) {
            return $tokenControl;
        }

        //Success
        return $res->status(200)->write('handshake');
    }

    /**
     * Kullanıcı için ilk Token oluşturan ve geri çeviren metod
     * 
     * @return bool|\Illuminate\Http\Response
     */
    private function tokenControl(Responser $res, Request $request)
    {

        $token = $request->header(Helper::TOKEN_HANDLER, null);

        $tokenControl = Device::token((string) $token)->exists();

        if (strlen($token) < Helper::TOKEN_LEN || $tokenControl === false) {
            $newToken = Helper::createToken();
            if (Device::create(['token' => $newToken])) {
                return $res->status(201)->write(['token' => $newToken]);
            } else {
                //Token Devices tablosuna kaydedilemezse
                abort(500, Responser::MSG_ERROR);
            }
        }

        return true;
    }

    /**
     * Sürüm kontrolünü yapan metoddur.
     * 
     * @return bool|\Illuminate\Http\Response;
     */
    private function updateControl(Responser $res, Request $request)
    {

        $currentUserVersion = $request->header('Version','');

        // Semver ile geçerli kullanıcı sürümünün kontrolü sağlanıyor.
        try {
            $currentUserVersion = new SemVer\Version($currentUserVersion);
        } catch (\Exception $e) {
            abort(403, Responser::MSG_ERROR_HEADER_VERSION_NOT_FOUND);
        }

        // Geçerli kullanıcı sürümü app sürümü arasındaki fark kontrol ediliyor.
        try {
            $lastVersionData = Version::LastVersion() ?: '';
            $lastVersion = new SemVer\Version($lastVersionData->version);
        } catch (\Exception $e) {
            // DB Versions tablosundaki sürüm numarası geçersiz ise.
            abort(403, Responser::MSG_ERROR_VERSION_FAILED);
        } finally {
            // Kul. Sürümü ve Sistem sürümü karşılaştırma
            if ($currentUserVersion->neq($lastVersion)) {

                $updateInfo = [
                    'lastVersion' => $lastVersionData->version,
                    'update' => $lastVersionData->update,
                    'updateForce' => $lastVersionData->updateForce,
                    'updateLang' => $lastVersionData->updateLang
                ];

                return $res->status(426)
                    ->errorMessage(Responser::MSG_NEED_UPDATE)
                    ->write($updateInfo);
            }
        }

        return true;
    }
}
