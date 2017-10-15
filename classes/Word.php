<?php

class Word {

    public $word;
    
    public $words = [
        //'Рига', 'Астрахань', 'Нягань', 'Новосибирск', 'Москва', 'Курск'
    ];

    public static $db;

    public function __construct($word='')
    {

        $this->word = $word;

    }

    public function getRandWord(){

        $this->makeAllUnused();

        $this->getUnusedWords();

        $rand_id = rand(1, count($this->words)-1);

        $this->makeUsed($rand_id);

        return $this->words[$rand_id];

    }

    public function getAnswer(){

        $last_letter = mb_substr(trim($this->word), -1) == 'ь' ? mb_substr(trim($this->word), -2, 1) : mb_substr(trim($this->word), -1);

        $this->insertWordIfNotExists();

        //return $last_letter;
        $this->getUnusedWords();

        //var_dump($this->words);

        foreach ($this->words as $key => $word){
            //return $word;
            if($last_letter == mb_substr(trim(mb_strtolower($word)), 0, 1)){
                $this->makeUsed($key);
                return $word;
            }
            
        }
        return null;

    }

    public function getUnusedWords(){

        $this->words = [];
        $q = self::$db->query('SELECT id,word FROM play_words WHERE used=0');

        // var_dump($q); exit;

        foreach ($q as $item){
            $this->words[$item['id']] = $item['word'];
        }

    }

    public function makeUsed($id){

        try {
            $sql = "UPDATE `play_words` SET `used`=1 WHERE `id` = :id";
            $stm = self::$db->prepare($sql);
            $stm->execute([":id" => $id]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        
        return 1;

    }

    private function makeAllUnused(){
        self::$db->query('UPDATE play_words SET used = 0');
    }

    private function insertWordIfNotExists()
    {

        $sql = 'SELECT COUNT(id) FROM play_words WHERE `word` like "' . $this->word . '"';
        
        if ($res = self::$db->query($sql)) {
            
            if ($res->fetchColumn() == 0) {
                try {
                    $sql = "INSERT INTO `play_words` (`word`,`used`) VALUES(:word,:used)";
                    $stm = self::$db->prepare($sql);
                    $stm->execute([":word" => $this->word, ":used" => 1]);
                    //return 45;
                } catch (PDOException $e) {
                    return $e->getMessage();
                }
            }

            return 1;

        }

        return 0;
    }
}