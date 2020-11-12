<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Http\Controllers;

use App\Http\Controllers\Controller;
use Goodcatch\Modules\Laravel\Http\Requests\ModuleRequest;
use Goodcatch\Modules\Laravel\Repository\ModuleRepository;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ModuleController extends Controller
{
    protected $formNames = ['name', 'alias', 'description', 'priority', 'version', 'path', 'type', 'sort', 'status'];

    public function __construct ()
    {
        parent::__construct ();

        $this->breadcrumb [] = ['title' => '系统模块列表', 'url' => route ('admin::m.goodcatch.module.index')];
    }

    /**
     * 系统模块管理
     *
     */
    public function index ()
    {
        $this->breadcrumb [] = ['title' => '系统模块列表', 'url' => ''];
        return view ('goodcatch::admin.module.index', [
            'breadcrumb' => $this->breadcrumb,
            'modules' => app('modules') ? app('modules')->allEnabled() : []
            ]);
    }

    /**
     * 系统模块管理-系统模块列表数据接口
     *
     * @param Request $request
     * @return array
     */
    public function list (Request $request)
    {
        $perPage = (int) $request->get ('limit', 50);
        $this->formNames [] = 'created_at';
        $condition = $request->only ($this->formNames);
        if (isset ($condition ['group'])) {
            $condition ['group'] = ['=', $condition['group']];
        }

        $data = ModuleRepository::list ($perPage, $condition);

        return $data;
    }

    /**
     * 系统模块管理-新增系统模块
     *
     */
    public function create()
    {
        $this->breadcrumb [] = ['title' => '新增系统模块', 'url' => ''];
        return view ('goodcatch::admin.module.add', ['breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 系统模块管理-保存系统模块
     *
     * @param ModuleRequest $request
     * @return array
     */
    public function save(ModuleRequest $request)
    {
        try {
            ModuleRepository::add ($request->only ($this->formNames));
            return [
                'code' => 0,
                'msg' => '新增成功',
                'redirect' => true
            ];
        } catch (QueryException $e) {
            return [
                'code' => 1,
                'msg' => '新增失败：' . (Str::contains ($e->getMessage (), 'Duplicate entry') ? '当前系统模块已存在' : '其它错误'),
                'redirect' => false
            ];
        }
    }

    /**
     * 系统模块管理-编辑系统模块
     *
     * @param int $id
     * @return View
     */
    public function edit($id)
    {
        $this->breadcrumb [] = ['title' => '编辑系统模块', 'url' => ''];

        $model = ModuleRepository::find ($id);
        return view ('goodcatch::admin.module.add', ['id' => $id, 'model' => $model, 'breadcrumb' => $this->breadcrumb]);
    }

    /**
     * 系统模块管理-更新系统模块
     *
     * @param ModuleRequest $request
     * @param int $id
     * @return array
     */
    public function update (ModuleRequest $request, $id)
    {
        $data = $request->only ($this->formNames);
        try {
            ModuleRepository::update ($id, $data);
            return [
                'code' => 0,
                'msg' => '编辑成功',
                'redirect' => true
            ];
        } catch (QueryException $e) {
            return [
                'code' => 1,
                'msg' => '编辑失败：' . (Str::contains($e->getMessage(), 'Duplicate entry') ? '当前系统模块已存在' : '其它错误'),
                'redirect' => false
            ];
        }
    }
}
