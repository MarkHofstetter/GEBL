<?php

class Application_Model_DbTable_GooglePoints extends Zend_Db_Table_Abstract {

    protected $_name = 'GOOGLE_POINTS';

    public function addPoint($cat, $name, $lat, $lng) {



        $data = array(
            'G_P_CAT' => $cat,
            'G_P_NAME' => $name,
            'G_P_LAT' => $lat,
            'G_P_LNG' => $lng
        );

        $this->insert($data);
    }

    public function deletePoint($id) {

        $this->delete('G_P_ID =' . (int) $id);
    }

    function decimal2degree($decimal_coord="",$latorlon="")
{
//121.135
//degrees=121
//minutes=.135*60=(8).1
//seconds=.1*60=(6)
//121?8?6"
$decpos=strpos($decimal_coord,'.');
$whole_part=substr($decimal_coord,0,$decpos);
$decimal_part=abs($decimal_coord-$whole_part);
$minutes=intval($decimal_part*60);
$seconds=intval((($decimal_part*60)-$minutes)*60);
if ($latorlon=='LAT')
        {if ($whole_part<0)
                {
                $whole_part=($whole_part*(-1));
                $L='S';
                }
        else
                {
                $L='N';
                }
        }//end if
else
        {if($latorlon=='LON')
                {if ($whole_part<0)
                        {
                        $whole_part=($whole_part*(-1));
                        $L='W';
                        }
                else
                        {
                        $L='E';
                        }
                }//end if
        }//end if
$degree=$whole_part.'?'.$minutes.'?'.$seconds.'"';
$degree.=$L;
return $degree;
}

function degree2decimal($deg_coord="")
{
$dpos=strpos($deg_coord,'?');
$mpos=strpos($deg_coord,'?');
$spos=strpos($deg_coord,'"');
$mlen=(($mpos-$dpos)-1);
$slen=(($spos-$mpos)-1);
$direction=substr(strrev($deg_coord),0,1);
$degrees=substr($deg_coord,0,$dpos);
$minutes=substr($deg_coord,$dpos+1,$mlen);
$seconds=substr($deg_coord,$mpos+1,$slen);
$seconds=($seconds/60);
$minutes=($minutes+$seconds);
$minutes=($minutes/60);
$decimal=($degrees+$minutes);
//South latitudes and West longitudes need to return a negative result
if (($direction=="S") or ($direction=="W"))
        { $decimal=$decimal*(-1);}
return $decimal;
}

}

