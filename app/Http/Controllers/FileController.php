<?php namespace App\Http\Controllers;

use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Image;
use Illuminate\Http\Request;
use Validator;
use App\File;
use Storage;

class FileController extends Controller {

    public function index(Request $request)
    {
        $files = File::all();
        return response()->json(['success' => true, 'result' => $files]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:doc,pdf,docx,zip,jpeg,jpg,png',
            'app_id' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>'error','message'=>$validator->messages()], 400);
        }

        $file = $request->file('file');
        $inputs = $request->all();
        $createdFiles = [];

        // foreach ($files as $key => $file) {
            if ( $file->isValid() ) {
                $filename = md5(microtime()).'.'.$file->getClientOriginalExtension();
                $uploadsDir = public_path('uploads');
                $firstPath = array_diff(scandir($uploadsDir), array('..', '.'));
                $secondPath = array_diff(scandir($uploadsDir.'/'.end($firstPath)), array('..', '.'));
                $currentPath = $uploadsDir.'/'.end($firstPath).'/'.end($secondPath);

                $currentDir = scandir($currentPath);
                if(count($currentDir) < 1000)
                    $file->move($currentPath, $filename);
                else {
                    $totalDirs = count( scandir($uploadsDir.'/'.end($firstPath)) );

                    if($totalDirs < 10001){
                        $newDir = str_pad($totalDirs - 1, 4, "0", STR_PAD_LEFT);
                        $currentPath = $uploadsDir.'/'.end($firstPath).'/'.$newDir;
                    }
                    else {
                        $totalDirs = count( scandir($uploadsDir) );
                        $newDir = str_pad($totalDirs - 1, 4, "0", STR_PAD_LEFT);
                        $currentPath = $uploadsDir.'/'.$newDir.'/0001';
                    }
                    mkdir($currentPath, 0755, true);

                    $file->move($currentPath, $filename);
                }

                $fileObj = new File;
                $fileObj->user_id = $request->user()->id;
                $fileObj->app_id = $inputs['app_id'];
                $fileObj->hash = $filename;
                $fileObj->original_name = $file->getClientOriginalName();
                $fileObj->path = substr($currentPath, strpos($currentPath, 'uploads'));
                $fileObj->mime_type = $file->getClientMimeType();
                $fileObj->save();
                $createdFiles['id'] = $fileObj->id;
                $createdFiles['path'] = $fileObj->path.'/'.$fileObj->hash;
            }   
        // }   

        return response()->json([
            'success'=>true,
            'message'=>'File has been uploaded',
            'files' => $createdFiles
        ]);
    }

    public function uploadFile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'mimes:jpeg,jpg'         
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>'error','message'=>$validator->messages()], 400);
        }

        $files = $request->files->get('uploads');
        $contact_id = $request->input('contact_id');

        if($files){
            foreach ($files as $file) {
                if ( $file->isValid() ) {
                    $filename = md5(microtime()).'.'.$file->getClientOriginalExtension();
                    $uploadsDir = public_path('uploads');
                    $firstPath = array_diff(scandir($uploadsDir), array('..', '.'));
                    $secondPath = array_diff(scandir($uploadsDir.'/'.end($firstPath)), array('..', '.'));
                    $currentPath = $uploadsDir.'/'.end($firstPath).'/'.end($secondPath);

                    $currentDir = scandir($currentPath);
                    if(count($currentDir) < 1002)
                        $file->move($currentPath, $filename);
                    else {
                        $totalDirs = count( scandir($uploadsDir.'/'.end($firstPath)) );

                        if($totalDirs < 10001){
                            $newDir = str_pad($totalDirs - 1, 4, "0", STR_PAD_LEFT);
                            $currentPath = $uploadsDir.'/'.end($firstPath).'/'.$newDir;
                        }
                        else {
                            $totalDirs = count( scandir($uploadsDir) );
                            $newDir = str_pad($totalDirs - 1, 4, "0", STR_PAD_LEFT);
                            $currentPath = $uploadsDir.'/'.$newDir.'/0001';
                        }
                        mkdir($currentPath, 0755, true);

                        $file->move($currentPath, $filename);
                    }

                    $data_file = array(
                        'hash' => $filename,
                        'original_name' => $file->getClientOriginalName(),
                        'path' => substr($currentPath, strpos($currentPath, 'uploads')),
                        'mime_type' => $file->getClientMimeType(),
                    );

                    return response()->json(['status'=>'success','file'=>$data_file]);
                }   
            }   
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($hash)
    {
        $file = File::where('hash', $hash)->get()->first();

        if($file) {
            $file_contents = file_get_contents($file->path.'/'.$file->hash, true);

            $response = Response::make($file_contents, 200);
            $response->header('Content-type', $file->mime_type);
            $response->header('Content-Disposition', 'inline; filename='.$file->original_name);

            return $response;
        }
        else
            return response()->json(['status'=>'success','message'=>'File not found']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($hash)
    {
        $file = File::where('hash', $hash)->get()->first();

        if($file) {
            $path = $file->path.'/'.$file->hash;

            if(Storage::disk('public_uploads')->exists($path))
                unlink(public_path($path));

            File::destroy($file->id);

            return response()->json(['status'=>'success','message'=>'File has been deleted']);
        }
        else
            return response()->json(['status'=>'success','message'=>'File not found']);
    }

}
