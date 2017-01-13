<?php
namespace App\Module\Blog\Bll;
use App\Module\Blog\Model\BlogCategoryModel;
use App\Core\Libs\Tree;
class CategoryBll{
   static public function breadcrumb($id){
       $cat = BlogCategoryModel::find($id);
       $parents[] = ["url"=>"/","name"=>"首页","class"=>""];
       $parents = $parents + BlogCategoryModel::parents($id,false);
       $parents[] = ["url"=>"","name"=>$cat["name"],"class"=>"active"];
       return $parents;
   }
    static public function formSelect($name = "",$selected = 0){
        $select = "<select id='$name' name='$name' class='form-control'>";
        $options = BlogCategoryModel::options($selected);
        $select .=  $options;
        $select .= "</select>";
        return $select;
    }

    static public function lists()
    {
        $data = BlogCategoryModel::all()->toArray();
        foreach ($data as $item){
            $result[$item["id"]] = $item;
        }
        $str = "\$spacer<a href='/admin/blog/category/edit/\$id'>\$name</a><br>";
        $tree = new Tree();
        $tree->init($data);
        return $tree->get_tree(0,$str);
    }
}