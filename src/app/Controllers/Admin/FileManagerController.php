<?php

namespace Rakadprakoso\Ceemas\app\Controllers\Admin;

use Rakadprakoso\Ceemas\models\Post;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Illuminate\Support\Facades\Storage;
use Rakadprakoso\Ceemas\app\FileManager;
use Rakadprakoso\Ceemas\app\models\Config;
use Illuminate\Support\Facades\View;

class FileManagerController extends CeemasGlobalDataController
{
    /**
     * @var FileManager
     */
    public $fm;

    public function __construct(FileManager $fm)
    {
        $this->ceemas_setting = Config::all()->pluck(
            'value',
            'key'
          );
        View::share('ceemas_setting', $this->ceemas_setting);
        $this->fm = $fm;
    }

    public function index2()
    {
        //event(new BeforeInitialization());

        return response()->json(
            $this->fm->initialize()
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('ceemas::admin.filemanager.index');
        $files = Storage::disk('public');
        //return dd($files);
        $files = Storage::files();
        //$files = Storage::allFiles($directory);
        $config = $this->fm->initialize();
        $tree = $this->fm->tree('public', null);
        $content = $this->fm->content('public', null); #disk, path
        //return dd($content);
    }

    public function ajaxSelectDisk(Request $request){
        return response()->json(
            $this->fm->tree(
                $request->disk,
                $request->path
            )
        );
        $tree = $this->fm->tree('public', null);

    }

    private function getDiskList(){
        // disk list
        foreach ($this->configRepository->getDiskList() as $disk) {
            if (array_key_exists($disk, config('filesystems.disks'))) {
                $config['disks'][$disk] = Arr::only(
                    config('filesystems.disks')[$disk], ['driver']
                );
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return view('cemas::admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $this->validate($request, [
			'title' => 'required',
            'published' => 'required',
			'url' => 'required',
        ]);

        $image_name="default.jpeg";
        if ($request->file('file')) {
            $file = $request->file('file');
            $tujuan_upload = 'img/post/thumbnail';
            $image_name= time().'.'.$file->getClientOriginalExtension();

          // upload file
          $file->move($tujuan_upload,$image_name);
          //$pic_name=$file->getClientOriginalName();
        }
            Post::create([
                'title' => $request->title,
                'published' => $request->published,
                'url' => $request->url,
                'content' => $request->description_text,
                'thumbnail_img' => $image_name
            ]);



        return redirect()->route('admin.post.index')->with('status','Article Success to Added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post,Request $request)
    {
        return view('cemas::admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post,Request $request)
    {

        return view('cemas::admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {

        $this->validate($request, [
			'title' => 'required',
            'published' => 'required',
			'url' => 'required',
        ]);

        $image_name="default.jpeg";
        if ($request->file('file') && $request->pic_indicator == 'yes') {
            $file = $request->file('file');
            $tujuan_upload = 'img/post/thumbnail';
            $image_name= time().'.'.$file->getClientOriginalExtension();

          // upload file
          $file->move($tujuan_upload,$image_name);
          //$pic_name=$file->getClientOriginalName();
          Post::where('id',$post->id)
          ->update([
              'thumbnail_img' => $image_name,
          ]);
        }

        Post::where('id',$post->id)
            ->update([
                'title' => $request->title,
                'published' => $request->published,
                'url' => $request->url,
                'content' => $request->description_text
            ]);
        return redirect()->route('admin.post.index')->with('status','Article Success to Update!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Post::destroy($post->id);
        return redirect('/ia-admin/post')->with('status','Post Has Been Deleted!');
    }
}
