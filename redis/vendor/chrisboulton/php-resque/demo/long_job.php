<?php
class Long_PHP_Job
{
	public function perform()
	{

		//sleep(600);
        for($i=0;$i<10;$i++){
            sleep(1);
            fwrite(STDOUT,$i);
        }
	}
}
?>