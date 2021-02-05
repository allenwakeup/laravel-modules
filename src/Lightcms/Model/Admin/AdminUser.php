<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Lightcms\Model\Admin;

use App\Model\Admin\AdminUser as Admin;

class AdminUser extends Admin
{

    public function isSuperAdmin ()
    {
        return in_array ($this->id, config ('light.superAdmin'));
    }
}
