<?php
use Dompdf\Options;
use Dompdf\Dompdf;

class FileGenerator{

    private $file;
    private $template;
    private $generated;

    function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Обработчик
     * @return bool
     */
    public function handler(){
        if($this->file == strstr($this->file,'xml')){

            $this->template = 'templates/post.xml';
            if($this->generateXml())
                return true;
            else return false;
        }
        elseif ($this->file == 'pdf'){
            $this->template = 'templates/user_doc.php';
            if($this->generatePdf())
                return true;
            else return false;
        }
        else return false;
    }


    /**
     * Заполняет шаблон
     * @return bool
     */
    private function fillTemplate(){

        try {
            if (file_exists($this->template))
                $this->generated = file_get_contents($this->template);
            else return false;
        } catch (Exception $e) {

            echo $e->getMessage();
            return false;
        }


        $signs = [
            'sender_from' => $_POST['sender_from'],
            'sender_to' => $_POST['sender_to'],
            'receiver_from' => $_POST['receiver_from'],
            'receiver_to' => $_POST['receiver_to'],
        ];

        try {
            foreach ($signs as $key => $value)
                $this->generated = str_replace('{' . $key . '}', $value, $this->generated);
        } catch (Exception $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }


    /**
     * Генерирует xml
     * @return bool
     */
    private function generateXml(){

        if($this->fillTemplate()) {

            $dom_xml = new DomDocument();
            $dom_xml->loadXML($this->generated);
            $path = "Stamp_tmp.xml";
            $dom_xml->save($path);


            header("Cache-control: private");
            header("Content-type: application/force-download");
            header("Content-Length: ".filesize($path));
            header("Content-Disposition: filename=".$path);
            readfile($path);

            return true;
        }

        return false;

    }

    /**
     * Генерирует pdf
     * @return bool
     */
    private function generatePdf(){

        if($this->fillTemplate()) {

            $options = new Options();
            $options->set('defaultFont', 'Courier');

            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($this->generated);


            // (Optional) Setup the paper size and orientation
            $dompdf->setPaper('A4', 'landscape');

            // Render the HTML as PDF
            $dompdf->render();

            // Output the generated PDF to Browser
            $dompdf->stream();

            return true;
        }

        return false;

    }

}