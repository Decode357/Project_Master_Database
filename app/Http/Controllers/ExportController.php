<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\{
    CustomersExport,
    ShapesExport,
    GlazesExport,
    PatternsExport,
    BackstampsExport,
    CustomersTemplateExport,
    ShapesTemplateExport, 
    GlazesTemplateExport, 
    PatternsTemplateExport,
    BackstampsTemplateExport,
};


class ExportController extends Controller
{
    /**
     * Export ข้อมูลทั้งหมด
     */
    public function customer_export()
    {
        return Excel::download(new CustomersExport, 'customers_' . date('Y-m-d') . '.xlsx');
    }
    public function shape_export()
    {
        return Excel::download(new ShapesExport, 'shapes_' . date('Y-m-d') . '.xlsx');
    }
    public function glaze_export()
    {
        return Excel::download(new GlazesExport, 'glazes_' . date('Y-m-d') . '.xlsx');
    }
    public function pattern_export()
    {
        return Excel::download(new PatternsExport, 'patterns_' . date('Y-m-d') . '.xlsx');
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
    public function shape_exportTemplate()
    {
        return Excel::download(new ShapesTemplateExport, 'shape_template.xlsx');
    }
    public function glaze_exportTemplate()
    {
        return Excel::download(new GlazesTemplateExport, 'glaze_template.xlsx');
    }
    public function pattern_exportTemplate()
    {
        return Excel::download(new PatternsTemplateExport, 'pattern_template.xlsx');
    }
    public function backstamp_exportTemplate()
    {
        return Excel::download(new BackstampsTemplateExport, 'backstamp_template.xlsx');
    }
}
