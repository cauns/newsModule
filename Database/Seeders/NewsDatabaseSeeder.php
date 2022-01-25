<?php

namespace Modules\News\Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        //insert into permissions
        $categoryPermissionKeys = [
            'browse_categories', 'read_categories', 'edit_categories', 'add_categories', 'delete_categories'
        ];
        foreach ($categoryPermissionKeys as $key) {
            $id = DB::table('permissions')->insertGetId([
                'key' => $key,
                'table_name' => 'categories',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('permission_role')->insert([
                'permission_id' => $id,
                'role_id' => 1
            ]);
        }
        $postPermissionKeys = [ 'browse_posts', 'read_posts', 'edit_posts', 'add_posts', 'delete_posts'];
        foreach ($postPermissionKeys as $key) {
           $id = DB::table('permissions')->insertGetId([
                'key' => $key,
                'table_name' => 'posts',
                'created_at' => now(),
                'updated_at' => now()
            ]);
            DB::table('permission_role')->insert([
                'permission_id' => $id,
                'role_id' => 1
            ]);
        }

        $rowsKeys = ['data_type_id', 'field', 'type', 'display_name', 'required', 'browse', 'read', 'edit', 'add', 'delete', 'details', 'order'];
        //insert into data_rows and datatype
        //category
        $idCat = DB::table('data_types')->insertGetId([
            'name' => 'categories',
            'slug' => 'categories',
            'display_name_singular' => 'Category',
            'display_name_plural' => 'Categories',
            'icon' => NULL,
            'model_name' => 'Modules\\News\\Entities\\Category',
            'policy_name' => NULL,
            'controller' => 'Modules\\News\\Http\\Controllers\\CategoryController',
            'description' => NULL,
            'generate_permissions' => 1,
            'server_side' => 0,
            'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $categoryRowsData = [
            [$idCat, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1],
            [$idCat, 'parent_id', 'select_dropdown', 'Parent Id', 0, 1, 1, 1, 1, 1, '{"default":"","null":"","options":{"":"-- None --"},"relationship":{"key":"id","label":"name"}}', 2],
            [$idCat, 'order', 'text', 'Order', 1, 1, 1, 1, 1, 1, '{"default":1}', 3],
            [$idCat, 'name', 'text', 'Name', 1, 1, 1, 1, 1, 1, '{}', 4],
            [$idCat, 'slug', 'text', 'Slug', 1, 1, 1, 1, 1, 1, '{"slugify":{"origin":"name"}}', 5],
            [$idCat, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 1, 0, 1, '{}', 6],
            [$idCat, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 7]
        ];
        $categoryRows = [];
        foreach ($categoryRowsData as  $val) {
          $categoryRows[] = array_combine($rowsKeys,$val);

        }


        DB::table('data_rows')->insert($categoryRows);
        //post
        $idPost = DB::table('data_types')->insertGetId([
            'name' => 'posts',
            'slug' => 'posts',
            'display_name_singular' => 'Post',
            'display_name_plural' => 'Posts',
            'icon' => NULL,
            'model_name' => 'Modules\\News\\Entities\\Post',
            'policy_name' => 'TCG\\Voyager\\Policies\\PostPolicy',
            'controller' => 'Modules\\News\\Http\\Controllers\\PostController',
            'description' => NULL,
            'generate_permissions' => 1,
            'server_side' => 0,
            'details' => '{"order_column":null,"order_display_column":null,"order_direction":"asc","default_search_key":null,"scope":null}',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $postRowsData = [
            [$idPost, 'id', 'text', 'Id', 1, 0, 0, 0, 0, 0, '{}', 1],
            [$idPost, 'author_id', 'text', 'Author', 1, 0, 1, 1, 0, 1, '{}', 2],
            [$idPost, 'category_id', 'text', 'Category', 0, 0, 1, 1, 1, 0, '{}', 3],
            [$idPost, 'title', 'text', 'Title', 1, 1, 1, 1, 1, 1, '{}', 4],
            [$idPost, 'seo_title', 'text', 'SEO Title', 0, 1, 1, 1, 1, 1, '{}', 5],
            [$idPost, 'excerpt', 'text_area', 'Excerpt', 0, 0, 1, 1, 1, 1, '{}', 6],
            [$idPost, 'body', 'rich_text_box', 'Body', 1, 0, 1, 1, 1, 1, '{}', 7],
            [$idPost, 'image', 'text', 'Post Image', 0, 1, 1, 1, 1, 1, '{"resize":{"width":"1000","height":"null"},"quality":"70%","upsize":true,"thumbnails":[{"name":"medium","scale":"50%"},{"name":"small","scale":"25%"},{"name":"cropped","crop":{"width":"300","height":"250"}}]}', 8],
            [$idPost, 'slug', 'text', 'Slug', 1, 0, 1, 1, 1, 1, '{"slugify":{"origin":"title","forceUpdate":true},"validation":{"rule":"unique:posts,slug"}}', 9],
            [$idPost, 'meta_description', 'text', 'Meta Description', 0, 1, 1, 1, 1, 1, '{}', 10],
            [$idPost, 'meta_keywords', 'text', 'Meta Keywords', 0, 1, 1, 1, 1, 1, '{}', 11],
            [$idPost, 'status', 'text', 'Status', 1, 1, 1, 1, 1, 1, '{"default":"DRAFT","options":{"PUBLISHED":"published","DRAFT":"draft","PENDING":"pending"}}', 12],
            [$idPost, 'featured', 'checkbox', 'Featured', 1, 1, 1, 1, 1, 1, '{}', 13],
            [$idPost, 'created_at', 'timestamp', 'Created At', 0, 1, 1, 0, 0, 0, '{}', 14],
            [$idPost, 'updated_at', 'timestamp', 'Updated At', 0, 0, 0, 0, 0, 0, '{}', 15]
        ];
        $postRows = [];
        foreach ($postRowsData as  $val) {
            $postRows[] = array_combine($rowsKeys,$val);

        }
        DB::table('data_rows')->insert($postRows);

        //insert menu
        $menu = DB::table('menus')->first();
        $idMenu = DB::table('menu_items')->insertGetId([
            'menu_id' =>$menu->id,
            'title' => 'News',
            'url' => '',
            'target' => '_self',
            'icon_class' => 'voyager-news',
            'color' => '#000000',
            'parent_id' => NULL,
            'order' => 8,
            'route' =>  'voyager.categories.index',
            'parameters' => NULL,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        $menuItemsKeys = ['menu_id', 'title', 'url', 'target', 'icon_class', 'color', 'parent_id', 'order', 'route', 'parameters','created_at','updated_at'];
        $menuItemsData = [
            [$menu->id, 'Posts', '', '_self', 'voyager-news', NULL, $idMenu, 2, 'voyager.posts.index', NULL,now(),now()],
            [$menu->id,'Categories', '', '_self', 'voyager-categories', '#000000', $idMenu, 1,  'voyager.categories.index', NULL,now(),now()]
        ];
        $menuItems = [];
        foreach ($menuItemsData as  $val) {
            $menuItems[] = array_combine($menuItemsKeys,$val);

        }
        DB::table('menu_items')->insert($menuItems);

    }
}
