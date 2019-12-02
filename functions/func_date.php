<?php
// error_reporting(E_STRICT);

/**
 *  @begin    string A date/time string that can be accepted by the DateTime constructor.
 *  @end      string A date/time string that can be accepted by the DateTime constructor.
 *  @interval string An interval specification that can be accepted by the DateInterval constructor.
 *                   Defaults to P1D
 *
 *  @return   array Array of DateTime objects for the specified date range.
 */
function dateRange($begin, $end, $interval = null)
{
    $begin = new DateTime($begin);
    $end = new DateTime($end);
    // Because DatePeriod does not include the last date specified.
    $end = $end->modify('+1 day');
    $interval = new DateInterval($interval ? $interval : 'P1D');

    return iterator_to_array(new DatePeriod($begin, $interval, $end));
}

function dateFilter(array $daysOfTheWeek)
{
    return function ($date) use ($daysOfTheWeek) {
        return in_array($date->format('l'), $daysOfTheWeek);
    };
}

// $dateRange = dateRange(SEM_START, $end_range);
// $dates = array_filter( $dateRange, dateFilter([ $arr_week_day[$week_day] ]) ); 
// $dates = array_values($dates); 

/**
 * Optional. Call array_values if you care about having holes in the keys of the array.
 * http://php.net/manual/en/function.array-filter.php#99358

 $dates = array_values($dates);
 */

/**
 * Since $dates is just an array we can do what ever we want with its values.
 */

/**
 * Convert to an array of strings.
 **/

/*
$closedDates = array_map(function ($date) {
    return $date->format('l Y-m-d');
}, $dates);

print_r($closedDates);
*/

/**
(
    [5] => Saturday 2016-02-06
    [6] => Sunday 2016-02-07
    [12] => Saturday 2016-02-13
    [13] => Sunday 2016-02-14
    [19] => Saturday 2016-02-20
    [20] => Sunday 2016-02-21
    [26] => Saturday 2016-02-27
    [27] => Sunday 2016-02-28
)
*/

/**
 * Convert to a different array.
 */

/*
$closedDates = array_map(function ($date) {
    return ['date' => $date->format('l Y-m-d')];
}, $dates);

print_r($closedDates);
*/

/**
Array
(
    [5] => Array
        (
            [date] => Saturday 2016-02-06
        )

    [6] => Array
        (
            [date] => Sunday 2016-02-07
        )

    [12] => Array
        (
            [date] => Saturday 2016-02-13
        )

    [13] => Array
        (
            [date] => Sunday 2016-02-14
        )

    [19] => Array
        (
            [date] => Saturday 2016-02-20
        )

    [20] => Array
        (
            [date] => Sunday 2016-02-21
        )

    [26] => Array
        (
            [date] => Saturday 2016-02-27
        )

    [27] => Array
        (
            [date] => Sunday 2016-02-28
        )

)
 */

/**
 * Group dates by their day of the week.
 */
/*
$closedDates = array_reduce($dates, function ($carry, $date) {
    $dayOfWeek = $date->format('l');
    $carry[$dayOfWeek][] = $date->format('Y-m-d');
    return $carry;
}, []);

print_r($closedDates);
*/

/**
Array
(
    [Saturday] => Array
        (
            [0] => 2016-02-06
            [1] => 2016-02-13
            [2] => 2016-02-20
            [3] => 2016-02-27
        )

    [Sunday] => Array
        (
            [0] => 2016-02-07
            [1] => 2016-02-14
            [2] => 2016-02-21
            [3] => 2016-02-28
        )

)
*/

/**
 * Go one step further and use generic reusable functions.
 */
function formatDate($fmt)
{
    return function ($date) use ($fmt) {
        return $date->format($fmt);
    };
}

function groupByDayOfWeek($carry, $date)
{
    $dayOfWeek = $date->format('l');
    $carry[$dayOfWeek][] = $date->format('Y-m-d');
    return $carry;
}

// print_r(array_map(formatDate('l Y-m-d'), array_filter($dateRange, dateFilter(['Monday', 'Tuesday']))));

/**
Array
(
    [0] => Monday 2016-02-01
    [1] => Tuesday 2016-02-02
    [7] => Monday 2016-02-08
    [8] => Tuesday 2016-02-09
    [14] => Monday 2016-02-15
    [15] => Tuesday 2016-02-16
    [21] => Monday 2016-02-22
    [22] => Tuesday 2016-02-23
)
 */

// print_r(array_map(formatDate('l jS Y F'), array_filter($dateRange, dateFilter(['Wednesday', 'Thursday']))));

/**
    [2] => Wednesday 3rd 2016 February
    [3] => Thursday 4th 2016 February
    [9] => Wednesday 10th 2016 February
    [10] => Thursday 11th 2016 February
    [16] => Wednesday 17th 2016 February
    [17] => Thursday 18th 2016 February
    [23] => Wednesday 24th 2016 February
    [24] => Thursday 25th 2016 February
 */

