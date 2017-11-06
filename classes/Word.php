<?php
/**
 * Class Word для работы с моделью Слова,
 * реализованной в таблице БД MySQL play_words, которую можно создать так
 * CREATE TABLE `play_words` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `word` varchar(255) NOT NULL,
    PRIMARY KEY (`id`)
   ) ENGINE=InnoDB DEFAULT CHARSET=utf8
 * Также мы используем таблицу many-many для привязки запросов к сессии(пользователю),
 * которую можно создать так:
 * CREATE TABLE `user_word` (
     'id' int(11) NOT NULL AUTO_INCREMENT,
     'session_id' INT(12) NOT NULL,
     'word_id' INT(8) NOT NULL,
    PRIMARY KEY (`id`)
 * ) DEFAULT CHARSET=utf8 ENGINE = INNODB'
 *
 */
class Word {

    private $word;
    private $user;
    private $session_id;
    
    public $words = [

    ];

    public static $db;

    public function __construct($db, $user=0, $word='')
    {
        $this::$db = $db;
        $this->word = $word;
        $this->user = $user;
        $this->session_id = session_id();
        $this->getWords();
    }

    /**
     * Случайное слово
     * @return mixed
     */
    public function getRandWord(){

        $rand_id = rand(1, count($this->words)-1);

        // слова с данным айдишником может и не быть

        if($this->isExistsById($rand_id)){

            $this->cacheUserWord($this->user, $rand_id);

            return $this->words[$rand_id];
        }

        else $this->getRandWord();

    }

    /**
     * Отвечает пользователю
     * @return mixed|null
     */
    public function getAnswer(){

        $last_letter = mb_substr(trim($this->word), -1) == 'ь' ? mb_substr(trim($this->word), -2, 1) : mb_substr(trim($this->word), -1);


        $this->insertWordIfNotExists();

        //return $this->getId(); exit;

        $this->cacheUserWord($this->user, $this->getId());

        $this->getUnusedWordsInSession();

        foreach ($this->words as $key => $word){
            //return $word;
            if($last_letter == mb_substr(trim(mb_strtolower($word)), 0, 1)){

                if($this->cacheUserWord($this->user, $key)) {
                    return $word;
                }
                else null;
            }
            
        }
        return null;
    }

    /**
     * Неиспользованные слова
     */
    private function getWords(){

        $this->words = [];
        $q = self::$db->query('SELECT id,word FROM play_words');

        // var_dump($q); exit;

        foreach ($q as $item){
            $this->words[$item['id']] = $item['word'];
        }

    }

    /**
     * Получаем не использованные в текущей сессии слова
     * @return string
     */
    private function getUnusedWordsInSession(){
        $this->words = [];
        try {
            $q = self::$db->query("SELECT id,word FROM play_words WHERE id NOT IN 
                                      (SELECT word_id FROM user_word WHERE session_id LIKE '".$this->session_id."')");
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        foreach ($q as $item){
            $this->words[$item['id']] = $item['word'];
        }
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

    /**
     * Привязываем слово к сессии
     * @param $user
     * @param $word
     * @return bool|string
     */
    private function cacheUserWord($user, $word){
        try {
            $sql = "INSERT INTO `user_word` (`user_id`,`word_id`, `session_id`) VALUES(:user_id,:word_id,:session_id)";
            $stm = self::$db->prepare($sql);
            $stm->execute([":user_id" => $user, ":word_id" => $word, ":session_id" => session_id()]);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
        return true;
    }

    /**
     * Получаем айдишник
     * @return mixed
     */
    private function getId(){
        $sql = 'SELECT id FROM play_words WHERE `word` like "' . $this->word . '"';

        $res = self::$db->query($sql);

        return $res->fetch(PDO::FETCH_ASSOC)['id'];

       // return $res;
    }



    private function isExistsById($id){

        $sql = "SELECT COUNT(id) FROM play_words WHERE id=$id";

        if ($res = self::$db->query($sql)) {

            if ($res->fetchColumn() == 0) {
                return false;

            }
            else return true;
        }

    }
}