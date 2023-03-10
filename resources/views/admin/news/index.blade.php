@extends('admin.appLayout.index')
@section('content')
<?php
use Illuminate\Support\Facades\DB;
?>
<form action="{{url('admin/news/xoa-nhieu')}}" method="post" enctype="multipart/form-data">
@csrf
<div class="container-fluid pt-4 px-4">
                    <div class="col-12">
                        <div class="bg-light rounded h-100 p-4">
                            <h6 class="mb-4">Quản lý tin tức</h6>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Check</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Summary</th>
                                            <th scope="col">Author</th>
                                            <th scope="col">Date</th>
                                            <th scope="col">Category</th>
                             
                                            
                                            <th scope="col">Image</th>
                                            
                                            
                                            <th scope="col">Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($news as $item)
                                    <tr>
                                        <td><input type="checkbox" name="check[]" value="{{$item->id}}"></td>
                                        <td>{{$item->title}}</td>
                                        <td>{{$item->summary}}</td>
                                        <td>author</td>
                                        <td>{{$item->created_at}}</td>
                                         <td>
                                            {{$item->category_name}}
                                         </td>
                                        
                                        <td><img src="{{asset('upload/'.$item->thumb)}}" alt="" width="100px" height="100px"></td>
                                         <td colspan="">
                                            <a href="{{url('admin/news/capnhat/'.$item->id)}}" class="btn btn-primary">Sửa</a>
                                            <a href="{{url('admin/news/xoa/'.$item->id)}}" onclick="return confirm('Bạn có chắc chắn muốn xóa không?')" class="btn btn-danger">Xóa</a>
                                             
                                        </td>
                                        
                                      
                                    </tr>
                                    <tr>
                                       
                                    </tr>
                                    @endforeach
                                    </tbody>
                                     

                                 <tfoot>
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>
                                         
                                        </td>
                                     
                                        <td>
                                           <style>
                                                  .pagination{
                                                    display: flex;
                                                    justify-content: center;
                                                  }
                                                  .pagination a{
                                                    padding: 10px;
                                                    border: 1px solid #ccc;
                                                    margin: 0 5px;
                                                    text-decoration: none;
                                                    color: #000;
                                                  }
                                                  .pagination a.active{
                                                    background: #000;
                                                    color: #fff;
                                                  }
                                           </style>
                                     <div class="pagination">
    @if ($news->currentPage() > 0)
        <a href="{{ $news->previousPageUrl() }}">Previous</a>
    @endif

    @for ($i = 1; $i <= $news->lastPage(); $i++)
        <a href="{{ $news->url($i) }}" 
           class="{{ ($news->currentPage() == $i) ? ' active' : '' }}">
           {{ $i }}
        </a>
    @endfor

    @if ($news->hasMorePages())
        <a href="{{ $news->nextPageUrl() }}">Next</a>
    @endif
</div>
                                          
                                        </td>
                                        <td>
                                           
                                    

                                            <a href="{{url('admin/news/them')}}" class="btn btn-primary">Thêm</a>
                                                  
                                            <a href="{{url('admin/news/thung-rac')}}" class="btn btn-primary">Thùng rác
                                                <?php
                                                $count = DB::table('news')->where('deleted_at','!=',null)->count();
                                                ?>
                                                ({{$count}})
                                                
                                            </a>
                                                <button type="submit" class="btn btn-danger">Xóa nhiều</button>
                                              
                                        </td>
                                    </tr>
                                 </tfoot>
                                </table>
                                
                            </div>
                        </div>
                    </div>
            
                </div>


</form>

@endsection

</form>
