<?php
/**
 * Generates a list of robot useragent deffinitions for use with
 * $_SERVER['HTTP_USER_AGENT'] to identify robots
 *
 * Created by: Muddy_Funster @ forums.phpfreaks.com - 09/2013
 * Updated and modified by: Jessica Brown for use on DIABLOS - 07/2017
 *
 * A Huge Thank You to Psycho, Kicken and Thorpe @ forums.phpfreaks.com
 * for their help and advice.
 *
 * This links into the robotstext.org site to access thier current
 * robot list.  It then produces an array of these useragents that
 * can be used to check if a visitor is a robot or not.
 * Call: $yourVar = new getRobots();
 * Setter : $yourVar->setExclude(mixed $mixed)
 * Getter : $robotArray = $yourVar->makeBots;
 * $yourVar->exclude(mixed $mixed); - send values to be excluded.
 *         Accepts either an array of values or a single string vlaue
 * JSON output (if you want to pass to javascript): echo $yourVar;
 *
 * --------------------------------------------------------------
 * @example 1 : PHP BOT Check
 *
 * $bots = new getRobots;
 * $bots->setExclude(array("", "none", "no", "yes"));
 * $bots->makeBotList();
 * $botArray = $bots->robots;
 *
 * if(!in_array($_SERVER('HTTP_USER_AGENT'), $botArray){
 *        import_request_variables("g", "user_"); //example of something to do
 *         ...
 *         ...
 * }
 * else{
 *        echo "Bot Safe Site Visited"; //example of something to do
 *         ...
 *         ...
 * }
 * -------------------------------------------------------------
 * @example 2 : output to JSON
 *
 * $bots = new getRobots;
 * $bots->setExclude("");
 * $bots->setExclude("none");
 * $bots->setExclude("???");
 * $bots->setExclude("no");
 * $bots->setExclude("yes");
 * $bots->makeBotList();
 *
 * header("Content-type: application/json");
 * echo $bots;
 * exit;
 * -----------------------------------------------------------
 *
 * @param array $robots the array list of useragents
 * @param array $excludes array of exlusions from the bot list
 * @param string $url static url value for linking to the
 * @param string $lfPath path to generate subfolder to store cache files in
 * @param string $masterFile path to master cache file of robotstxt.org data
 * @param string $botFile path to cached bot file for qicker repeat array building
 * @param string $mdCheckFile path to md5Checksum cache to establish if cached bot file can be used
 * @param array $hashVals generated md5 values from current call
 * @param array $hashFileVals values from md5 checksum cache file use for comparison
 * @param string $output contents retrieved from robotstxt.org site
 * @return array getBots() returns array of robot user aganents
 * @return string __toString() Returns JSON string of Object{"robots":array[{"numericalKey":"useragentText"}]
 */
class getRobots{
    public $robots;
    public $excludes;
    private $url;
    private $lfPath;
    private $masterFile;
    private $botFile;
    private $mdCheckFile;
    private $hashVals;
    private $hashFileVals;
    private $output;

    public function __construct(){
        $this->url = "http://www.robotstxt.org/db/all.txt";
        $this->lfPath= substr(__FILE__,0,strripos(__FILE__,'\\')+1).'robots';
        $this->masterFile= $this->lfPath.'\\rbtList.txt';
        $this->botFile = $this->lfPath."\\allBots.txt";
        $this->mdCheckFile = $this->lfPath."\\mdHashFile.txt";
        $this->excludes[] = "Due to a deficiency in Java it's not currently possible to set the User-Agent.";
        $this->excludes[] = "Due to a deficiency in Java it's not currently possible";
        if(!is_dir($this->lfPath)){
            if(!mkdir($this->lfPath)){
                throw new RuntimeException("error creating directory! PHP must have write permissions for this folder -- $lfPath");
            }
        }
    }
    public function setExclude($mixed){
    $mixed = (array)$mixed;
    $this->excludes = array_merge($this->excludes, $mixed);
    $this->excludes = array_unique($this->excludes);
    sort($this->excludes);
    }
    public function makeBots(){
        $this->checkFile();
        $this->checkBotList();
    }
    private function checkFile(){
        if (file_exists($this->masterFile)){
            $mtime = filemtime($this->masterFile);
            $ctx = stream_context_create(array(
                'http' => array(
                    'header' => "If-modified-since: ".gmdate(DATE_RFC1123, $mtime)
                )
            ));
        }
        else {
            $ctx = stream_context_create();
        }
        $fp = fopen($this->url, 'rb', false, $ctx);
        $this->output = stream_get_contents($fp);
        $meta = stream_get_meta_data($fp);
        if (strpos($meta['wrapper_data'][0], ' 200 ') !== false){
            file_put_contents($this->masterFile, $this->output);
        }
        fclose($fp);
    }
    private function checkBotList(){
        $robots = array();
        $this->hashVals[0] = md5(implode("|",$this->excludes));
        if(!file_exists($this->mdCheckFile)){
            $fileVals = explode("\n",$this->output);
        }
        else{
            $this->hashFileVals = file($this->mdCheckFile);
            if(trim($this->hashVals[0]) == trim($this->hashFileVals[0])){
                $this->robots = file($this->botFile);

            }
            else{
                $fileVals = file($this->masterFile);
            }

        }
        if(isset($fileVals)){
            foreach ($fileVals as $line=>$text){
                if (strpos($text, "robot-useragent:") !== FALSE){
                    $robots[] = trim(substr($text,16));
                }
            }
            $filterRobs = array_diff($robots, $this->excludes);
            $filterRobs = array_unique($filterRobs);
            $this->robots = $filterRobs;
            $botOut = implode("\n", $filterRobs);
            $botHandle = fopen($this->botFile, 'w');
            fwrite($botHandle, $botOut);
            fclose($botHandle);
            $this->hashVals[1] = md5(implode("|", $filterRobs));
            $difCheck = array_diff($this->hashVals, (array)$this->hashFileVals);
            if(count($difCheck) >= 1){
                $writeback = implode("\n", $this->hashVals);
                $mdHandle = fopen($this->mdCheckFile, 'w');
                fwrite($mdHandle, $writeback);
            }
        }
    }
    public function __toString(){
        return json_encode(array('robots' => $this->robots));
    }
}
