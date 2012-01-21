Phing Li3
=========

A Phing task for running lithium tests.

# Usage

An example phing build file that runs just the lithium tests is below.

    <?xml version="1.0"?>
    <project name="lithium-app" default="main">
        <target name="main">
            <taskdef classname="Li3_TestTask" name="li3test" />
                <li3test li3Base="." tests="app\tests" />
        </target>
    </project>

## Params

li3Base : is the base location for lithium, it'll have the app, libraries directories in it.
tests : this is what tests you wish to run, it uses the web interfaces agruments. So "all" will run all the tests, "app\tests" will run all the ones in that namespace, etc.

## Known Issues

Since the way lithium defines it's base for for url handling you will need to mock the Request class and redefine Request::_base() to set $this->base as '/'.

# License

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