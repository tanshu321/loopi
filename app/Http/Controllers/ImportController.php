<?php

namespace App\Http\Controllers;

use App\Models\Import;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Facades\File;

use DataTables;
use Log;
class ImportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $importData = Import::paginate(10);

        return view('import.index', compact('importData'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('import.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'filename' => ['required', 'file', 'mimes:csv'],
        ]);
        
        $module = $request->get('module');
        $path = $request->file('filename')->getRealPath();
        $time = "query_".strtotime('now').'.log';
        DB::disableQueryLog();

        if($module==1)
            DB::table('customers')->truncate();
        else
            DB::table('products')->truncate();

        LazyCollection::make(function () use ($path,$request,$module){
          
            $handle = fopen($path, 'r');
           
            while (($line = fgetcsv($handle, 4096)) !== false) {
                yield $line;
            }

            fclose($handle);
        })
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) use ($request,$time,$module) {
               // DB::enableQueryLog();
            
                $records = $chunk
                    ->map(function ($row) use ($module) {

                        if($module==1)
                            return [
                                'id' => $row[0],
                                'job_title' => $row[1],
                                'email_address' => $row[2],
                                'first_name' => $row[3],
                                'registered_since' => !empty($row[4]) ? date("Y-m-d",strtotime($row[4])) : '',
                                'phone' => $row[5],
                            ];
                        else
                        return [
                            'id' => $row[0],
                            'productname' => $row[1],
                            'price' => $row[2],
                            'created_at'=>date("Y-m-d H:m:i",strtotime('now'))
                        ];
                    })
                    ->toArray();

                    if($module==1)
                        DB::table('customers')->insert($records);
                    else
                        DB::table('products')->insert($records);


                    DB::listen(function($query) use ($time) {
                       
                        File::append(
                            storage_path('/logs/'.$time),
                            $query->sql . ' [' . implode(', ', $query->bindings) . ']' . PHP_EOL
                        );
                    });
                   
        
                   
            });
            Import::create(array(
                'filename'=>$request->file('filename')->getClientOriginalName(),
                'module'=>$module,
                'logfile'=>$time
                )
            );
            return redirect('import')->with('success', 'Import has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function show(Import $import)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function edit(Import $import)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Import  $import
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Import $import)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Import $Import
     * @return \Illuminate\Http\Response
     */
    public function destroy(Import $import)
    {
        //
    }

    // used for datatable
    public function getImports(Request $request)
    {
        if ($request->ajax()) {
            $data = Import::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn =
                        '<a href="javascript:void(0)" class="edit btn btn-success btn-sm">Edit</a> <a href="javascript:void(0)" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
}
