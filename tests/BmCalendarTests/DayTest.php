<?php

namespace BmCalendarTests;

use BmCalendar\Day;
use BmCalendar\Month;
use BmCalendar\Year;

/**
 * Unit tests for {@see BmCalendar\Day}.
 *
 * @author Tom Oram <tom@scl.co.uk>
 */
class DayTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test getting the values back from a Day object.
     *
     * @covers BmCalendar\Day::value
     * @covers BmCalendar\Day::__construct
     * @covers BmCalendar\Day::__toString
     */
    public function testValue()
    {
        $month =  new Month(new Year(2013), Month::JANUARY);
        $day = new Day($month, 25);

        $this->assertEquals($month, $day->getMonth(), 'The month object is incorrect.');

        $this->assertEquals(25, $day->value(), 'The value of the day is incorrect.');

        $this->assertEquals('25', (string) $day, 'String representation of the day is wrong.');
    }

    /**
     * Tests that the day of the week is correctly calculated.
     *
     * @covers BmCalendar\Day::dayOfWeek
     */
    public function testDayOfWeek()
    {
        $today = new \DateTime();

        $year  = (int) $today->format('Y');
        $month = (int) $today->format('m');
        $day   = (int) $today->format('j');

        $dayOfWeek = $today->format('N');

        $dayObject = new Day(new Month(new Year($year), $month), $day);

        $this->assertEquals($dayOfWeek, $dayObject->dayOfWeek(), 'The day of the week doesn\'t match.');
    }

    /**
     * Test that states are added to a Day object correctly.
     *
     * @covers BmCalendar\Day::addState
     * @covers BmCalendar\Day::getStates
     *
     * @return void
     */
    public function testStates()
    {
        $state1 = $this->getMock('BmCalendar\DayStateInterface');
        $state2 = $this->getMock('BmCalendar\DayStateInterface');

        $state1->expects($this->any())
               ->method('uid')
               ->will($this->returnValue('A'));

        $state2->expects($this->any())
               ->method('uid')
               ->will($this->returnValue('B'));

        $day = new Day(new Month(new Year(2013), 6), 17);

        $day->addState($state1)
            ->addState($state2);

        $this->assertEquals(
            array('A' => $state1, 'B' => $state2),
            $day->getStates()
        );
    }

    /**
     * testAction
     *
     * @covers BmCalendar\Day::setAction
     * @covers BmCalendar\Day::getAction
     *
     * @return void
     */
    public function testGetSetAction()
    {
        $action = 'the_action';

        $day = new Day(new Month(new Year(2013), 6), 17);

        $result = $day->setAction($action);

        $this->assertEquals($day, $result, 'Interface is not fluent.');

        $result = $day->getAction();

        $this->assertEquals($action, $result, 'Incorrect action.');
    }

    /**
     * testAction
     *
     * @covers BmCalendar\Day::__construct
     * @covers BmCalendar\Day::getMonth
     *
     * @return void
     */
    public function testGetMonth()
    {
        $month = new Month(new Year(2013), 6);

        $day = new Day($month, 17);

        $result = $day->getMonth();

        $this->assertEquals($month, $result, 'Incorrect month.');
    }
}
