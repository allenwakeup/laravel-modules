<?php
/**
 * Date: 2020/12/21 Time: 09:40
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

namespace Goodcatch\Modules\Lightcms\Http\Controllers\Admin;

use App\Events\MenuUpdated;
use App\Http\Controllers\Admin\MenuController as Controller;
use App\Http\Requests\Admin\MenuRequest;
use App\Model\Admin\Menu;
use App\Repository\Admin\MenuRepository;
use Illuminate\Database\QueryException;
use Illuminate\Routing\Exceptions\UrlGenerationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{

    const EXCLUDES_NEEDLES_URL_ENDS = ['/list', '/create', '/tree'];

    /**
     * 菜单管理-自动更新菜单
     *
     * @return array
     * @throws \ReflectionException
     */
    public function discovery ()
    {
        $addNum = 0;
        $updateNum = 0;

        $menu_home_page = Menu::findByName ('首页', 'admin');

        $m_route_pfx = 'admin::' . module_route_prefix ('.');

        $allRoutes = \collect (Route::getRoutes ()->getRoutesByName ())->each (function ($item, $k) use ($m_route_pfx) {
            if (Str::startsWith ($k, $m_route_pfx)) {
                $item->defaults ($k, $m_route_pfx . explode ('.', str_replace ($m_route_pfx, '', $k)) [0]);
            }
        });

        $modules = \collect (app ('modules') ? app ('modules')->all () : [])
            ->values ()
            ->reduce (function ($arr, $item) use ($m_route_pfx) {
                $route_pfx = $m_route_pfx . $item->getLowerName ();
                $arr [$route_pfx] = Menu::updateOrCreate ([
                    'route' => $route_pfx . '.index',
                    'route_params' => ''
                ], [
                    'name' => module_route_prefix ('-' . $item->getLowerName ()),
                    'guard_name' => 'admin',
                    'url' => '/admin/' . module_route_prefix ('/') . $item->getLowerName (),
                    'remark' => module_route_prefix ('-module'),
                    'order' => $item->get ('order', 0)
                ]);
                return $arr;
            }, \collect ([]));

        foreach ($allRoutes as $k => $v) {
            if (Str::startsWith ($k, 'admin::')) {

                // 取方法的第一行注释作为菜单的名称、分组名。格式：分组名称-菜单名称。未写分组名称，则注释直接作为菜单名称。未写注释则选用uri作为菜单名称。
                $action = explode ('@', $v->getActionName ());
                if (!method_exists ($action [0], $action [1])) {
                    continue;
                }

                $data = [];

                $reflection = new \ReflectionMethod ($action [0], $action [1]);
                $comment = trim (array_get (explode ("\n", $reflection->getDocComment ()), 1, ''), " \t\n\r\0\x0B*");
                if ($comment === '') {
                    $data ['name'] = $v->uri;
                    $data ['group'] = '';
                } else {
                    if (Str::contains ($comment, '-')) {
                        $arr = explode ('-', $comment);
                        $data ['name'] = trim ($arr [1]);
                        $data ['group'] = trim ($arr [0]);
                    } else {
                        $data ['name'] = trim ($comment);
                        $data ['group'] = '';
                    }
                }
                $data ['route'] = $k;
                $data ['guard_name'] = 'admin';
                if (in_array ('GET', $v->methods)
                    && ! empty ($v->uri)
                    && ! Str::contains ($v->uri, '{')
                    && ! Str::endsWith ($v->uri, self::EXCLUDES_NEEDLES_URL_ENDS)) {
                    $data ['status'] = Menu::STATUS_ENABLE;
                } else {
                    $data ['status'] = Menu::STATUS_DISABLE;
                }
                try {
                    $data ['url'] = route ($k, [], false);
                } catch (UrlGenerationException $e) {
                    $data['url'] = '';
                }
                try {
                    $model = MenuRepository::exist ($k);
                    if ($model) {
                        if (($model->is_lock_name == Menu::UNLOCK_NAME &&
                                ($model->name != $data ['name'] || $model->group != $data ['group'])) ||
                            ($data ['url'] != '' && $model->url != $data ['url'])) {
                            unset ($data ['status']);
                            MenuRepository::update ($model->id, $data);
                            $updateNum ++;
                        }
                    } else {
                        $data ['pid'] = $modules->has (Arr::get ($v->defaults, $k))
                            ? $modules->get (Arr::get ($v->defaults, $k))->id
                            : $menu_home_page->id;
                        MenuRepository::add ($data);
                        $addNum ++;
                    }
                } catch (QueryException $e) {
                    if ($addNum > 0 || $updateNum > 0) {
                        event(new MenuUpdated ());
                    }

                    if ($e->getCode () == 23000) {
                        return [
                            'code' => 1,
                            'msg' => "唯一性冲突：请检查菜单名称或路由名称。name: {$data ['name']} route: {$data ['route']}",
                        ];
                    } else {
                        return [
                            'code' => 2,
                            'msg' => $e->getMessage (),
                        ];
                    }
                }
            }
        }

        if ($addNum > 0 || $updateNum > 0) {
            event (new MenuUpdated ());
        }
        return [
            'code' => 0,
            'msg' => "更新成功。新增菜单数：{$addNum}，更新菜单数：{$updateNum}。",
            'redirect' => true
        ];
    }

}
