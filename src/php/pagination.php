<?php

    $totalPages = ceil($totalRecords / $limit);
    
    $currentURL = $_SERVER['PHP_SELF'];
    $filename = basename($currentURL);
    
    if($totalPages > 1){
        $mod = $page % 10;

        $min = $mod == 0? $page - 9: ($page - $mod) + 1;
        $max = $min + 9;

        $mod1 = $totalPages % 10;
        $lastPages = $mod1 == 0? $totalPages - 10: $totalPages - $mod1;

        if ($page > 10) {
            echo '<a href="' . $filename . '" class="border"><i class="fas fa-angles-left"></i></a>';
            
            if($mod == 0){
                echo '<a href="?page=' . $page - 10 . '" class="border"><i class="fas fa-angle-left"></i></a>';
            } else{
                echo '<a href="?page=' . $page - $mod . '" class="border"><i class="fas fa-angle-left"></i></a>';
            }
        }

        if($min == 1){
            if($page == 1){
                echo '<a href="" class="current-page">1</a>';
            } else{
                echo '<a href="' . $filename . '">1</a>';
            }

            $min = 2;
        }
    
        for ($i = $min; $i <= $max; $i++) {
            if($i > $totalPages){
                break;
            }
            
            if($i == $page){
                echo '<a href="?page=' . $i . '" class="current-page">' . $i . '</a>';
            } else{
                echo '<a href="?page=' . $i . '">' . $i . '</a>';
            }
        }

        if ($page <= $lastPages) {
            if($mod == 0){
                echo '<a href="?page=' . $page + 1 . '" class="border"><i class="fas fa-angle-right"></i></a>';
            } else{
                echo '<a href="?page=' . $max + 1 . '" class="border"><i class="fas fa-angle-right"></i></a>';
            }

            echo '<a href="?page=' . $totalPages . '" class="border"><i class="fas fa-angles-right"></i></a>';
        }
    }

?>