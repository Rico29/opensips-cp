<?php
/*
* $Id$
* Copyright (C) 2011 OpenSIPS Project
*
* This file is part of opensips-cp, a free Web Control Panel Application for
* OpenSIPS SIP server.
*
* opensips-cp is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation; either version 2 of the License, or
* (at your option) any later version.
*
* opensips-cp is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with this program; if not, write to the Free Software
* Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

function get_types($name, $set)
{
 $filename = "../../../../config/tools/system/loadbalancer/lb_types.txt";
 $handle = fopen($filename, "r");
 while (!feof($handle))
 {
  $buffer = fgets($handle, 4096);
  $pos = strpos($buffer, " ");
  //$values[] = trim(substr($buffer, 0, $pos));
  $values[] = trim($buffer);
  //$content[] = trim(substr($buffer, $pos, strlen($buffer)));
 }
 fclose($handle);
 echo('<select name="'.$name.'" id="'.$name.'" size="1" class="dataSelect">');
 if ($name=="search_type") echo('<option value="">- all types -</option>');
 for ($i=0; $i<sizeof($values)-1; $i++)
 {
  if ($set == $values[$i]) $xtra = 'selected';
   else $xtra ='';
  if(!empty($values[$i]))
        echo('<option value="'.$values[$i].'" '.$xtra.'>'.$values[$i].'</option>');
 }
 echo('</select>');
 return;
}


?>
