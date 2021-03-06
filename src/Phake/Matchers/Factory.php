<?php
/* 
 * Phake - Mocking Framework
 * 
 * Copyright (c) 2010-2012, Mike Lively <m@digitalsandwich.com>
 * All rights reserved.
 * 
 * Redistribution and use in source and binary forms, with or without
 * modification, are permitted provided that the following conditions
 * are met:
 * 
 *  *  Redistributions of source code must retain the above copyright
 *     notice, this list of conditions and the following disclaimer.
 * 
 *  *  Redistributions in binary form must reproduce the above copyright
 *     notice, this list of conditions and the following disclaimer in
 *     the documentation and/or other materials provided with the
 *     distribution.
 * 
 *  *  Neither the name of Mike Lively nor the names of his
 *     contributors may be used to endorse or promote products derived
 *     from this software without specific prior written permission.
 * 
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS
 * FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE
 * COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT,
 * INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING,
 * BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT
 * LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN
 * ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 * 
 * @category   Testing
 * @package    Phake
 * @author     Mike Lively <m@digitalsandwich.com>
 * @copyright  2010 Mike Lively <m@digitalsandwich.com>
 * @license    http://www.opensource.org/licenses/bsd-license.php  BSD License
 * @link       http://www.digitalsandwich.com/
 */

/**
 * Creates (or passes through) instances of Phake_Matchers_IArgumentMatcher using Phake's
 * translation rules
 */
class Phake_Matchers_Factory
{
    /**
     * Creates an argument matcher based on the given value.
     *
     * If the given values is already an instance of Phake_Matchers_IArgumentMatcher it is passed
     * through. If it is an instance of PHPUnit_Framework_Constraint a PHPUnit adapter is returned.
     * If it is an instance of Hamcrest_Matcher a Hamcrest adapter is returned. For everything else
     * a EqualsMatcher is returned set to the passed in value.
     *
     * @param mixed $argument
     *
     * @return Phake_Matchers_IArgumentMatcher
     */
    public function createMatcher($argument)
    {
        if ($argument instanceof Phake_Matchers_IArgumentMatcher) {
            return $argument;
        } elseif ($argument instanceof PHPUnit_Framework_Constraint) {
            return new Phake_Matchers_PHPUnitConstraintAdapter($argument);
        } elseif ($argument instanceof Hamcrest_Matcher) {
            return new Phake_Matchers_HamcrestMatcherAdapter($argument);
        } else {
            return new Phake_Matchers_EqualsMatcher($argument);
        }
    }

    /**
     * Converts an argument array into a matcher array
     *
     * @param array $arguments
     *
     * @return array of Phake_Matchers_IArgumentMatcher objects
     */
    public function createMatcherArray(array $arguments)
    {
        $matchers = array();
        foreach ($arguments as $arg) {
            $matchers[] = $this->createMatcher($arg);
        }
        return $matchers;
    }
}
