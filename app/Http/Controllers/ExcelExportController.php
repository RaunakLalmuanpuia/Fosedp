<?php

namespace App\Http\Controllers;

use App\Exports\ApplicationsExport;
use App\Exports\ExportApplications;
use App\Jobs\ExportJob;
use App\Models\Application;
use App\Models\ExportReport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\SimpleExcel\SimpleExcelWriter;

class ExcelExportController extends Controller
{

    public function index(Request $request)
    {
        return inertia('Backend/Report/Index', [
            'list' => ExportReport::query()->with(['user'])->where('user_id', auth()->id())->get(),
        ]);
    }

    public function exportReceivedApplication(Request $request)
    {

        $user = auth()->user();

        $list=Application::query()
        ->with(['district','constituency','trade','department','subTrade','currentStatus','bankAccount'])
        ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('recipient_id',auth()->id())->whereNotNull('received_at'))
        ->get();
        $exportReport=ExportReport::query()->create([
            'user_id' => auth()->id(),
            'title'=>'Inbox Report created on '.now()->format('D-M-Y h:m a').' - '.$user?->name
        ]);
        $path = "report/" . $user->name . 'report_created_on' . now()->timestamp.'.xlsx';
        $writer = SimpleExcelWriter::create(storage_path("app/public/$path"));

        $writer->addHeader(['head_of_family','mobile','epic_no','district','constituency','address','department','trade','sub_trade','ac_holder', 'bank_name','branch_name','ac_no', 'ifsc']);
        $list->map(function ($application,$i) use ($writer) {
            $writer->addRow([
                'head_of_family' => $application?->head_of_family,
                'mobile' => $application?->mobile,
                'epic_no'=>$application?->epic_no,
                'district'=>$application?->district?->name,
                'constituency'=>$application?->constituency?->name,
                'address'=>$application?->address,
                'department'=>$application?->department?->name,
                'trade'=>$application?->trade?->name,
                'sub_trade'=>$application?->subTrade?->name,
                'ac_holder'=>$application?->bankAccount?->ac_holder,
                'bank_name'=>$application?->bankAccount?->bank_name,
                'branch_name'=>$application?->bankAccount?->branch_name,
                'ac_no'=>$application?->bankAccount?->ac_no,
                'ifsc'=>$application?->bankAccount?->ifsc,
            ]);
            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
        });
        $exportReport->path = $path;
        $exportReport->status = 'generated';
        $exportReport->save();

//        $this->dispatch(new ExportJob($user, $list,$exportReport));

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Report is generating in background'
        ]);
        return back();
    }
    public function exportIncomingApplication(Request $request)
    {

        $user = auth()->user();

        $list=Application::query()
        ->with(['district','constituency','trade','department','subTrade','currentStatus','bankAccount'])
        ->whereHas('lastMovement', fn(Builder $builder) => $builder->where('recipient_id',auth()->id())->whereNull('received_at'))
        ->get();
        $exportReport=ExportReport::query()->create([
            'user_id' => auth()->id(),
            'title'=>'Incoming Record created on '.now()->format('D-M-Y h:m a').' - '.$user?->name
        ]);
        $path = "report/" . $user->name . 'report_created_on' . now()->timestamp.'.xlsx';
        $writer = SimpleExcelWriter::create(storage_path("app/public/$path"));

        $writer->addHeader(['head_of_family','mobile','epic_no','district','constituency','address','department','trade','sub_trade','ac_holder', 'bank_name','branch_name','ac_no', 'ifsc']);
        $list->map(function ($application,$i) use ($writer) {
            $writer->addRow([
                'head_of_family' => $application?->head_of_family,
                'mobile' => $application?->mobile,
                'epic_no'=>$application?->epic_no,
                'district'=>$application?->district?->name,
                'constituency'=>$application?->constituency?->name,
                'address'=>$application?->address,
                'department'=>$application?->department?->name,
                'trade'=>$application?->trade?->name,
                'sub_trade'=>$application?->subTrade?->name,
                'ac_holder'=>$application?->bankAccount?->ac_holder,
                'bank_name'=>$application?->bankAccount?->bank_name,
                'branch_name'=>$application?->bankAccount?->branch_name,
                'ac_no'=>$application?->bankAccount?->ac_no,
                'ifsc'=>$application?->bankAccount?->ifsc,
            ]);
            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
        });
        $exportReport->path = $path;
        $exportReport->status = 'generated';
        $exportReport->save();

//        $this->dispatch(new ExportJob($user, $list,$exportReport));

        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Report is generating in background'
        ]);
        return back();
    }
    public function exportDistrictApplication(Request $request)
    {
        $user = auth()->user();
        $ids=$user->districts()->pluck('id');

        $district=$request->get('district_id');
        $constituency=$request->get('constituency_id');
        $department=$request->get('department_id');
        $trade=$request->get('trade_id');
        $list=Application::query()
            ->with(['district','constituency','trade','subTrade','lastMovement','department','bankAccount'])
            ->when($constituency,fn(Builder $builder)=>$builder->where('constituency_id',$constituency))
            ->when($department,fn(Builder $builder)=>$builder->where('department_id',$constituency))
            ->when($trade,fn(Builder $builder)=>$builder->where('trade_id',$trade))
            ->when($district,fn(Builder $builder)=>$builder->where('district_id',$district))
            ->whereIn('district_id', $ids)
            ->get();

        $exportReport=ExportReport::query()->create([
            'user_id' => auth()->id(),
            'title'=>'Report created on '.now()->format('D-M-Y h:m a').' - '.$user?->name
        ]);

        //test
        $path = "report/" . $user->name . 'report_created_on' . now()->timestamp.'.xlsx';
        $writer = SimpleExcelWriter::create(storage_path("app/public/$path"));

        $writer->addHeader(['head_of_family','mobile','epic_no','district','constituency','address','department','trade','sub_trade','ac_holder', 'bank_name','branch_name','ac_no', 'ifsc']);
        $list->map(function ($application,$i) use ($writer) {
            $writer->addRow([
                'head_of_family' => $application?->head_of_family,
                'mobile' => $application?->mobile,
                'epic_no'=>$application?->epic_no,
                'district'=>$application?->district?->name,
                'constituency'=>$application?->constituency?->name,
                'address'=>$application?->address,
                'department'=>$application?->department?->name,
                'trade'=>$application?->trade?->name,
                'sub_trade'=>$application?->subTrade?->name,
                'ac_holder'=>$application?->bankAccount?->ac_holder,
                'bank_name'=>$application?->bankAccount?->bank_name,
                'branch_name'=>$application?->bankAccount?->branch_name,
                'ac_no'=>$application?->bankAccount?->ac_no,
                'ifsc'=>$application?->bankAccount?->ifsc,
            ]);
            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
        });
        $exportReport->path = $path;
        $exportReport->status = 'generated';
        $exportReport->save();

//        $this->dispatch(new ExportJob($user, $list,$exportReport));


        session()->flash('notification',[
            'type'=>'positive',
            'message'=>'Report is generating in background'
        ]);
        return back();

    }
}
