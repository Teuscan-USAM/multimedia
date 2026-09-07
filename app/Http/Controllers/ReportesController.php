<?php

namespace App\Http\Controllers;

class ReportesController extends Controller
{
    public function index()
    {
        $titulo = 'Reportes';
        return view('modules.reportes.index', compact('titulo'));   
    }
}