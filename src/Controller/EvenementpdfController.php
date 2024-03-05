<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Dompdf\Dompdf;
use Dompdf\Options;
use App\Repository\EvenementRepository; 
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TCPDF;

#[Route('/evenement/print')]
class EvenementpdfController extends AbstractController
{
#[Route('/exportEvenement', name: 'export_evenement_to_pdf', methods: ['GET'])]
public function exportEvenementsToPdf(EvenementRepository $evenementRepository): Response
{
$evenements = $evenementRepository->findAll();

$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->SetCreator("Sara");
$pdf->SetAuthor('Sara');
$pdf->SetTitle('Liste des evenements');
$pdf->setHeaderData(PDF_HEADER_LOGO2, PDF_HEADER_LOGO_WIDTH);
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
$pdf->setFont('dejavusans', '', 14, '', true);
$pdf->AddPage();
$html = $this->renderView('evenementpdf/index.html.twig', [
'evenements' => $evenements,
]);
$pdf->writeHTML($html);

$response = new Response($pdf->Output('evenements.pdf', 'I'));
return $response;
}

#[Route('/list', name: 'list_evenements', methods: ['GET'])]
public function listEvenements(EvenementRepository $evenementRepository): Response
{
$evenements = $evenementRepository->findAll();

return $this->json($evenements, 200, [], ['groups' => 'api']);
}
}