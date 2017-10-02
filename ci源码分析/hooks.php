<?php
/**
 * Created by PhpStorm.
 * User: kok
 * Date: 2017/10/2
 * Time: 18:34
钩子 - 扩展框架核心
CodeIgniter的Hooks功能提供了一种手段来挖掘和修改框架的内部工作，而不会攻击核心文件。当CodeIgniter运行时，它遵循特定的执行过程，如“ 应用程序流程”页面所示。但是，可能有些情况下，您希望在执行过程中的特定阶段执行某些操作。例如，您可能希望在控制器加载之前或之后运行脚本，或者您可能希望在其他位置触发您自己的脚本之一。

启用挂钩
通过在application / config / config.php文件中设置以下项目，可以全局启用/禁用挂钩功能：

$ config [ 'enable_hooks' ]  =  TRUE ;
定钩子
钩子在application / config / hooks.php文件中定义。每个钩子都被指定为具有这个原型的数组：

$ hook [ 'pre_controller' ]  =  array （
'class'     =>  'MyClass' ，
'function'  =>  'Myfunction' ，
'filename'  =>  'Myclass.php' ，
'filepath'  =>  'hooks' ，
'params '    =>  array （'beer' ， 'wine' ， 'snacks' ）
）;
笔记：

数组索引与要使用的特定挂钩点的名称相关。在上面的例子中，钩点是pre_controller。钩点的列表如下。应在关联钩子数组中定义以下项目：

class您要调用的类的名称。如果您喜欢使用过程函数而不是类，请将此项留空。
function您要调用的函数（或方法）名称。
filename包含你的类/函数的文件名。
filepath包含脚本的目录的名称。注意：您的脚本必须位于应用程序/ 目录中的目录中，因此文件路径是相对于该目录。例如，如果您的脚本位于application / hooks /中，那么您只需使用“hooks”作为文件路径。如果您的脚本位于 application / hooks / utilities /中，您将使用“hooks / utilities”作为文件路径。没有尾部斜杠。
params您希望传递给脚本的任何参数。此项目是可选的。
您还可以使用lambda / anoymous函数（或闭包）作为钩子，具有更简单的语法：

$ hook [ 'post_controller' ]  =  function （）
{
/ *在这里做某事* /
};
多个呼叫到同一个钩子
如果要使用与多个脚本相同的钩子点，只需使您的数组声明成为多维的，如下所示：

$钩[ 'pre_controller' ] []  =  阵列（
'类'     =>  'MyClass的' ，
'功能'  =>  '的MyMethod' ，
'文件名'  =>  'Myclass.php' ，
'文件路径'  =>  '钩' ，
'params'    =>  array （'beer' ， 'wine' ， 'snacks' ）
）;

$钩[ 'pre_controller' ] []  =  阵列（
'类'     =>  'MyOtherClass' ，
'功能'  =>  'MyOtherMethod' ，
'文件名'  =>  'Myotherclass.php' ，
'文件路径'  =>  '钩' ，
'params'    =>  array （'red' ， 'yellow' ， 'blue' ）
）;
注意每个数组索引后的括号：

$ hook [ 'pre_controller' ] []
这允许您与多个脚本具有相同的钩点。您定义数组的顺序将是执行顺序。

钩点
以下是可用挂钩点的列表。

pre_system 在系统执行期间很早就调用。此时只有基准和挂钩类已加载。没有发生路由或其他进程。
pre_controller 在您的任何控制器被调用之前立即调用。所有基类，路由和安全检查都已完成。
post_controller_constructor 在您的控制器实例化之后，但在任何方法调用发生之前立即调用。
post_controller 在控制器完全执行后立即调用。
display_override 覆盖在_display()系统执行结束时用于将完成的页面发送到Web浏览器的方法。这允许您使用自己的显示方法。请注意，您将需要引用CI超级对象，然后通过调用可以使用完成的数据 。$this->CI =& get_instance()$this->CI->output->get_output()
cache_override 使您能够调用自己的方法而不是输出库中的_display_cache() 方法。这允许您使用自己的缓存显示机制。
post_system 在最终呈现的页面发送到浏览器之后调用，在完成的数据发送到浏览器之后，系统执行结束时。*/
<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2017, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2017, British Columbia Institute of Technology (http://bcit.ca/)
 * @license	http://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hooks Class
 *
 * Provides a mechanism to extend the base system without hacking.
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/general/hooks.html
 */
class CI_Hooks {

    /**
     * Determines whether hooks are enabled
     *
     * @var	bool
     */
    public $enabled = FALSE;

    /**
     * List of all hooks set in config/hooks.php
     *
     * @var	array
     */
    public $hooks =	array();

    /**
     * Array with class objects to use hooks methods
     *
     * @var array
     */
    protected $_objects = array();

    /**
     * In progress flag
     *
     * Determines whether hook is in progress, used to prevent infinte loops
     *
     * @var	bool
     */
    protected $_in_progress = FALSE;

    /**
     * Class constructor
     *
     */
    public function __construct()
    {
        $CFG =& load_class('Config', 'core');
        log_message('info', 'Hooks Class Initialized');

        // If hooks are not enabled in the config file
        // there is nothing else to do
        if ($CFG->item('enable_hooks') === FALSE)
        {
            return;
        }

        // Grab the "hooks" definition file.
        if (file_exists(APPPATH.'config/hooks.php'))
        {
            include(APPPATH.'config/hooks.php');
        }

        if (file_exists(APPPATH.'config/'.ENVIRONMENT.'/hooks.php'))
        {
            include(APPPATH.'config/'.ENVIRONMENT.'/hooks.php');
        }

        // If there are no hooks, we're done.
        if ( ! isset($hook) OR ! is_array($hook))
        {
            return;
        }

        $this->hooks =& $hook;
        $this->enabled = TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Call Hook
     *
     * Calls a particular hook. Called by CodeIgniter.php.
     *
     * @uses	CI_Hooks::_run_hook()
     *
     * @param	string	$which	Hook name
     * @return	bool	TRUE on success or FALSE on failure
     */
    public function call_hook($which = '')
    {
        if ( ! $this->enabled OR ! isset($this->hooks[$which]))
        {
            return FALSE;
        }

        if (is_array($this->hooks[$which]) && ! isset($this->hooks[$which]['function']))
        {
            foreach ($this->hooks[$which] as $val)
            {
                $this->_run_hook($val);
            }
        }
        else
        {
            $this->_run_hook($this->hooks[$which]);
        }

        return TRUE;
    }

    // --------------------------------------------------------------------

    /**
     * Run Hook
     *
     * Runs a particular hook
     *
     * @param	array	$data	Hook details
     * @return	bool	TRUE on success or FALSE on failure
     */
    protected function _run_hook($data)
    {
        // Closures/lambda functions and array($object, 'method') callables
        if (is_callable($data))
        {
            is_array($data)
                ? $data[0]->{$data[1]}()
                : $data();

            return TRUE;
        }
        elseif ( ! is_array($data))
        {
            return FALSE;
        }

        // -----------------------------------
        // Safety - Prevents run-away loops
        // -----------------------------------

        // If the script being called happens to have the same
        // hook call within it a loop can happen
        if ($this->_in_progress === TRUE)
        {
            return;
        }

        // -----------------------------------
        // Set file path
        // -----------------------------------

        if ( ! isset($data['filepath'], $data['filename']))
        {
            return FALSE;
        }

        $filepath = APPPATH.$data['filepath'].'/'.$data['filename'];

        if ( ! file_exists($filepath))
        {
            return FALSE;
        }

        // Determine and class and/or function names
        $class		= empty($data['class']) ? FALSE : $data['class'];
        $function	= empty($data['function']) ? FALSE : $data['function'];
        $params		= isset($data['params']) ? $data['params'] : '';

        if (empty($function))
        {
            return FALSE;
        }

        // Set the _in_progress flag
        $this->_in_progress = TRUE;

        // Call the requested class and/or function
        if ($class !== FALSE)
        {
            // The object is stored?
            if (isset($this->_objects[$class]))
            {
                if (method_exists($this->_objects[$class], $function))
                {
                    $this->_objects[$class]->$function($params);
                }
                else
                {
                    return $this->_in_progress = FALSE;
                }
            }
            else
            {
                class_exists($class, FALSE) OR require_once($filepath);

                if ( ! class_exists($class, FALSE) OR ! method_exists($class, $function))
                {
                    return $this->_in_progress = FALSE;
                }

                // Store the object and execute the method
                $this->_objects[$class] = new $class();
                $this->_objects[$class]->$function($params);
            }
        }
        else
        {
            function_exists($function) OR require_once($filepath);

            if ( ! function_exists($function))
            {
                return $this->_in_progress = FALSE;
            }

            $function($params);
        }

        $this->_in_progress = FALSE;
        return TRUE;
    }

}

