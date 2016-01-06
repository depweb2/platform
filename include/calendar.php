<?php

function draw_calendar($month, $month2, $year) {
    // fonctions permettant d'afficher un calendrier sous forme de tableau et modifié par mes soins
    $olderr = error_reporting(0);
    /* draw table */
    $calendar = '<table class="calendar w3-border">';

    /* table headings */
    $headings = array('Dim', 'Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam');
    $months = ["Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aoùt", "Septembre", "Octobre", "Novembre", "Décembre"];
    $calendar .= '<tr><th colspan="7" class="td w3-theme-d4 w3-border">' . $months[$month - 1] . ' ' . $year . '</th></tr>';
    $calendar .= '<tr class="calendar-row">';
    foreach ($headings as $day) {
        $calendar .= "<td class='w3-border w3-theme-d3 td'>$day</td>";
    }
    $calendar .= '</tr>';

    /* days and weeks vars now ... */
    $running_day = date('w', mktime(0, 0, 0, $month, 1, $year));
    $days_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
    $days_in_this_week = 1;
    $day_counter = 0;
    $dates_array = array();
    $current_day = date("j");

    /* row for week one */
    $calendar.= '<tr class="calendar-row">';

    /* print "blank" days until the first of the current week */
    for ($x = 0; $x < $running_day; $x++):
        $calendar.= '<td class="td w3-theme-d2 w3-border"> </td>';
        $days_in_this_week++;
    endfor;

    /* keep going with days.... */
    for ($list_day = 1; $list_day <= $days_in_month; $list_day++):
        if ($list_day == $current_day) {
            $calendar.= '<td class="td w3-theme-d4 w3-border">';
        } else {
            $calendar.= '<td class="td w3-theme-d2 w3-border">';
        }
        /* add in the day number */
        $calendar.= '<div class="day-number">' . $list_day . '</div>';

        /** QUERY THE DATABASE FOR AN ENTRY FOR THIS DAY !!  IF MATCHES FOUND, PRINT THEM !! * */
        $sqlday = $list_day;
        if ($list_day < 10) {
            $sqlday = "0$list_day";
        }
        error_reporting($olderr);
        $odbc = odbc_connect("depweb", "user", "user");
        $result1 = odbc_exec($odbc, "SELECT * FROM evenements WHERE evenements.date_ev = '$year-$month2-$sqlday';");
        odbc_fetch_row($result1, 0);
        $calendar .= "<span class='cal-tooltip'>";
        while (odbc_fetch_row($result1)) {
            $nev = utf8_encode(odbc_result($result1, "nom_evenement"));
            $desev = utf8_encode(odbc_result($result1, "des_evenement"));
            $calendar .= "<b>$nev</b><br>$desev<br>";
        }
        $calendar .= "</span>";
        $olderr = error_reporting(0);
        $calendar.= '</td>';
        if ($running_day == 6):
            $calendar.= '</tr>';
            if (($day_counter + 1) != $days_in_month):
                $calendar.= '<tr class="calendar-row">';
            endif;
            $running_day = -1;
            $days_in_this_week = 0;
        endif;
        $days_in_this_week++;
        $running_day++;
        $day_counter++;
    endfor;

    /* finish the rest of the days in the week */
    if ($days_in_this_week < 8):
        for ($x = 1; $x <= (8 - $days_in_this_week); $x++):
            $calendar.= '<td class="td w3-theme-d2 w3-border"> </td>';
        endfor;
    endif;

    /* final row */
    $calendar.= '</tr>';

    /* end the table */
    $calendar.= '</table>';

    /* all done, return result */
    error_reporting($olderr);
    return $calendar;
}
