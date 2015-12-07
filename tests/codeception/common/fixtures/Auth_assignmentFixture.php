<?php

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

/**
 * User fixture
 */
class Auth_assignmentFixture extends ActiveFixture
{
    public $modelClass = 'dektrium\rbac\models\Assignment';
    public $depends = ['tests\codeception\common\fixtures\Auth_itemFixture'];
}