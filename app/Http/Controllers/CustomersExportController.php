<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\CustomerTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class CustomersExportController extends Controller
{
    /**
     * Export ข้อมูลลูกค้าทั้งหมด
     */
    public function export()
    {
        return Excel::download(new CustomersExport, 'customers_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export เทมเพลตสำหรับ Import
     */
    public function exportTemplate()
    {
        return Excel::download(new CustomerTemplateExport, 'customer_template.xlsx');
    }
}
