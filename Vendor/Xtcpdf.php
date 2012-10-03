<?php
App::import('Vendor','tcpdf/tcpdf');

/**
 * Classe que extende TCPDF e personaliza a exibição do cabeçalho e rodapé
 */
class Xtcpdf extends TCPDF
{
	public $xheadertext;
	public $xheadercolor;
	public $xfootertext;
	public $xheaderimage;
	public $mainTitle;
	public $date;

	/**
	 * (non-PHPdoc)
	 * @see TCPDF::Header()
	 */
	public function Header()
	{
		if(!empty($this->xheaderimage))
		{
			// $this->setImageScale(PDF_IMAGE_SCALE_RATIO);
			// $this->Image($this->xheaderimage, 0,0,1169,826,null,null,'T',true,'300', 'C');
		}

		$this->SetFont('', 'B', 16);
		$this->Ln(16);
		$this->Cell(0, 0, $this->xheadertext, 0, false, 'C', 0, '', 0, false, 'M', 'M');
	}

	/**
	 *
	 */
	public function Footer()
	{
		$this->setY(275);
		$this->SetFont('', 'B', 7);
		$this->Line(28, $this->getY(), 178, $this->GetY());
		$this->shiftY(2);
		$this->MultiCell(0, 30, $this->xfootertext, false, 'C', 0, null);
		$this->shiftY(5);
		$this->SetFont('', 'B', 9);
		$this->Cell(0, 15, $this->PageNo(), 0, false, 'R', 0, '', 0, false, 'M', 'M');
		$this->shiftY(-15);
	}

	public function shiftX($offset = 0)
	{
		$this->x += $offset;
	}

	public function shiftY($offset = 0)
	{
		$this->y+=$offset;
	}

}