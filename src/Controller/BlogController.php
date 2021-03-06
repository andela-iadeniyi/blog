<?php

namespace Ibonly\Blog;

use Ibonly\Blog\Menu;
use Ibonly\Blog\Content;
use Ibonly\Blog\Sub_Menu;
use Ibonly\Blog\Controller;

class BlogController extends Controller
{
    protected $menu;
    protected $content;
    protected $submenu;

    public function __construct()
    {
        $this->menu = new Menu();
        $this->content = new Content();
        $this->submenu = new Sub_Menu();
    }

    public function getMenu()
    {
        $content = $this->menu->getALL()->all();

        return $this->removeAllDash($content, 'name', 'description');
    }

    public function getAllContent()
    {
        $content = $this->content->getALL()->all();

        return $this->removeAllDash($content, 'blog_title', 'blog_content');
    }

    public function getmenuContent($name)
    {
        $id = $this->menu->where(['name' => $name])->first()->id;
        $content = $this->content->where([ 'menu_id' => $id])->all();

        return $this->removeAllDash($content, 'blog_title', 'blog_content');
    }

    public function getContent($id)
    {
        $content = $this->content->where([ 'blog_title' => $id])->first();

        return $this->removeSingleDash($content, 'blog_title', 'blog_content');
    }

    public function getRecentTitle()
    {
        $content = $this->content->getALL()->allDESC(5);

        return $this->removeAllDash($content, 'blog_title', 'blog_content');
    }

    public function getSearch($name)
    {
        $title = $this->addDashToTitle($name);
        $content = $this->content->where([ 'blog_title' => $title])->first();

        return $this->removeSingleDash($content, 'blog_title', 'blog_content');
    }
}