<?php
    require "classes/Page.php";

    class Unos extends Page{
        protected function GetContent()
        {
            $this->HandleFormData();
            $this->HandleParamsData();
            $godine = range(date('Y'), 1900);

            $zanrovi = array();
            $upit = "SELECT * FROM zanr";
            $rezultat = $this->_database->query($upit);
            while($row=$rezultat->fetch(PDO::FETCH_ASSOC)){
                $zanrovi[$row["id"]] = $row["naziv"];
            };

            $output = '';
            
            $output .= '<div class="text-center"><a href="index.php" class="btn btn-primary">Nazad</a></div>';
            $output .= '<hr>';
            $output .= '<form method="POST" enctype="multipart/form-data" class="form-horizontal">';
            $output .= '<h2 class="mx-auto col-sm-8">Dodaj novi film</h2>';
                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Naslov filma</span>';
                    $output .= '</div>';
                    $output .= '<input type="text" name="naslov" id="naslov" class="form-control" />';
                $output .= '</div>';

                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Žanr filma</span>';
                    $output .= '</div>';
                    $output .= '<select name="zanr" id="zanr" class="custom-select">';
                        foreach($zanrovi as $kljuc=>$zanr){
                            $output .= "<option value=$kljuc>$zanr</option>";
                        }
                    $output .= '</select>';
                $output .= '</div>';

                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Godina snimanja</span>';
                    $output .= '</div>';
                    $output .= '<select name="godina" id="godina" class="custom-select"> ';
                        foreach($godine as $godina){
                            $output .= "<option value=$godina>$godina</option>";
                        }
                    $output .= '</select>';
                $output .= '</div>';

                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Trajanje</span>';
                    $output .= '</div>';
                    $output .= '<input type="number" name="trajanje" id="trajanje" class="form-control" />';
                    $output .= '<div class="input-group-append">';
                        $output .= '<span class="input-group-text">min</span>';
                    $output .= '</div>';
                $output .= '</div>';

                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<div class="input-group-prepend">';
                        $output .= '<span class="input-group-text">Dodajte sliku naslovnice:</span>';
                    $output .= '</div>';
                    $output .= '<div class="custom-file">';
                        $output .= '<input type="file" name="slika" id="slika" class="custom-file-input" />';
                        $output .= '<label class="custom-file-label" for="slika">Odaberi sliku naslovnice</label>';
                    $output .= '</div>';
                $output .= '</div>';
                
                
                $output .= '<div class="mx-auto input-group input-group-sm mb-2 col-sm-8">';
                    $output .= '<input type="submit" class="btn btn-primary" name="btnSub" value="Dodaj film"/ >';
                $output .= '</div>';
            $output .= '</form>';

            $output .= '<hr>';
            
            $upit = "SELECT * FROM filmovi ORDER BY naslov ASC";
        
            $rezultat = $this->_database->query($upit);
    
            $path = "slike/";
            if(isset($_GET["action"]) && isset($_GET["id"])){
                $output .= '<form method="POST">';
            }
            $output .= '<table class="table table-bordered">';
            $output .= '<tr> 
                            <th scope="col" class="align-middle text-center">Naslovnica</th>
                            <th scope="col" class="align-middle text-center">Naslov filma</th>
                            <th scope="col" class="align-middle text-center">Godina snimanja</th>
                            <th scope="col" class="align-middle text-center">Trajanje</th>
                            <th scope="col" class="align-middle text-center">Kontrole</th>
                        <tr>';
            while($row=$rezultat->fetch(PDO::FETCH_ASSOC)){
                
                $filepath = $path.basename($row["slika"]);
                
                if((isset($_GET["action"]) && isset($_GET["id"])) && ($_GET["action"] == "uredi" && $_GET["id"] == $row["id"])){
                    $output .= '<tr scope="row">';
                    $output .= "<input type='hidden' name='id' id='id' value='{$_GET['id']}' />";
                    $output .= "<td class='align-middle text-center'><image src='{$filepath}' height='125px'></td>";
                    $output .= "<td class='align-middle text-center'><input type='text' name='naslov' id='naslov' value='{$row['naslov']}' /></td>";
                    $output .= "<td class='align-middle text-center'>";
                    $output .= '<select name="godina" id="godina" class="custom-select"> ';
                        foreach($godine as $godina){
                            if($godina == $row['godina']){
                                $output .= "<option value=$godina selected>$godina</option>";
                            } else {
                                $output .= "<option value=$godina>$godina</option>";
                            }
                        }
                    $output .= '</select></td>';
                    $output .= "<td class='align-middle text-center'><input type='number' name='trajanje' id='trajanje' value='{$row['trajanje']}' /> min</td>";
                    $output .= "<td class='align-middle text-center'>[ <a href='unos.php'> Cancel </a> ]
                    [<input type='submit' class='btn btn-link pl-1 pr-1' name='urediBtn' id='urediBtn' value='Uredi' />]</td>";
                    $output .= '</tr></form>';
                } else {
                    $output .= '<tr scope="row">';
                    $output .= "<td class='align-middle text-center'><image src='{$filepath}' height='125px'></td>";
                    $output .= "<td class='align-middle text-center'>{$row['naslov']}</td>";
                    $output .= "<td class='align-middle text-center'>{$row['godina']}</td>";
                    $output .= "<td class='align-middle text-center'>{$row['trajanje']} min</td>";
                    $output .= "<td class='align-middle text-center'>[ <a href='unos.php?action=obrisi&id={$row['id']}'>Obriši</a> ]
                    [ <a href='unos.php?action=uredi&id={$row['id']}'>Uredi</a> ]</td>";
                    $output .= '</tr>';
                }
            
            }
            
            $output .= '</table>';
            if(isset($_GET["action"]) && isset($_GET["id"])){
                $output .= '</form>';
            }
            return $output;
        }

        private function GetUploadPath(){
            $base = getcwd();
            return "$base\\slike\\";
        }

        private function HandleFormData(){
            if(isset($_POST["btnSub"])){
                $path = $this->GetUploadPath();
                $filePath = $path.basename($_FILES["slika"]["name"]);

                if(move_uploaded_file($_FILES["slika"]["tmp_name"], $filePath)){
                    $naslov = $_POST["naslov"];
                    $id_znar = $_POST["zanr"];
                    $godina = $_POST["godina"];
                    $trajanje = $_POST["trajanje"];
                    $slika = $_FILES["slika"]["name"];
                    $q = "INSERT INTO filmovi (naslov, id_zanr, godina, trajanje, slika) VALUES (:naslov, :id_zanr, :godina, :trajanje, :slika);";

                    if($stmt=$this->_database->prepare($q)){
                        $stmt->bindParam(':naslov', $naslov, PDO::PARAM_STR, 255);
                        $stmt->bindParam(':id_zanr', $id_znar, PDO::PARAM_INT);
                        $stmt->bindParam(':godina', $godina, PDO::PARAM_INT);
                        $stmt->bindParam(':trajanje', $trajanje, PDO::PARAM_INT);
                        $stmt->bindParam(':slika', $slika, PDO::PARAM_STR, 255);

                        if($stmt->execute()){
                            echo "Datoteka uspjesno dodana!";
                        }else{
                            var_dump($stmt->errorInfo());
                            echo "Izvršavanje upita nije uspjelo!";
                            unlink($filePath);
                            return;
                        }
                    }else{
                        echo "Priprema upita nije uspjela!";
                        unlink($filePath);
                        return;
                    }
                    
                }else{
                    echo "Došlo je do pogreške u pohrani datoteke na server!";
                }
            } else if (isset($_POST["urediBtn"])){
                $naslov = $_POST["naslov"];
                $id = $_POST["id"];
                $godina = $_POST["godina"];
                $trajanje = $_POST["trajanje"];
                echo $q = "UPDATE filmovi SET naslov=:naslov, godina=:godina, trajanje=:trajanje WHERE id=:id;";

                if($stmt= $this->_database->prepare($q)){
                    $stmt->bindParam(":naslov", $naslov, PDO::PARAM_STR, 255);
                    $stmt->bindParam(":godina", $godina, PDO::PARAM_INT);
                    $stmt->bindParam(":trajanje", $trajanje, PDO::PARAM_INT);
                    $stmt->bindParam(":id", $id, PDO::PARAM_INT);

                    if($stmt->execute()){
                        header("Location: unos.php");
                    }else{
                        echo "Pogreška u izvršavanju upita!";
                    }
                }else{
                    echo "Pogreška u pripremi upita!";
                }
            } else {
                return;
            }
            
            
        }

        private function HandleParamsData(){
            if(!isset($_GET["action"]) && !isset($_GET["id"])) return;
            
            $filmId = $_GET["id"];

            $q = "SELECT naslov, slika FROM filmovi WHERE id = $filmId;";

            if($_GET["action"] == "obrisi"){
                foreach($this->_database->query($q) as $row){
                    $slika = $row["slika"];
                }
    
                $path = $this->GetUploadPath().$slika;
                $q = "DELETE FROM filmovi WHERE id = $filmId";
                $this->_database->beginTransaction();
    
    
                if($this->_database->exec($q) !== 1){
                    echo "Pogreška pri brisanju datoteke";
                    $this->_database->rollBack();
                    return;
                }
    
                if(!unlink($path)){
                    echo "Pogreška pri brisanju datoteke";
                    $this->_database->rollBack();
                    return;
                }
    
                $this->_database->commit();
            } else if($_GET["action"] == "uredi"){

            }
        }
        
    }

    $site = new Unos();
    $site->Display('Kolekcija filmova | Unos');
?>