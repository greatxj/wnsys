<?php
namespace App\Module\Blog\Model;

use App\Model\AppModel;
use App\Model\Common\ParentModel;

class BlogCategoryModel extends AppModel
{
    use ParentModel;
    protected $table = "blog_category";
    protected $fillable = [
        'name', 'parentid', 'parentids',
    ];
    protected $hidden = [

    ];

    static function subIds($catid){
        $cats = static::all();
        $result = [$catid];
        foreach ($cats as $cat){
            if(in_array($catid,explode(",",$cat["parentids"]))){
                $result[] = $cat["id"];
            }
        }
        return $result;
    }
    static function modelCreate($data){
        $data["parentids"] = static::createParentids($data["parentid"]);
        return static::create($data);
    }
   
   static function modelSave($catid, $cat_name, $parentid)
    {
        $cat = static::find($catid);
        $cat->parentid = $parentid;
        $cat->parentids = static::createParentids($parentid);
        $cat->name = $cat_name;
        return $cat->save();
    }

}
