<?php
/**
 * Class Word для работы с моделью Слова,
 * реализованной в таблице БД MySQL play_words, которую можно создать запросом
 * CREATE TABLE `play_words` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `word` varchar(255) NOT NULL,
    `used` int(1) NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 */
class Word {

    public $word;
    
    public $words = [
        //'Рига', 'Астрахань', 'Нягань', 'Новосибирск', 'Москва', 'Курск'
    ];

    public static $db;

    public function __construct($db, $word='')
    {
        $this::$db = $db;
        $this->word = $word;
    }

    /**
     * Случайное слово
     * @return mixed
     */
    public function getRandWord(){

        $this->makeAllUnused();

        $this->getUnusedWords();

        $rand_id = rand(1, count($this->words)-1);

        $this->makeUsed($rand_id);

        return $this->words[$rand_id];

    }

    /**
     * Отвечает пользователю
     * @return mixed|null
     */
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

    /**
     * Неиспользованные слова
     */
    public function getUnusedWords(){

        $this->words = [];
        $q = self::$db->query('SELECT id,word FROM play_words WHERE used=0');

        // var_dump($q); exit;

        foreach ($q as $item){
            $this->words[$item['id']] = $item['word'];
        }

    }

    /**
     * Помечаем использованные слова
     * @param $id
     * @return int|string
     */
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

    /**
     * Выбрать всё
     * @return mixed
     */
    public function selectAll(){
        
        $q = self::$db->query('SELECT * FROM play_words');

        $res = $q->fetchAll();

        return $res;
        
    }

    /**
     * Удалить слово
     * @param $id
     * @return bool|string
     */
    public function deleteWord($id){

        try {
            self::$db->exec('DELETE FROM play_words WHERE id = '.$id);

        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return 1;
    }

    /**
     * Редактирует слово
     * @param $id
     * @param $new_word
     * @return int|string
     */
    public function editWord($id, $new_word){

        try {
            $sql = "UPDATE `play_words` SET `word`= :new_word WHERE `id` = :id";
            $stm = self::$db->prepare($sql);
            $stm->execute([":id" => $id, ":new_word" => $new_word]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        return 1;
    }

    /**
     * Сбрасываем флаги всех слов
     */
    private function makeAllUnused(){
        self::$db->query('UPDATE play_words SET used = 0');
    }


    /**
     * Если слова нет - сохраняем
     * @return int|string
     */
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