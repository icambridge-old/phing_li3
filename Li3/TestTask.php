<?php

/*
This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/>
 */


/**
 * Lithium test task for Phing.
 *
 * @author Iain Cambridge <hiThere at icambridge dot me>
 * @license Unlicense http://unlicense.org/
 */

class Li3_TestTask extends Task
{

	/**
	 * The location of the lithium app.
	 *
	 * @var string
	 */
	protected $li3Base;

	/**
	 * What tests are to be run. Based on the args send on the web interface.
	 *
	 * @var string
	 */
	protected $tests;

	/**
	 * The main entry point for the task.
	 * @return bool
	 * @throws BuildException
	 */
	public function main()
	{
		if (empty($this->li3Base)) {
			throw new BuildException('"li3Base" is required');
		}

		if (empty($this->tests)) {
			throw new BuildException('"tests" is required');
		}

		require_once($this->li3Base . '/app/config/bootstrap.php');

		if (!include_once LITHIUM_LIBRARY_PATH . '/lithium/core/Libraries.php') {
			$message = "Lithium core could not be found.  Check the value of LITHIUM_LIBRARY_PATH in ";
			$message .= __FILE__ . ".  It should point to the directory containing your ";
			$message .= "/libraries directory. " . LITHIUM_LIBRARY_PATH;
			throw new BuildException($message);
		}

		lithium\core\Libraries::add(basename(LITHIUM_APP_PATH), array(
			'default' => true,
			'path' => LITHIUM_APP_PATH
		));

		$group = ($this->tests == 'all') ? lithium\test\Group::all() : $this->tests;

		$report = lithium\test\Dispatcher::run($group);

		$stats = $report->stats();
		if (!$stats['success']) {
			throw new BuildException("Unit tests failed for {$this->tests}. {$stats['count']['passes']}/{$stats['count']['asserts']} passes. Check lithium's test suite for more information.");
		}
		return true;
	}


	public function setLi3Base($li3Base)
	{
		$li3Base = realpath($li3Base);
		if (!file_exists($li3Base)) {
			throw new BuildException('"li3Base" directory doesn\'t exist');
		}

		if (!file_exists($li3Base . '/app/config/bootstrap.php')) {
			throw new BuildException('Couldn\'t find the bootstrap');
		}
		define('LITHIUM_LIBRARY_PATH', $li3Base . '/libraries');
		define('LITHIUM_APP_PATH', $li3Base . '/app');
		$this->li3Base = $li3Base;
	}

	public function getLi3Base()
	{
		return $this->li3Base;
	}

	public function setTests($tests)
	{
		$this->tests = $tests;
	}

	public function getTests()
	{
		return $this->test;
	}
}