<?php
class PHP_Job
{
	public function perform()
	{
	    for($i=0;$i<10;$i++){
	        sleep(1);
	        fwrite(STDOUT,$i);
        }
//		sleep(120);
//		fwrite(STDOUT, 'Hello!');
	}
}

class PHP_WECHAT
{
    public function perform()
    {
        for($i=0;$i<3;$i++){
            sleep(1);
           // echo $i;
            fwrite(STDOUT,$i);
        }
    }
}
?>