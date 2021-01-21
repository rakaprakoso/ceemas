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


class PostCategoryController extends CeemasGlobalDataController
{
    use helper;

    public $PC;

    public function __construct(PC $PC)
    {
        parent::__construct();
        $this->PC = $PC;
    }

    private function getAllData($request){
        if ($this->isCategory()) {
            $data['post_categories_L'] = PostCategory::category()->get();
            $data['post_categories_R'] = PostCategory::category()->search($request->q)->Paginate(10);
        } else{
            $data['post_categories_L'] = PostCategory::tag()->get();
            $data['post_categories_R'] = PostCategory::tag()->search($request->q)->Paginate(10);
        }
        return $data;
    }
    private function redirectCategory(){
        return $this->isCategory() ? 'admin.category.index':'admin.tag.index';
    }

    //INPUT DATA
    public function index(Request $request)
    {
        //return $this->PC->data();
        $data = $this->getAllData($request);
        return view('ceemas::admin.post_category.index')
        ->with('data',$data);
    }
    public function edit($post_category,Request $request)
    {
        $data = $this->getAllData($request);
        $post_category = PostCategory::where('id',$post_category)->first();
        return view('ceemas::admin.post_category.index')
        ->with('post_category',$post_category)
        ->with('data',$data);
    }

    //SEND DATA
    private function sendData($request, $id=null){
        $this->validate($request, [
			'name' => 'required',
			'slug' => 'required',
        ]);
        $post_category = $id == null ? New PostCategory : PostCategory::find($id);
        $post_category->name = $request->name;
        $post_category->description = $request->description;
        $post_category->slug = $request->slug;
        $post_category->parent = $request->parent;
        $post_category->isCategory = $request->isCategory;
        $post_category->save();
    }
    public function store(Request $request)
    {
        $this->sendData($request);
        return redirect()->route($this->redirectCategory())->with('status', $this->isCategory() ? 'Category Added!' :'Tag Added!');
    }
    public function update(Request $request,$category)
    {
        $this->sendData($request, $category);
        return redirect()->route($this->redirectCategory())->with('status', $this->isCategory() ? 'Category Updated!' :'Tag Updated!');
    }

    public function destroy($category)
    {
        PostCategory::destroy($category);
        return redirect()->route($this->redirectCategory())->with('status', $this->isCategory() ? 'Category Deleted!' :'Tag Deleted!');
    }
}