// print_r(array_reduce(array_filter($dateRange, datefilter(['Monday', 'Friday'])), 'groupByDayOfWeek', []));

/**
Array
(
    [Monday] => Array
        (
            [0] => 2016-02-01
            [1] => 2016-02-08
            [2] => 2016-02-15
            [3] => 2016-02-22
        )

    [Friday] => Array
        (
            [0] => 2016-02-05
            [1] => 2016-02-12
            [2] => 2016-02-19
            [3] => 2016-02-26
        )

)
 */

// print_r(array_reduce(array_filter($dateRange, datefilter(['Tuesday', 'Thursday'])), 'groupByDayOfWeek', []));

/**
Array
(
    [Tuesday] => Array
        (
            [0] => 2016-02-02
            [1] => 2016-02-09
            [2] => 2016-02-16
            [3] => 2016-02-23
        )

    [Thursday] => Array
        (
            [0] => 2016-02-04
            [1] => 2016-02-11
            [2] => 2016-02-18
            [3] => 2016-02-25
        )

)
*/

/**
 * For the year 2016 lets get all the days that are the 24th of each month.
 */
/*
$year = dateRange('2016-01-01', '2016-12-31');

print_r(array_map(
    function ($date) {
        return "The 24th falls on a {$date->format('l')} in the month of {$date->format('F')}";
    },
    array_filter($year, function ($date) {
        return $date->format('j') === '24';
    })
));
*/

/**
Array
(
    [23] => The 24th falls on a Sunday in the month of January
    [54] => The 24th falls on a Wednesday in the month of February
    [83] => The 24th falls on a Thursday in the month of March
    [114] => The 24th falls on a Sunday in the month of April
    [144] => The 24th falls on a Tuesday in the month of May
    [175] => The 24th falls on a Friday in the month of June
    [205] => The 24th falls on a Sunday in the month of July
    [236] => The 24th falls on a Wednesday in the month of August
    [267] => The 24th falls on a Saturday in the month of September
    [297] => The 24th falls on a Monday in the month of October
    [328] => The 24th falls on a Thursday in the month of November
    [358] => The 24th falls on a Saturday in the month of December
)
 */

/**
 * Do the above but lets make it a bit more dynamic in what days we are interested in.
 */

function daysFilter(array $days)
{
    return function ($date) use ($days) {
        return in_array($date->format('j'), $days);
    };
}

function fallsOn($date)
{
    return "The {$date->format('jS')} falls on a {$date->format('l')} in the month of {$date->format('F')}";
}


//print_r(array_map('fallsOn', array_filter($year, daysFilter(['1']))));

/**
Array
(
    [0] => The 1st falls on a Friday in the month of January
    [31] => The 1st falls on a Monday in the month of February
    [60] => The 1st falls on a Tuesday in the month of March
    [91] => The 1st falls on a Friday in the month of April
    [121] => The 1st falls on a Sunday in the month of May
    [152] => The 1st falls on a Wednesday in the month of June
    [182] => The 1st falls on a Friday in the month of July
    [213] => The 1st falls on a Monday in the month of August
    [244] => The 1st falls on a Thursday in the month of September
    [274] => The 1st falls on a Saturday in the month of October
    [305] => The 1st falls on a Tuesday in the month of November
    [335] => The 1st falls on a Thursday in the month of December
)
*/

//print_r(array_map('fallsOn', array_filter($year, daysFilter(['8', '16']))));

/**
Array
(
    [7] => The 8th falls on a Friday in the month of January
    [15] => The 16th falls on a Saturday in the month of January
    [38] => The 8th falls on a Monday in the month of February
    [46] => The 16th falls on a Tuesday in the month of February
    [67] => The 8th falls on a Tuesday in the month of March
    [75] => The 16th falls on a Wednesday in the month of March
    [98] => The 8th falls on a Friday in the month of April
    [106] => The 16th falls on a Saturday in the month of April
    [128] => The 8th falls on a Sunday in the month of May
    [136] => The 16th falls on a Monday in the month of May
    [159] => The 8th falls on a Wednesday in the month of June
    [167] => The 16th falls on a Thursday in the month of June
    [189] => The 8th falls on a Friday in the month of July
    [197] => The 16th falls on a Saturday in the month of July
    [220] => The 8th falls on a Monday in the month of August
    [228] => The 16th falls on a Tuesday in the month of August
    [251] => The 8th falls on a Thursday in the month of September
    [259] => The 16th falls on a Friday in the month of September
    [281] => The 8th falls on a Saturday in the month of October
    [289] => The 16th falls on a Sunday in the month of October
    [312] => The 8th falls on a Tuesday in the month of November
    [320] => The 16th falls on a Wednesday in the month of November
    [342] => The 8th falls on a Thursday in the month of December
    [350] => The 16th falls on a Friday in the month of December
)
*/

/**
 * Use the same range of dates with our generic functions.
 */
