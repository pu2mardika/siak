<?php if(count($rsData)>0)
    {
        echo '<ul class="list-group list-group-flush">';
        foreach($rsData as $list)
        {
            $ids = $idx;
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-center bg-transparentbg-light text-dark">
            <?php foreach($fields as $k=>$vl){
               echo $list[$k];
            }?>
            <span class="float-right">
                <?php
                    $ids = encrypt($list[$key].$strdelimeter.$idx);
                    if(isset($actions))
                    {
                        foreach($actions as $acts)
                        {
                            if($acts['extra']=="")
							{
								$act = 'onclick = "show(\''.$acts["src"].$ids.'\',\'#idviews\')"';
								$href = "javascript:";
							}else{
								$act  = $acts['extra'];
								$href = base_url().$acts['src'].$ids;
							}
							//$act="show('".$aksi['src'].$ids."','#xcontent')";
							echo '<a href="'.$href.'" '.$act.' title="'.$acts['label'].'"><i class="fa fa-'.$acts['icon'].'"></i></a> ';  
                        }
                    }
                ?>
            </span>
        </li>
       <?php
        }
        echo "</ul>";
       
    }else{
        echo "Belum ada Projek yang dipilih ";
    }
    if(isset($addAct))
    {
        $ids = encrypt($idx);
        foreach($addAct as $aksi)
        {
            $act="show('".$aksi['src'].$ids."','#xcontent')";
            $button='<a class="btn btn-'.$aksi['btn_type'].'" href="javascript:" 
            onclick="'.$act.'" title="'.$aksi['label'].'"><i class="fa fa-'.$aksi['icon'].'"></i>&nbsp;'.$aksi['label'].'</a>';
            echo $button;
        }
    }
?>