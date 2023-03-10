<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
{
    $news = News::join('categories_news', 'news.category_news_id', '=', 'categories_news.id')
        ->select('news.*', 'categories_news.name as category_name')
        ->whereNull('news.deleted_at')
        ->paginate(5);

    return view('admin.news.index', compact('news'));
}

   public  function them1(Request $request){

 
        $file_name = null;
        if($request->has('thumb')){
            $file = $request->thumb;
            $ext = $request->thumb->extension();
            $file_name = time().'-'.'news'. '.' .$ext;
            $file->move(public_path('upload'), $file_name);
        }
    $request->merge(['thumb' => $file_name]);
    $t= new news;
    $t->title = $_POST['title'];
    $t->summary = $_POST['summary'];
   
    $t->thumb = $file_name;
    
    $t->content= $_POST['content'];
    $t->category_news_id = $_POST['category_news_id'];
    //slug
     $t->slug = Str::slug($request->input('title'));
   
    
    


    $t->save();

    return redirect('/admin/news');


}
function them(){
    return view('admin.news.them');
}
function capnhat($id){

    $news = news::find($id);
    
    return view('admin.news.capnhat',['t'=>$news]);
  
}
function capnhat_(Request $request,$id){
    
    
    $t= news::find($id);
    $t->title = $_POST['title'];
    $t->summary = $_POST['summary'];
   
    
    $t->category_news_id = $_POST['category_news_id'];
   
        $t->slug = Str::slug($request->input('title'));
    //upload file
    if($request->has('thumb')){
        $file = $request->thumb;
        $ext = $request->thumb->extension();
        $file_name = time().'-'.'news'. '.' .$ext;
        $file->move(public_path('upload'), $file_name);
        $t->thumb = $file_name;
    }
    $t->content= $_POST['content'];

    
    //save
    $t->save();
    return redirect('/admin/news');

}
public function xoa($id)
{
    // T??m b???n ghi c?? ID t????ng ???ng
    $t = news::find($id);

    // Ki???m tra n???u kh??ng t??m th???y b???n ghi th?? tr??? v??? 404
    if (!$t) {
        abort(404);
    }

    // Th???c hi???n x??a m???m b???ng c??ch thi???t l???p gi?? tr??? deleted_at cho b???n ghi
    $t->delete();

    // Chuy???n h?????ng trang v??? danh s??ch tin t???c
    return redirect('/admin/news');
}

//xo?? nhi???u select
public function deleteMany(Request $request)
{
    $ids = $request->input('check');
    news::whereIn('id', $ids)->delete();

    return redirect()->back()->with('message', '???? xo?? th??nh c??ng ' . count($ids) . ' b??i vi???t');
}
// ph???c h???i
public function restore($id)
{
    $news = news::onlyTrashed()->find($id);
    $news->restore();

    return redirect()->back()->with('message', '???? ph???c h???i th??nh c??ng');
}
// ph???c h???i nhi???u
public function restoreMany(Request $request)
{
    $ids = $request->input('check');
    news::onlyTrashed()->whereIn('id', $ids)->restore();

    return redirect()->back()->with('message', '???? ph???c h???i th??nh c??ng ' . count($ids) . ' b??i vi???t');
}
//ph???c h???i t???t c???
public function restoreAll()
{
    news::onlyTrashed()->restore();

    return redirect()->back()->with('message', '???? ph???c h???i th??nh c??ng t???t c??? b??i vi???t');

}
// trang th??ng r??c
public function trash()
{
    $news = news::onlyTrashed()->paginate(5);

    return view('admin.news.trash', compact('news'));
}
}
    