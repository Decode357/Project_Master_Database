<?php

namespace App\Http\Controllers;

use App\Exports\CustomersExport;
use App\Exports\CustomersTemplateExport;
use App\Exports\BackstampsExport;
use App\Exports\BackstampsTemplateExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    /**
     * Export ข้อมูลทั้งหมด
     */
    public function customer_export()
    {
        return Excel::download(new CustomersExport, 'customers_' . date('Y-m-d') . '.xlsx');
    }
    public function backstamp_export()
    {
        return Excel::download(new BackstampsExport, 'backstamp_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Export เทมเพลตสำหรับ Import
     */
    public function customer_exportTemplate()
    {
        return Excel::download(new CustomersTemplateExport, 'customer_template.xlsx');
    }
    public function backstamp_exportTemplate()
    {
        return Excel::download(new BackstampsTemplateExport, 'backstamp_template.xlsx');
    }
}
