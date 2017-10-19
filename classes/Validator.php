<?php
class Validator {

    private $word;
    
    private $error;

    public function __construct($word)
    {
        $this->word = $word;
        $this->error = 1;
    }

    /**
     * Пустое поле
     * @return bool
     */
    public function isEmptyField(){
        return $this->word == '' ? true : false;
    }

    /**
     * Правильная ли первая буква
     * @return bool
     */
    public function isFirstLiterRight(){

        $expected_first_letter = mb_strtolower(mb_substr(trim($_SESSION['word']), -1)) == 'ь' ?
            mb_strtolower(mb_substr(trim($_SESSION['word']), -2, 1)) : mb_strtolower(mb_substr(trim($_SESSION['word']), -1));

        $first_letter = mb_strtolower(mb_substr(trim($this->word), 0, 1));
        
        if(strcmp($first_letter, $expected_first_letter) == 0){
            $this->error = 0;
            return true;
        }
        
        else {
            $this->error = 1;
            return false;
        }
        
    }

    /**
     * Не используем использованное
     * @return int|string
     */
    public function isWordUnused()
    {
        /*
        * У нас базе все использованные в игре слова у нас в базе с поднятым флагом used
        * - используем это для проверки уникальности слов
         * @TODO На самом деле по заданию нужно учитывать набор использованных слов для каждого пользователя,
         * @TODO пока используется один набор слов для всех пользователей
        */
        try {
            $sql = 'SELECT COUNT(id) FROM play_words WHERE `word` like "' . trim($this->word) . '" and `used`=1';

            if ($res = Word::$db->query($sql)) {

                if ($res->fetchColumn() == 0) {
                    $this->error = 0;
                    return 1;
                } else {
                    $this->error = 1;
                    return 0;
                }
            }
        } catch (PDOException $e) {
           return $e->getMessage();
        }

        return 0;

    }

    /**
     * Короткие слова
     * @return bool|int
     */
    public function isShorterThenThreeLetters(){
        
        if(mb_strlen($this->word) <= 3){
            $this->error = 1;
            return mb_strlen($this->word);
        }
        else{
            $this->error = 0;
            return false;
        }
    }

    /**
     * Три гласные подряд
     * @return bool
     */
    public function isThreeOrMoreVowelOrConsonantsIsInRow(){

        if(preg_match('/[еаоиуюяэыёАЕИУОЮЯЫЭЁ]{4,}/u', $this->word)) {
            $this->error = 0;
            return true;
        }

        if(preg_match('/[бвгджзклмнпрстфхчцщшъьБВГДЖЗКЛМНПРСТФХЧЦЩШЪЬ]{4,}/u', $this->word)) {
            $this->error = 0;
            return true;
        }

        else{
            $this->error = 1;
            return false;
        }

    }

    /**
     * Одни гласные
     * @return bool
     */
    public function isOnlyVowel(){

        if(preg_match('/^[еаоиуюяэыёАЕИУОЮЯЫЭЁ]*$/u', $this->word)) {
            $this->error = 0;
            return true;
        }

        else{
            $this->error = 1;
            return false;
        }
    }

    /**
     * Одни согласные
     * @return bool
     */
    public function isOnlyConsonants(){

        if(preg_match('/^[бвгджзклмнпрстфхчцщшъьБВГДЖЗКЛМНПРСТФХЧЦЩШЪЬ]*$/u', $this->word)) {
            $this->error = 0;
            return true;
        }

        else{
            $this->error = 1;
            return false;
        }
    }


    /**
     * Только символы русского алфавита
     * @return bool
     */
    public function hasNonRightSymbols(){

        if(preg_match('/[^А-Яа-яЁё]+/u', $this->word)) {
            $this->error = 0;
            return true;
        }

        else{
            $this->error = 1;
            return false;
        }
    }



    
    public function isError(){
        return $this->error;
    }

}