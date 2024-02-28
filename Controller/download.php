<?php
    require_once('../include/session.php');

    require_once('../service/PeopleView.php');
    require_once('../service/PlanetView.php');
    require_once('../service/VehicleView.php');
    require_once('../service/Planet.php');
    require_once('../include/table.php');
    require_once('../include/fpdf.php');
    require_once('../include/library.php');

    class PDF_MC_Table extends FPDF
{
    protected $widths;
    protected $aligns;

    function SetWidths($w)
    {
        // Set the array of column widths
        $this->widths = $w;
    }

    function SetAligns($a)
    {
        // Set the array of column alignments
        $this->aligns = $a;
    }


    protected $imageKey = '';

    public function setImageKey($key){
      $this->imageKey = $key;
    }
  
    public function Row($data){
      $nb=0;
      for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++){
          $w=$this->widths[$i];
          $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
          $x=$this->GetX();
          $y=$this->GetY();
          $this->Rect($x,$y,$w,$h);
  
          //modify functions for image 
          if(!empty($this->imageKey) && in_array($i,$this->imageKey) && !empty($data[$i])){
            $imageSize = getimagesize($data[$i]);
            $imageWidth = $imageSize[0];
            $imageHeight = $imageSize[1];
            $resolution = $imageWidth / $imageHeight;

            $ih = $h - 0.5;
            $iw = $h * $resolution - 0.5;
            $ix = $x + $w/2 - $iw/2 + 0.25;
            $iy = $y + 0.25;
            $this->MultiCell($w,5,$this->Image ($data[$i],$ix,$iy,$iw,$ih),0,$a);
          }
          else
            $this->MultiCell($w,5,$data[$i],0,$a);
          $this->SetXY($x+$w,$y);
        }
        $this->Ln($h);
      }

    function CheckPageBreak($h)
    {
        // If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        // Compute the number of lines a MultiCell of width w will take
        if(!isset($this->CurrentFont))
            $this->Error('No font has been set');
        $cw = $this->CurrentFont['cw'];
        if($w==0)
            $w = $this->w-$this->rMargin-$this->x;
        $wmax = ($w-2*$this->cMargin)*1000/$this->FontSize;
        $s = str_replace("\r",'',(string)$txt);
        $nb = strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while($i<$nb)
        {
            $c = $s[$i];
            if($c=="\n")
            {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep = $i;
            $l += $cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i = $sep+1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
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
        $keys = array_keys($elements);

        $pdfOrientation = count($keys) > 10 ? "A3" : "A4";
        $totalPdfWidth = 280;
        switch($pdfOrientation){
            case "A3":
                $totalPdfWidth = 280;
                break;
            case "A4":
                $totalPdfWidth = 190;
                break;
            default:
                break;
        }

        
        $fpdf = new PDF_MC_Table('P', 'mm', $pdfOrientation);


        $fpdf->AddPage();
        $fpdf->SetAutoPageBreak(true, 20);
        $fpdf->SetFont('Arial','B', 20);
        
        $fpdf->Cell($totalPdfWidth, 10, "$title database", 0, 1, 'C');
        $fpdf->Ln(10);
        $fpdf->SetFont('Arial','B', 12);

        $fpdf->SetWidths(array_map(fn($_) => $totalPdfWidth / count($keys), $keys));

        // header part
        $fpdf->SetAligns(array_map(fn($_) => 'C', $keys));
        $fpdf->Row($keys);

        $imageCol = array_search("image", $keys);
        if($imageCol !== false)
            $fpdf->setImageKey([$imageCol]);
        
        // data part
        $fpdf->SetFont('Arial','', 10);
        $fpdf->SetAligns(array_map(fn($_) => 'L', $keys));
        for($i = 0; $i < count($elements[array_keys($elements)[0]]); ++$i){
            $row = [];
            foreach($elements as $col)
                $row[] = $col[$i];
            $fpdf->Row($row);
        }

        return $fpdf->Output();
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