<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// Assuming your ProductRepository namespace is App\Repository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use TCPDF;

#[Route('/user/pdf')]
class PdfController extends AbstractController
{
    #[Route('/exportUser', name: 'export_user_to_pdf', methods: ['GET'])]
    public function exportProductsToPdf(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator("Wael Salah");
        $pdf->SetAuthor('Wael Salah');
        $pdf->SetTitle('Liste des produits');
        $pdf->setHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH);
        $pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
        $pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
        $pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
        $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
        $pdf->setFont('dejavusans', '', 10, '', true);
        $pdf->AddPage();
        $html = $this->renderView('pdf/index.html.twig', [
            'users' => $user,
        ]);
        $pdf->writeHTML($html);

        $response = new Response($pdf->Output('users.pdf', 'I'));
        return $response;
    }

    #[Route('/list', name: 'list_products', methods: ['GET'])]
    public function listProducts(UserRepository $userRepository): Response
    {
        $user = $userRepository->findAll();

        return $this->json($user, 200, [], ['groups' => 'api']);
    }
}