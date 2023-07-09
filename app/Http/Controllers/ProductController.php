<?php

namespace App\Http\Controllers;

use App\Models\Auth;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class ProductController extends Controller
{

    public function products()
    {
        // return (Config::get('database.connections'));

        return Product::get();
    }
}
