<?php

namespace App\Exports\user;
use Illuminate\Support\Facades\DB;
use App\User;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;


class UserExport implements FromView
{
       
    



    public function view(): View
    {
           
                
                                $data = User::where('level','=','sales')
                                                    ->orderBy('id','asc')
                                                    ->get();
                
            
       
        return view('tamu.exportexcel_sales', [
            'data' => $data
        ]);
    }

}
