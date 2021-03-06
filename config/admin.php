<?php
/**
 * Created by PhpStorm.
 * User: FZS
 * Time: 2018/10/11 11:10
 */
return [
    //user
    'user_table'                            =>  'admin_users',
    'user_table_cannot_manage_ids'          =>  '1',

    //role
    'role'                                  => 'App\Models\Role',
    'role_table'                            => 'admin_roles',
    'role_user_table'                       => 'admin_role_user',
    'role_foreign_key'                      => 'role_id',
    'user_foreign_key'                      => 'user_id',
    'role_admin'                            => 'admin',
    'role_auth_page'                        =>  'errors.role',
    'role_table_cannot_manage_ids'          =>  '1',

    //permission
    'permission'                            => 'App\Models\Permission',
    'permission_table'                      => 'admin_permissions',
    'permission_role_table'                 => 'admin_permission_role',
    'permission_name'                       => 'name',
    'permission_display_name'               => 'display_name',
    'permission_controller'                 => 'controllers',
    'permission_menu_table'                 => 'admin_permission_menu',
    'permission_foreign_key'                => 'permission_id',
    'permission_table_cannot_manage_ids'    => '',

    //types
    'type'                                  => 'App\Models\Type',
    'type_table_cannot_manage_ids'          => '0',
    'type_foreign_key'                      => 'type_id',

    //games
    'game'                            => 'App\Models\Game',
    'game_type_table'                       =>'game_type',
    'game_table_cannot_manage_ids'          => '0',
    'game_foreign_key'                      => 'game_id',               

    //menu
    'menu'                                  => 'App\Models\Menu',
    'menu_table'                            => 'admin_menus',
    'menu_role_table'                       => 'admin_role_menu',
    'menu_foreign_key'                      => 'menu_id',
    'menu_table_id_key'                     => 'id',
    'menu_table_parent_id_key'              => 'parent_id',
    'menu_table_cannot_manage_ids'          =>  '1,2,3,4,5,6,7,8,12',

    //site
    'site'                            => 'App\Models\Site',
    'site_type_table'                       =>'admin_site',
    'site_table_cannot_manage_ids'          => '0',

    'db_log'                                =>  env('DB_LOG', false),
    //cache
    'admin_permissions_for_role_id'           =>'ap_id',
    //cannot del
    'cannot_del_admin_ids'          =>  '1',
    'cannot_del_admin_ids'          =>  '1',

];