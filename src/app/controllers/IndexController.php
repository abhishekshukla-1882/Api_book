<?php
// session_start();
use Phalcon\Mvc\Controller;
use Phalcon\Http\Request;

class IndexController extends Controller
{
    public function indexAction()
    {
        $request = new Request();
        if(isset($_POST['submit'])){
            $val = $this->request->getPost('val');
            // echo $val;
            $val = urlencode($val);

        }
        if($val){
        $url = "https://openlibrary.org/search.json?q=$val";
        }else{
            $val = 'fantastic';
        }
        $url = "https://openlibrary.org/search.json?q=$val";
        // $url = 'http://httpbin.org/post';
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);

        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS,
        //             "postvar1=value1&postvar2=value2&postvar3=value3");

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
 
        $book = json_decode($response)->docs;
        // echo "<pre>";
        // print_r($response);
        // die;

        $this->view->book = $book;
       

    }
    public function detailAction(){
        if(isset($_POST['sub'])){
            $val =urlencode($this->request->getPost('title'));
            // print_r( $val->full_title);
            // die;
            // https://openlibrary.org/api/books?bibkeys=ISBN:9780980200447&jscmd=details&format=json
            $url = "https://openlibrary.org/api/books?bibkeys=ISBN:$val&jscmd=details&format=json";
            //    $url ="https://openlibrary.org/search.json?q=$val&mode=ebooks&has_fulltext=true";
           $ch = curl_init();

           //grab URL and pass it to the variable.
           curl_setopt($ch, CURLOPT_URL, $url);

           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
           $response = curl_exec($ch);
        //    print_r($response,"<br>  hhhhh");
           $book = ((array)json_decode($response));
        //    echo "<pre>";
        //    print_r($book);
        //    die;
            $this->view->book = $book["ISBN:$val"];
            $this->view->val = $val;

        }
        
    }
}