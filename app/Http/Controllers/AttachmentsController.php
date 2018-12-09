<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Attachment;
use App\Board;


class AttachmentsController extends Controller
{

    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //1번 구현
        1. 전송받은 파일을 지정된 폴더에 저장한다.
            어느 폴더에 저장하나?
            public/files/사용자_아이디/
        2. 파일 정보를 attachment 테이블에 저장한다.
        3. 잘 저장 되었어요 라는 결과를 클라이언트에게 송신한다.
        if($reuqest->hasFile('file')) {
            $file = $request->file('file');
            $filename = filter_var($file->getClientOriginalName(), FILTER_SANITIZE_URL);
            $bytes = $file->getSize();
            $user = \Auth::user();
            $path = public_path('files') . DIRECTORY_SEPARATOR . $user->id;
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            $file->move($path, $filename);
            //////////////////////////////////// 
            //2번 구현
            $payload = [
                'filename'=>$filename,
                'bytes'=> $bytes,
                'mime'=>$file->getClientMimeType()
            ];

            $attachment =  Attachment::create($payload);
            ///////////////////////////////////////
            
        }
        
        return response()->json($attachment, 200);
        //{'filename':'a.jpg', 'bytes':4567, 'mime':'jpt', 'id':1}
        

    }

    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
