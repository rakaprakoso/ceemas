<?php

namespace Rakadprakoso\Ceemas\app\Controllers\Admin;

use Rakadprakoso\Ceemas\app\models\Post;
use Rakadprakoso\Ceemas\app\models\PostCategory;
use Rakadprakoso\Ceemas\app\Traits\helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Rakadprakoso\Ceemas\app\Controllers\CeemasGlobalDataController;
use Rakadprakoso\Ceemas\app\PostCategory as PC;
use Validator;


class PostController extends CeemasGlobalDataController
{
    use helper;
    public $PC;

    public function __construct(PC $PC)
    {
        parent::__construct();
        $this->PC = $PC;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*if ($request->session()->has('username')) {
            $post = Post::all();
            return view('ceemas::admin.post.index', compact('post'));
        }else {
            return redirect('/ia-admin');
        }*/
        //return "Raka";
        $post = Post::all();
        return view('ceemas::admin.post.index', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = $this->PC->data();
        return view('ceemas::admin.post.create')
        ->with($category);
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
        $post->published_at = $request->published_at;
        $post->save();

        //$post->categories()->detach();
        //$post->categories()->attach($request->category);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        /*$validator = Validator::make($request->all(), [
            'title' => 'required',
            'published' => 'required',
			'url' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = $validator->messages();
            //return $messages;
            //return redirect()->back()->with(
            //    'errors',(new ViewErrorBag)->put('default', $validator->getMessageBag()));
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }*/

        //return $request;

        $this->sendData($request);
        return redirect()->route('admin.post.index')->with('status','Post Added!');
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
        $category = $this->PC->data();
        return view('ceemas::admin.post.create', compact('post'))
        ->with($category);
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
        return redirect()->route('admin.post.index')->with('status','Post Updated!');

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
