<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessagerieController extends Controller
{
    public function index(){
        
        return View('private.messagerie');
    }    

}
