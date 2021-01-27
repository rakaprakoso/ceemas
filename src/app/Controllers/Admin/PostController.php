<?php

namespace Rakadprakoso\Ceemas\app\Controllers\Admin;

use Rakadprakoso\Ceemas\app\models\Post;
use Rakadprakoso\Ceemas\app\models\CustomPost;
use Rakadprakoso\Ceemas\app\models\PostCategory;
use Rakadprakoso\Ceemas\app\Traits\helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Rakadprakoso\Ceemas\app\PostCategory as PC;
use Validator;
use Illuminate\Support\Facades\Storage;


class PostController extends CeemasGlobalDataController
{
    use helper;
    public $PC;

    public function __construct(PC $PC)
    {
        parent::__construct();
        $this->PC = $PC;
    }
    private function getAllData($request){
        if ($this->isPage()) {
            $data = Post::page()->search($request->q)->Paginate(10);
        } else{
            $data = Post::post()->search($request->q)->Paginate(10);
        }
        return $data;
    }
    private function redirectPage(){
        return $this->isPage() ? 'admin.page.index':'admin.post.index';
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $post = $this->getAllData($request);
        if ($this->isPage()) {
            return view('ceemas::admin.page.index')
            ->with('page',$post);
        } else{
            return view('ceemas::admin.post.index', compact('post'));
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($this->isPage()) {
            return view('ceemas::admin.page.create');
        } else{
            $category = $this->PC->data();
            return view('ceemas::admin.post.create')
            ->with($category);
        }

    }

    private function sendData($request, $id=null){
        $this->validate($request, [
			'title' => 'required',
            'published_at' => 'required',
			'url' => 'required',
        ]);
        $post = $id == null ? New Post : Post::find($id);
        $post->title = $request->title;
        $post->author_id = $request->session()->get('user_id');
        $post->url = $request->url;
        $post->content = $request->content;
        $post->thumbnail_img = $request->thumbnail_img;
        $post->template = $request->template;
        $post->publish = $request->publish;
        $post->isPage = $request->isPage;
        if ($request->codeEditor == "on") {
            $post->isCustom = "1";
        }
        $post->published_at = $request->published_at;
        $post->save();

        //$post->categories()->detach();
        //$post->categories()->attach($request->category);
        if ($this->isPage()==false) {
            //return view('ceemas::admin.page.create');
            $tags = explode(",", $request->tag[1]);
            $tags = preg_replace('!\s+!', ' ', $tags);
            foreach ($tags as $key => $value) {
                if (substr($value, 0, 1)==" ") {
                    $value = substr_replace($value, '', 0, 1);
                }
                $post_category = PostCategory::where('name',$value)->where('isCategory','!=' ,'1')->first();

                if ($post_category!=null) {
                    $tags_id[$key] = $post_category->id;
                    //$post->categories()->detach($post_category->id);
                } else {
                    $post_category = PostCategory::where('name',$value)->where('isCategory', null)->first();
                    if ($post_category!=null) {
                        $tags_id[$key] = $post_category->id;
                        //$post->categories()->detach($post_category->id);
                    } else {
                        $post_category = New PostCategory;
                        $post_category->name = $value;
                        $post_category->slug = $this->slug($value);
                        $post_category->save();
                        $tags_id[$key] = $post_category->id;
                    }
                }
            }
            $categories = array_merge($request->category,$tags_id);
            $post->categories()->sync($categories);
        }
        if ($request->codeEditor == "on") {
            $customPost = CustomPost::where('post_id',$post->id)->first();
            //return $customPost;
            $customPost = $customPost == null ? New CustomPost : CustomPost::find($customPost->id);
            $customPost->post_id = $post->id;
            $customPost->view = $request->viewFile;
            $customPost->controller = $request->controllerFile;
            $customPost->function_controller = $request->functionController;
            $customPost->save();

            Storage::disk('project')->put('resources/views/page/'.$request->viewFile.'.blade.php', $request->view_code);
            Storage::disk('project')->put('app/Http/Controllers/'.$request->controllerFile.'.php', $request->controller_code);
            Storage::disk('project')->put('routes/web.php', $request->route_code);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->sendData($request);
        if ($this->isPage()) {
            return redirect()->route('admin.page.index')->with('status','Page Added!');
        } else{
            return redirect()->route('admin.post.index')->with('status','Post Added!');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $Post,Request $request,$post)
    {
        return $post;
        return view('ceemas::admin.post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit($post,Request $request)
    {
        $post = Post::where('id',$post)->first();
        //return dd($post->custom_content);
        if ($this->isPage()) {
            if ($post->isCustom=='1') {
                $view_code = Storage::disk('project')->get('resources/views/page/'.$post->custom_content->view.'.blade.php');
                $controller_code = Storage::disk('project')->get('app/Http/Controllers/'.$post->custom_content->controller.'.php');
                $route_code = Storage::disk('project')->get('routes/web.php');
                //return $controller_code;
                return view('ceemas::admin.page.create')
                ->with('controller_code',$controller_code)
                ->with('route_code',$route_code)
                ->with('view_code',$view_code)
                ->with('page',$post);
            }
            return view('ceemas::admin.page.create')
            ->with('page',$post);
        } else{
            $category = $this->PC->data();
            return view('ceemas::admin.post.create', compact('post'))
            ->with($category);
        }


    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $post)
    {
       //return $request;

        $this->sendData($request,$post);
        //Storage::disk('project')->get('resources/views/page/index.blade.php');

        if ($this->isPage()) {
            return redirect()->route('admin.page.index')->with('status','Page Updated!');
        } else{
            return redirect()->route('admin.post.index')->with('status','Post Updated!');
        }


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy($post)
    {
        $post = Post::where('id',$post)->first();
        Post::destroy($post->id);
        if ($this->isPage()) {
            return redirect()->route('admin.page.index')->with('status','Page Deleted!');
        } else{
            return redirect()->route('admin.post.index')->with('status','Post Deleted!');
        }
    }
}
