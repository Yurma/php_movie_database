<?php
    require "classes/Page.php";

    class Index extends Page{
        protected function GetContent(){

            $output = '';
            $output .= '<div class="text-center"><a href="unos.php" class="btn btn-primary">Unos</a></div>';
            $output .= '<hr class="my-4">';
            $output .= $this->HandleParamsData();

            return $output;
        }

        private function HandleParamsData(){
            if (isset($_GET["sl"])){
                $sl = $_GET["sl"];

                $upit = "";

                
                if (isset($_GET['zanr']) && $_GET['zanr'] != 0){
                    $idZanr = $_GET['zanr'];
                    $upit = "SELECT * FROM filmovi WHERE naslov LIKE '$sl%' AND id_zanr LIKE '$idZanr%' ORDER BY naslov ASC";
                }else{
                    $upit = "SELECT * FROM filmovi WHERE naslov LIKE '$sl%' ORDER BY naslov ASC";
                }

                $rezultat = $this->_database->query($upit);

                $zanrovi = array();
                $zanrovi[0] = "Svi";
                $upit2 = "SELECT * FROM zanr";
                $rezultat2 = $this->_database->query($upit2);
                while($row2=$rezultat2->fetch(PDO::FETCH_ASSOC)){
                    $zanrovi[$row2["id"]] = $row2["naziv"];
                };

                $output = '';
                $output .= '';

                $output .= '<form method="GET">';
                $output .= "<input type='hidden' name='sl' value='{$_GET['sl']}' />";
                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Filtriraj prema žanru filma</span>';
                    $output .= '</div>';
                    $output .= '<select name="zanr" id="zanr" class="custom-select">';
                        foreach($zanrovi as $kljuc=>$zanr){
                            $output .= "<option value=$kljuc>$zanr</option>";
                        }
                    $output .= '</select>';
                    $output .= '<div class="input-group-append">';
                        $output .= '<input type="submit" class="btn btn-outline-secondary" name="btnSub" value="Filtriraj"/ >';
                    $output .= '</div>';
                $output .= '</div>';
                $output .= '</form>';
        
                $path = "slike/";
                
                
                while($row=$rezultat->fetch(PDO::FETCH_ASSOC)){
                    $filepath = $path.basename($row["slika"]);
                    $output .= '<div class="card text-center shadow-sm mx-auto" style="width: 15rem;">';
                        $output .= "<div class='col mb-2 mt-2'>";
                            $output .= "<image src='{$filepath}' height='150px' class='border border-dark rounded-sm' >";
                        $output .= "</div>";
                        $output .= "<h5 class='card-title'>{$row['naslov']} ({$row['godina']})</h5>";
                        $output .= "<p class='card-text mb-2 text-muted'>Trajanje: {$row['trajanje']} min</p>";
                    $output .= '</div>';
                    $output .= '<hr class="my-4">';
                }

                return $output;
            }
        }
    }
    

    $site = new Index();
    $site->Display('Kolekcija filmova | Naslovnica');

?>