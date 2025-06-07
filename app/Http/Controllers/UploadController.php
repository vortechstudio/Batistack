<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mockery\Exception;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->file('file')
                ->storeAs(
                    path: $request->get('folder'),
                    name: $request->get('name_file'),
                    options: 'public'
                );
            toastr()->addSuccess("Fichier uploadé avec succès");
            return redirect()->back();
        }catch (Exception $exception) {
            toastr()->addError($exception->getMessage());
            return redirect()->back();
        }
    }
}
