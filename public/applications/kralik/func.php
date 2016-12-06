<?php
function data2array($request,$response) 
{ $arr=json_decode($request, true);
  $no = count($arr[params][outputVariables]); 
  foreach ($response->result[0] as &$value) 
    { $outputArray[0][] = $value->x;
      $outputArray[1][] = $value->y;
    }
  if ($no > 1) 
  { for ($x=2; $x<=$no; $x++) 
    { foreach ($response->result[$x-1] as &$value) 
        { $outputArray[$x][] = $value->y;
        }    
    } 
  }    
  return $outputArray;
}
?>