//$days = array_filter($year, daysFilter(['1', '8', '16', '24']));

//print_r(array_map('fallsOn', $days));

/**
Array
(
    [0] => The 1st falls on a Friday in the month of January
    [7] => The 8th falls on a Friday in the month of January
    [15] => The 16th falls on a Saturday in the month of January
    [23] => The 24th falls on a Sunday in the month of January
    [31] => The 1st falls on a Monday in the month of February
    [38] => The 8th falls on a Monday in the month of February
    [46] => The 16th falls on a Tuesday in the month of February
    [54] => The 24th falls on a Wednesday in the month of February
    [60] => The 1st falls on a Tuesday in the month of March
    [67] => The 8th falls on a Tuesday in the month of March
    [75] => The 16th falls on a Wednesday in the month of March
    [83] => The 24th falls on a Thursday in the month of March
    [91] => The 1st falls on a Friday in the month of April
    [98] => The 8th falls on a Friday in the month of April
    [106] => The 16th falls on a Saturday in the month of April
    [114] => The 24th falls on a Sunday in the month of April
    [121] => The 1st falls on a Sunday in the month of May
    [128] => The 8th falls on a Sunday in the month of May
    [136] => The 16th falls on a Monday in the month of May
    [144] => The 24th falls on a Tuesday in the month of May
    [152] => The 1st falls on a Wednesday in the month of June
    [159] => The 8th falls on a Wednesday in the month of June
    [167] => The 16th falls on a Thursday in the month of June
    [175] => The 24th falls on a Friday in the month of June
    [182] => The 1st falls on a Friday in the month of July
    [189] => The 8th falls on a Friday in the month of July
    [197] => The 16th falls on a Saturday in the month of July
    [205] => The 24th falls on a Sunday in the month of July
    [213] => The 1st falls on a Monday in the month of August
    [220] => The 8th falls on a Monday in the month of August
    [228] => The 16th falls on a Tuesday in the month of August
    [236] => The 24th falls on a Wednesday in the month of August
    [244] => The 1st falls on a Thursday in the month of September
    [251] => The 8th falls on a Thursday in the month of September
    [259] => The 16th falls on a Friday in the month of September
    [267] => The 24th falls on a Saturday in the month of September
    [274] => The 1st falls on a Saturday in the month of October
    [281] => The 8th falls on a Saturday in the month of October
    [289] => The 16th falls on a Sunday in the month of October
    [297] => The 24th falls on a Monday in the month of October
    [305] => The 1st falls on a Tuesday in the month of November
    [312] => The 8th falls on a Tuesday in the month of November
    [320] => The 16th falls on a Wednesday in the month of November
    [328] => The 24th falls on a Thursday in the month of November
    [335] => The 1st falls on a Thursday in the month of December
    [342] => The 8th falls on a Thursday in the month of December
    [350] => The 16th falls on a Friday in the month of December
    [358] => The 24th falls on a Saturday in the month of December
)
*/

// print_r(array_map(formatDate('l Y-m-d'), $days));

/**
Array
(
    [0] => Friday 2016-01-01
    [7] => Friday 2016-01-08
    [15] => Saturday 2016-01-16
    [23] => Sunday 2016-01-24
    [31] => Monday 2016-02-01
    [38] => Monday 2016-02-08
    [46] => Tuesday 2016-02-16
    [54] => Wednesday 2016-02-24
    [60] => Tuesday 2016-03-01
    [67] => Tuesday 2016-03-08
    [75] => Wednesday 2016-03-16
    [83] => Thursday 2016-03-24
    [91] => Friday 2016-04-01
    [98] => Friday 2016-04-08
    [106] => Saturday 2016-04-16
    [114] => Sunday 2016-04-24
    [121] => Sunday 2016-05-01
    [128] => Sunday 2016-05-08
    [136] => Monday 2016-05-16
    [144] => Tuesday 2016-05-24
    [152] => Wednesday 2016-06-01
    [159] => Wednesday 2016-06-08
    [167] => Thursday 2016-06-16
    [175] => Friday 2016-06-24
    [182] => Friday 2016-07-01
    [189] => Friday 2016-07-08
    [197] => Saturday 2016-07-16
    [205] => Sunday 2016-07-24
    [213] => Monday 2016-08-01
    [220] => Monday 2016-08-08
    [228] => Tuesday 2016-08-16
    [236] => Wednesday 2016-08-24
    [244] => Thursday 2016-09-01
    [251] => Thursday 2016-09-08
    [259] => Friday 2016-09-16
    [267] => Saturday 2016-09-24
    [274] => Saturday 2016-10-01
    [281] => Saturday 2016-10-08
    [289] => Sunday 2016-10-16
    [297] => Monday 2016-10-24
    [305] => Tuesday 2016-11-01
    [312] => Tuesday 2016-11-08
    [320] => Wednesday 2016-11-16
    [3

*/
?>