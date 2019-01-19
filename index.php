<?php

$data = array_map(function($line) {
    return str_getcsv($line, ',');
}, file('wotw2019.csv', FILE_IGNORE_NEW_LINES));


$wrestlers = array();

foreach ($data as $week){
  $score = 0;
  foreach ($week as $w){
    $score++;
    $exists = false;
    foreach($wrestlers as $wrestler){
      if ($wrestler['name'] == $w){
        $wrestler['score'] += $score;
        $wrestler['appearances']++;
        if ($score == 10){
          $wrestler['wotw']++;
        }
        $wrestlers[$wrestler['name']] = $wrestler;
        $exists = true;
        break;
      }
    }
    if (!$exists){
      $wrestler = array("name"=>$w, "score"=>$score, "appearances"=>1, "wotw"=>0);
      if ($score == 10){
        $wrestler['wotw']++;
      }
      $wrestlers[$wrestler['name']] = $wrestler;
    }

  }
}

uasort($wrestlers, function($a, $b) {
    return $a['score'] < $b['score'];
});


echo '<table style=" display: inline-block; border: 1px solid; float: left; ">';
echo '<tr><th>Wrestler</th><th>Score</th><th>Appearances</th><th>WOTW</th></tr>';
foreach( $wrestlers as $wrestler )
{
    echo '<tr>';
    foreach ($wrestler as $value){
      echo '<td>'.$value.'</td>';
    }
    echo '</tr>';
}
echo '</table>';

echo '<table style=" display: inline-block; border: 1px solid; float: left; ">';
echo '<tr><th>Achievement</th><th>Wrestler</th><th>Value</th></tr>';

echo '<tr><td>Most Appearances</td><td>';
uasort($wrestlers, function($a, $b) {
    return $a['appearances'] < $b['appearances'];
});
$initVal = reset($wrestlers);
echo $initVal['name'].'</td><td>'.$initVal['appearances'].'</td></tr>';
echo '</tr>';
foreach($wrestlers as $val){
  if ($val['appearances'] < $initVal['appearances']){
    break;
  }
  if ($val['name'] != $initVal['name'])
  echo '<tr><td> </td><td>'.$val['name']."</td><td>".$val['appearances'].'</td></tr>';
}

echo '<tr><td>Most WOTW</td><td>';
uasort($wrestlers, function($a, $b) {
    return $a['wotw'] < $b['wotw'];
});
$initVal = reset($wrestlers);
echo $initVal['name'].'</td><td>'.$initVal['wotw'].'</td></tr>';
echo '</tr>';
foreach($wrestlers as $val){
  if ($val['wotw'] < $initVal['wotw']){
    break;
  }
  if ($val['name'] != $initVal['name'])
  echo '<tr><td> </td><td>'.$val['name']."</td><td>".$val['wotw'].'</td></tr>';
}

$weekNum = 1;
echo '<table style=" display: inline-block; border: 1px solid; float: left; ">';
echo '<th></th> <th>10th</th> <th>9th</th> <th>8th</th> <th>7th</th> <th>6th</th> <th>5th</th> <th>4th</th> <th>3rd</th> <th>2nd</th> <th>1st</th>';
foreach ($data as $week){
  echo '<tr>';
  echo '<td><b>'."Week $weekNum".'</b></td>';
  $weekNum++;
  foreach ($week as $wrestler){
    echo '<td>'.$wrestler.'</td>';
  }
  echo '</tr>';
}
echo '</table>';

?>
