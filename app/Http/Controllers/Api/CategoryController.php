<?php

namespace App\Http\Controllers\Api;

use App\Category;
use App\Http\Controllers\Controller;
use App\Utils\Responser;

class CategoryController extends Controller
{
    /**
     * Kategori listesini döndüren metod
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Category::all();
        $res = new Responser;
        return $res->write($data);
    }

    /**
     * Kategori detayını ve altında bulunan sesleri çevirir.
     *
     * @param  \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {

        $res = new Responser;
        return $res->write($category, $category->media);
    }
}
