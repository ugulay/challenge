<?php

namespace App\Utils;

use Illuminate\Support\Facades\Response;

/**
 * 
 * İlgili sınıf bir Response standartı oluşturma amacıyla kullanılacaktır.
 * Örn kullanım için :
 * 
 * $res = new Responser;
 * return $res->status(500)->write('');
 * return $res->write(User:all());
 * return $res->status(200)->errMessage('')->write($kullaniciVerileri);
 *  
 */
class Responser
{

    const MSG_ERROR = 'Bir hata ile karşılaşıldı.';
    const MSG_ITEM_NOT_FOUND = 'Obje bulunamadı.';
    const MSG_ERROR_VERSION_INCORRECT = 'Sürüm kontrolü sırasında bir hata meydana geldi.';
    const MSG_ERROR_VERSION_FAILED = 'Sistem sürümü kontrol edilemedi.';
    const MSG_NEED_UPDATE = 'Uygulamanızı güncellemeniz gerekmektedir.';
    const MSG_TOKEN_NOT_FOUND = 'Cihazınıza ait kimlik bilgisine ulaşılamadı.';
    const MSG_ERROR_INCORRECT_ENDPOINT = 'Geçersiz bir endpoint.';

    private $data = [
        'errorCode' => 200,
        'errorMessage' => '',
        'payload' => ''
    ];

    private $httpCode = 200;

    /**
     * Http Status kodunu header ile döndürür.
     * 
     * @access public
     * @param (int) Http Status Code
     * @return (int) $this
     */
    public function status($code = 200)
    {
        $this->httpCode = (int) $code;
        return $this;
    }

    /**
     * Hata mesajları bu metod ile yazdırılır.
     * 
     * @access public
     * @param (string) Hata mesajını içeren metin
     * @return (string) $this
     */
    public function errorMessage($message = '')
    {
        $this->data['errorMessage'] = (string) $message;
        return $this;
    }

    /**
     * $data Payload için json ile geri döndürelecek cevabı doldurur.
     * 
     * @access public
     * @param (mixed) Payload içerisinde gönderilecek veri
     * @return json
     */
    public function write($data = null)
    {
        $this->data['errorCode'] = $this->httpCode;
        $this->data['payload'] = $data;
        return Response::json($this->data, $this->httpCode);
    }
}
