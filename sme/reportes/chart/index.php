<?php require_once('maxChart.class.php'); ?>
         <?php
        
        $data['Jan'] = 112;
        
        $data['Feb'] = 7;
        
        $data['Marc'] = 22;
        
        $data['Apr'] = 18;
        
        $data['May'] = 2;
        
        $data['Jun'] = 15;
        
        $data['July'] = 45;
        
        $data['Aug'] = 22;
        
        $data['Sep'] = 99;
        
        $data['Oct'] = 35;
        
        $data['Nov'] = 72;
        
        $data['Dec'] = 19;
        
        $mc = new maxChart($data);
        
        $mc->displayChart('Demo chart - 1', 1, 500, 150);
        
        echo "<br/><br/>";
        
        $data1['Audi'] = 325;
        
        $data1['BMW'] = 219;
        
        $data1['Mercedes Benz'] = 450;
        
        $data1['Lexus'] = 118;
        
        $mc1 = new maxChart($data1);
        
        $mc1->displayChart('Demo chart - 2', 0, 500, 150, true);
        
        echo "<br/><br/>";
        
        $data2['Man'] = 840;
        
        $data2['Woman'] = 358;
        
        $mc2 = new maxChart($data2);
        
        echo '<div style="float:left; margin-left:20px; width:220px;">';
        
        $mc2->displayChart('Demo chart - 3', 1, 200, 150);
        
        echo '</div>';
        
        $data3['Windows'] = 55;
        
        $data3['Linux'] = 7;
        
        $data3['Mac'] = 3;
        
        $mc3 = new maxChart($data3);
        
        $mc3->displayChart('Demo chart - 4', 1, 200, 150, true);
        
        ?>
         
      </div>