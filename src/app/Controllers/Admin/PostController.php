<?php

namespace Rakadprakoso\Ceemas\app\Controllers\Admin;

use Rakadprakoso\Ceemas\app\models\Post;
use Rakadprakoso\Ceemas\app\Traits\helper;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class PostController extends Controller
{
    use helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        /*if ($request->session()->has('username')) {
            $post = Post::all();
            return view('cemas::admin.post.index', compact('post'));
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
        /*$this->validate($request, [
			'title' => 'required',
            'published' => 'required',
			'url' => 'required',
        ]);*/
        $post = new Post;
        $post->title = $request->title;
        $post->author_id = $request->author_id;
        $post->url = $request->url;
        $post->content = $request->content;
        $post->thumbnail_img = $request->thumbnail_img;
        $post->template = $request->template;
        $post->publish = $request->publish;
        $post->published_at = $request->published_at;
        $post->save();
        return redirect()->route('admin.post.index')->with('status','Post Added!');

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
    public function edit($post,Request $request)
    {
        $post = Post::where('id',$post)->first();
        return view('cemas::admin.post.create', compact('post'));
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
