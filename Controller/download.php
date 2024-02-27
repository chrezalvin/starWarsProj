<?php
    require_once('../service/PeopleView.php');
    require_once('../service/PlanetView.php');
    require_once('../service/VehicleView.php');
    require_once('../service/Planet.php');
    require_once('../include/table.php');
    require_once('../include/fpdf.php');
    require_once('../include/library.php');

    class FPDF2 extends FPDF{
        function MultiCell2($w, $h, $txt, $border=0, $ln=0, $align='J', $fill=false)
        {
            // Custom Tomaz Ahlin
            if($ln == 0) {
                $current_y = $this->GetY();
                $current_x = $this->GetX();
            }

            // Output text with automatic or explicit line breaks
            $cw = &$this->CurrentFont['cw'];
            if($w==0)
                $w = $this->w-$this->rMargin-$this->x;
            $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
            $s = str_replace("\r",'',$txt);
            $nb = strlen($s);
            if($nb>0 && $s[$nb-1]=="\n")
                $nb--;
            $b = 0;
            if($border)
            {
                if($border==1)
                {
                    $border = 'LTRB';
                    $b = 'LRT';
                    $b2 = 'LR';
                }
                else
                {
                    $b2 = '';
                    if(strpos($border,'L')!==false)
                        $b2 .= 'L';
                    if(strpos($border,'R')!==false)
                        $b2 .= 'R';
                    $b = (strpos($border,'T')!==false) ? $b2.'T' : $b2;
                }
            }
            $sep = -1;
            $i = 0;
            $j = 0;
            $l = 0;
            $ns = 0;
            $nl = 1;
            while($i<$nb)
            {
                // Get next character
                $c = $s[$i];
                if($c=="\n")
                {
                    // Explicit line break
                    if($this->ws>0)
                    {
                        $this->ws = 0;
                        $this->_out('0 Tw');
                    }
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    $i++;
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $ns = 0;
                    $nl++;
                    if($border && $nl==2)
                        $b = $b2;
                    continue;
                }
                if($c==' ')
                {
                    $sep = $i;
                    $ls = $l;
                    $ns++;
                }
                $l += $cw[$c];
                if($l>$wmax)
                {
                    // Automatic line break
                    if($sep==-1)
                    {
                        if($i==$j)
                            $i++;
                        if($this->ws>0)
                        {
                            $this->ws = 0;
                            $this->_out('0 Tw');
                        }
                        $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                    }
                    else
                    {
                        if($align=='J')
                        {
                            $this->ws = ($ns>1) ?     ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                            $this->_out(sprintf('%.3F Tw',$this->ws*$this->k));
                        }
                        $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                        $i = $sep+1;
                    }
                    $sep = -1;
                    $j = $i;
                    $l = 0;
                    $ns = 0;
                    $nl++;
                    if($border && $nl==2)
                        $b = $b2;
                }
                else
                    $i++;
            }
            // Last chunk
            if($this->ws>0)
            {
                $this->ws = 0;
                $this->_out('0 Tw');
            }
            if($border && strpos($border,'B')!==false)
                $b .= 'B';
            $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
            $this->x = $this->lMargin;

            // Custom Tomaz Ahlin
            if($ln == 0) {
                $this->SetXY($current_x + $w, $current_y);
            }
        }
    }

    /**
     * @template T
     * @param T[] $arr
     * @param string[] $elements
     * @return TableElement[]
     */
    function generateTableElements(array $elements){
        $tableElements = [];
        foreach($elements as $key => $element)
            $tableElements[] = new TableElement($key, $element, "");

        return $tableElements;
    }

    function generatePdfTable(array $elements, string $title = "", ){
        $cellWidth = 20;
        $cellHeight = 3;

        $fpdf = new FPDF();
        $fpdf->AddPage();
        $fpdf->SetAutoPageBreak(true, 20);
        $fpdf->SetFont('Arial','B',16);
        $fpdf->Cell(20,20, $title);
        $fpdf->Ln();

        $fpdf->SetFont('Arial','B',8);
        // Header
        foreach(array_keys($elements) as $col)
            $fpdf->Cell($cellWidth, 10,$col,1);
        $fpdf->Ln();
         
        $fpdf->SetFont('Arial','',8);
        $startX = $fpdf->GetX();
        $trackX = $fpdf->GetX();
        $trackY = $fpdf->GetY();
        $counterNextPage = 1;
        for($i = 0; $i < count($elements[array_keys($elements)[0]]); ++$i){
            foreach($elements as $col){
                if(strlen($col[$i]) > 10)
                    $fpdf->MultiCell($cellWidth, $cellHeight * 3 / 2, $col[$i], 1);
                else
                    $fpdf->MultiCell($cellWidth, $cellHeight * 3, $col[$i], 1);
                $trackX += $cellWidth;
                $fpdf->SetXY($trackX, $trackY);
            }
            $trackY += $cellHeight * 3;
            $trackX = $startX;
            $fpdf->SetXY($trackX, $trackY);
            ++$counterNextPage;
        }

        return $fpdf->Output();

        // $fpdf = new FPDF2();
        // $fpdf->AddPage();
        // $fpdf->SetAutoPageBreak(true, 20);
        // $fpdf->SetFont('Arial','B',16);
        // $fpdf->Cell(20,20, $title);
        // $fpdf->Ln();
        // $fpdf->SetFont('Arial','',8);
        
        // $cellWidth = 17;

        // // Header
        // foreach(array_keys($elements) as $col)
        //     $fpdf->MultiCell2($cellWidth,7,$col,1);
        // $fpdf->Ln();
        // // Data
        
        // for($i = 0; $i < count($elements[array_keys($elements)[0]]); $i++){
        //     foreach($elements as $col)
        //         $fpdf->MultiCell2($cellWidth,20,$col[$i],1);
        //     $fpdf->Ln();
        // }

        // return $fpdf->Output();
    }

    $availableAs = ["pdf", "excel"];

    $pdf = new FPDF();

    $tableName = $_GET['table'] ?? null;
    $ids = null;
    $as = $_GET['as'] ?? null;

    // check if id is not null and is an array
    if(!is_null($ids)){
        if(!is_array($ids))
            throw new Exception("Invalid ids");

        foreach($ids as $id)
            if(!is_int($id))
                throw new Exception("Invalid ids");
    }

    // check if as is of the selected values
    if(!in_array($as, $availableAs))
        throw new Exception("Invalid as");

        // check if table name is of the selected values
        $availableTables = [
            "people" => TableElement::createTable(
                generateTableElements(
                    PeopleViewDatabase::generateLabeledElements(PeopleViewDatabase::get_view())
                )
            ),
            "planets" => TableElement::createTable(
                generateTableElements(
                    PlanetViewDatabase::generateLabeledElement(PlanetViewDatabase::get_view())
                )
            ),
            "vehicles" => TableElement::createTable(
                generateTableElements(
                    VehicleViewDatabase::generateLabeledElements(VehicleViewDatabase::get_view())
                )
            ),
        ];

    // check if table name is of the selected values
    if(!is_string($tableName) || !array_key_exists($tableName, $availableTables))
        throw new Exception("Invalid table name");

    $data = null;
    
    switch($as){
        case "pdf":
            $availablePdf = [
                "people" => PeopleViewDatabase::generateLabeledElements(PeopleViewDatabase::get_view()),
                "planets" => PlanetViewDatabase::generateLabeledElement(PlanetViewDatabase::get_view()),
                "vehicles" => VehicleViewDatabase::generateLabeledElements(VehicleViewDatabase::get_view()),
            ];

            switch($tableName){
                case "people":
                    $data = generatePdfTable(PeopleViewDatabase::generateLabeledElements(PeopleViewDatabase::get_view()), $tableName);
                    break;
                case "planets":
                    $data = generatePdfTable(PlanetViewDatabase::generateLabeledElement(PlanetViewDatabase::get_view()), $tableName);
                    break;
                case "vehicles":
                    $data = generatePdfTable(VehicleViewDatabase::generateLabeledElements(VehicleViewDatabase::get_view()), $tableName);
                    break;
                default:
                    break;
            }

            break;
        
        case "excel":
            // as excel
            $availableTables = [
                "people" => TableElement::createTable(
                    generateTableElements(
                        PeopleViewDatabase::generateLabeledElements(PeopleViewDatabase::get_view())
                    )
                ),
                "planets" => TableElement::createTable(
                    generateTableElements(
                        PlanetViewDatabase::generateLabeledElement(PlanetViewDatabase::get_view())
                    )
                ),
                "vehicles" => TableElement::createTable(
                    generateTableElements(
                        VehicleViewDatabase::generateLabeledElements(VehicleViewDatabase::get_view())
                    )
                ),
            ];
            $data = $availableTables[$tableName];


            header('Content-Type: application/xls');
            header('Content-Disposition: attachment; filename=download.xls');
            break;
        
        default:
            break;
    }