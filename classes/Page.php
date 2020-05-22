<?php 
    abstract class Page{
        public $_database;

        public function __construct(){
            $dsn = "mysql:host=localhost;dbname=kolekcija";
            $user = "root";
            $pass = "";
            $this->_database = new PDO($dsn, $user, $pass, null);
        }

        public function Display($title){
            print('<!DOCTYPE html>');
            print('<html lang="hr">');

            print($this->GetHead($title));

            print('<body>');

            print('<nav class="navbar justify-content-center">');
            print($this->GetNavigation());
            print('</nav>');
            
            print('<div class="container">');
            print($this->GetContent());
            print('</div>');
            print('</body>');
            print('</html>');
        }

        public function BackToLanding(){
            header("Location: index.php");
        }
        
        private function GetHead($title){
            $output = '';
            $output .= '<head>';
            $output .= '<meta charset="utf-8">';
            $output .= '<title>'.$title.'</title>';
            $output .= '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">';				
            $output .= '<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>';
            $output .= '<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>';
            $output .= '<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>';
            $output .= '</head>';

            return $output;
        }

        private function GetNavigation(){
            $abeceda = range('A', 'Z');
            
            $output = "";
            $output .= "<div class='btn-toolbar justify-content-center'>";
            $output .= '<div class="btn-group mr-2" role="group">';
            foreach($abeceda as $slovo){
                $output .= "<a href='index.php?sl=$slovo' class='btn btn-secondary'>$slovo</a>";
            }
            $output .= "</div>";
            $output .= "</div>";
            return $output;
        }

        abstract protected function GetContent();
    }
?>