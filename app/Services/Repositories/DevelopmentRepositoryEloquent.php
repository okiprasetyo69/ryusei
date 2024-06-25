<?php

namespace App\Services\Repositories;

use App\Models\Development;
use App\Services\Interfaces\DevelopmentService;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File; 

/**
 * Class DevelopmentRepositoryEloquent.
 * 
 * @author  Oki Prasetyo  <oki.prasetyo45@gmail.com>
 * @since   2024.06.24
 * 
 *
 * @package namespace App\Services\Repositories;
 */

 class DevelopmentRepositoryEloquent implements DevelopmentService {
      /**
     * @var Development
     */
    private Development $development;

    public function __construct(Development $development)
    {
        $this->development = $development;
    }

    public function getDevelopment(Request $request){
        try{
            $development = $this->development::orderBy("created_at", "DESC");

            if($request->received_design_date != null){
                $development =  $development->where("received_design_date", $request->received_design_date);
            }

            if($request->sample_date != null){
                $development =  $development->where("sample_date", $request->sample_date);
            }

            if($request->title != null){
                $development =  $development->where("title", $request->title);
            }

            $development = $development->get();

            $datatables = Datatables::of($development);
            return $datatables->make( true );
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function create(Request $request){
        try{
            $development = $this->development; 
            $development->fill($request->all());

            $designImageName = "";
            $sampleImageName = "";

            // add new file design image
            if($request->hasFile('design_image')){
                $fileDesignImage = $request->file('design_image');
                $designImageName = $fileDesignImage->getClientOriginalName();
                $developmentImage['filePath'] = $designImageName;
                $fileDesignImage->move(public_path().'/uploads/production/development/design/', $designImageName);
            }

            // add new file sample image
            if($request->hasFile('sample_image')){
                $fileSampleImage = $request->file('sample_image');
                $sampleImageName = $fileSampleImage->getClientOriginalName();
                $sampleImage['filePath'] = $sampleImageName;
                $fileSampleImage->move(public_path().'/uploads/production/development/sample/', $sampleImageName);
            }

            $development->title = $request->title;
            $development->received_design_date = $request->received_design_date;
            $development->sample_date = $request->sample_date;
            $development->design_image = $designImageName;
            $development->sample_image = $sampleImageName;
            $development->description = $request->description;

            $development->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $development
            ]); 

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function update(Request $request){
        try{
            $development = $this->development;
            $development->fill($request->all());

            $development = $development->where("id", $request->id)->first();

            if($development == null){
                return response()->json([
                    'status' => 200,
                    'message' => 'Data development not found !',
                ]);
            }

            $newDesignName = "";
            $newSampleName = "";

            if($request->hasFile('design_image')){
                if(!empty($request->design_image)){
                    // check exist file
                    $designImage = $this->development::where("id", $request->id)->first();
                    $fileDesignImageName = $designImage->design_image;
                    $existFileDesignImage = File::exists(public_path('uploads/production/development/design/'.$fileDesignImageName.'')); 
                    // remove exist file
                    if($existFileDesignImage){
                        File::delete(public_path('uploads/production/development/design/'.$fileDesignImageName.''));
                    }
                }
                // add new file
                $newFileDesignImage = $request->file('design_image');
                $newDesignName = $newFileDesignImage->getClientOriginalName();
                $newDesignImage['filePath'] = $newDesignName;
                $newFileDesignImage->move(public_path().'/uploads/production/development/design/', $newDesignName);
            } else {
                $newDesignName = $development->design_image;
            }

            if($request->hasFile('sample_image')){
                if(!empty($request->sample_image)){
                    // check exist file
                    $sampleImage = $this->development::where("id", $request->id)->first();
                    $fileSampleImageName = $sampleImage->sample_image;
                    $existFileSampleImage = File::exists(public_path('uploads/production/development/sample/'.$fileSampleImageName.'')); 
                    // remove exist file
                    if($existFileSampleImage){
                        File::delete(public_path('uploads/production/development/sample/'.$fileSampleImageName.''));
                    }
                }
                // add new file
                $newFileSampleImage = $request->file('sample_image');
                $newSampleName = $newFileSampleImage->getClientOriginalName();
                $newSampleImage['filePath'] = $newSampleName;
                $newFileSampleImage->move(public_path().'/uploads/production/development/sample/', $newSampleName);
            } else {
                $newSampleName = $development->sample_image;
            }

            $development->title = $request->title;
            $development->received_design_date = $request->received_design_date;
            $development->sample_date = $request->sample_date;
            $development->design_image = $newDesignName;
            $development->sample_image = $newSampleName;
            $development->description = $request->description;

            $development->save();

            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $development
            ]); 
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function delete(Request $request){
        try{
            $development = $this->development::where("id", $request->id)->first();
            if($development == null){
                return response()->json([
                    'data' => null,
                    'message' => 'Data not found',
                    'status' => 400
                ]);
            }

            $fileDesignImage = $development->design_image;
            $fileSampleImage = $development->sample_image;
            $existFileDesginImage= File::exists(public_path('uploads/production/development/design/'.$fileDesignImage.'')); 
            $existFileSampleImage = File::exists(public_path('uploads/production/development/sample/'.$fileSampleImage.'')); 

            if($existFileDesginImage){
                File::delete(public_path('uploads/production/development/design/'.$fileDesignImage.''));
            }

            if($existFileSampleImage){
                File::delete(public_path('uploads/production/development/sample/'.$fileSampleImage.''));
            }
            
            $development->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Success delete product .',
            ]);

        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

    public function edit(Request $request){

    }

    public function detail(Request $request){
        try{
            $development = $this->development::where("id", $request->id)->first();
            return response()->json([
                'status' => 200,
                'message' => true,
                'data' => $development
            ]);
        }catch(Exception $ex){
            Log::error($ex->getMessage());
            return false;
        }
    }

 }