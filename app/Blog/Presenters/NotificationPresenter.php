<?php 
namespace App\Blog\Presenters;

class NotificationPresenter
{
    public static function lableUp($type)
    {
        switch ($type)
        {
            case 'new_blog':
                $lable = trans('global.Here is new blog:');
                break;
            case 'new_reply':
                $lable = trans('global.Your blog have new reply:');
                break;
            case 'attention':
                $lable = trans('global.Attented blog has new reply:');
                break;
            case 'at':
                $lable = trans('global.Mention you At:');
                break;

            case 'blog_favorite':
                $lable = trans('global.Favorited your blog:');
                break;
            case 'blog_attent':
                $lable = trans('global.Attented your blog:');
                break;
            case 'blog_upvote':
                $lable = trans('global.Up Vote your blog');
                break;
            case 'reply_upvote':
                $lable = trans('global.Up Vote your reply');
                break;

            case 'blog_mark_wiki':
                $lable = trans('global.has mark your blog as wiki:');
                break;
            case 'blog_mark_excellent':
                $lable = trans('global.has recomended your blog:');
            break;

            default:
                break;
        }
        return $lable;

    }
}
