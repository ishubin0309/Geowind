<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Projet;
use AppBundle\Entity\Liste;
use AppBundle\Entity\MessageProprietaire;
use AppBundle\Helper\GridHelper;
use AppBundle\Model\AvisMairie;
use AppBundle\Model\ExportOption;
use AppBundle\Model\Foncier;
use AppBundle\Model\Etat;
use AppBundle\Model\Progression;
use AppBundle\Model\Servitude;
use AppBundle\Service\AnnuaireMailer;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @Route("/app")
 */
class DefaultController extends Controller
{
    private function publier()
    {
        $post = '{"projet_technologie":"photovoltaique","{proprietaire_civilite}":"Mr","{proprietaire_identite}":"Kerhoas Gerard","{proprietaire_qualite}":"Personne","{proprietaire_adresse}":"Kili Vihan, 29190 Brasparts","{proprietaire_droit}":"Propri\u00e9taire","{proprietaire_marital}":"C\u00e9libataire","{proprietaire_ne_le}":"23\/10\/1954","{proprietaire_ne_a}":"Brasparts","{exploitant_civilite}":"Mr","{exploitant_identite}":"Kerhoas Gerard","{exploitant_qualite}":"Personne","{exploitant_adresse}":"Kili Vihan, 29190 Brasparts","{exploitant_ne_le}":"23\/10\/1954","{exploitant_ne_a}":"Brasparts","{exploitant_droit}":"","{exploitant_marital}":"C\u00e9libataire","{representant}":"","{representant_proprietaire}":"","{representant_exploitant}":"","{representant_wkn}":"","{WKN_Raison_sociale}":"WKN France","{Type_de_groupement}":"SASU","{WKN_capital_social}":"500000 \u20ac","{WKN_siege_social}":"immeuble \u00ab le Sanitat \u00bb, 10, rue Charles Brunelli\u00e8re 44100 NANTES","{WKN_immatriculation}":"RCS de Nantes","{WKN_numero}":"B 443 622 295","{WKN_representant}":"Roland STANZE","{commune}":"Brasparts (29016)","{montant_base}":"DEUX MILLE CINQ CENT EUROS (2500 \u20ac)","{montant_exploitation}":"DEUX MILLE CINQ CENT EUROS (2500 \u20ac)","{part_proprietaire}":"50%","{part_exploitant}":"50%","{duree_bail}":"DIX HUIT (18)","{xprorogation_bail}":"Cinq (5) ann\u00e9es","{tprorogation_bail}":"DEUX (2) fois","{avis1_LRAR}":"SIX (6) mois pleins","{delais1_levee_doption}":"DEUX (2) ann\u00e9es pleines","{delais2_levee_doption}":"UNE (1) ann\u00e9e(s) pleine(s)","{avis2_LRAR}":"SIX (6) mois pleins","{ptf_mois}":"5 (cinq)","{ptf_%capex}":"25%","{puissance}":"5 Mwc (cinq m\u00e9gawatts-cr\u00eate)","{pdl}":"UN (1) poste","{avis_entree}":"DIX (10) jours","{delais_servitudes}":"SIX (6) mois pleins","{largeur_enligne}":"QUATRE (4) m\u00e8tres","{largeur_encourbe}":"DIX (10) m\u00e8tres","{duree_promesse}":"Cinq (5) ann\u00e9es","{ndelais_promesse}":"2 (deux) fois","{prorogation_promesse}":"2 (deux) ann\u00e9es","{LRAR1_promesse}":"6 (six) mois","{indeminite_sinon}":"CINQ CENT EUROS (500\u20ac)","{n_annexe}":"6 (six)","{lesExemplaires}":"DEUX (2)","{date_signature}":"10\/07\/2022","{lieu_signature}":"","{representant_societe}":"","{societe}":"WKN France","{publish_parcelles}":"[[\"AD55\",\"Brasparts\",\"LANGLE\",\"26510\"],[\"AD56\",\"Brasparts\",\"LANGLE\",\"16050\"],[\"AD59\",\"Brasparts\",\"\",\"11550\"],[\"AD60\",\"Brasparts\",\"\",\"8375\"],[\"AD62\",\"Brasparts\",\"\",\"18920\"],[\"AD62\",\"Brasparts\",\"\",\"18920\"],[\"AD61\",\"Brasparts\",\"\",\"38340\"]]","{proprietaire2_civilite}":"","{proprietaire2_identite}":"","{proprietaire2_qualite}":"","{proprietaire2_adresse}":"","{proprietaire2_droit}":"","{proprietaire2_marital}":"","{proprietaire2_ne_le}":"","{proprietaire2_ne_a}":"","{proprietaire3_civilite}":"","{proprietaire3_identite}":"","{proprietaire3_qualite}":"","{proprietaire3_adresse}":"","{proprietaire3_droit}":"","{proprietaire3_marital}":"","{proprietaire3_ne_le}":"","{proprietaire3_ne_a}":"","{proprietaire4_civilite}":"","{proprietaire4_identite}":"","{proprietaire4_qualite}":"","{proprietaire4_adresse}":"","{proprietaire4_droit}":"","{proprietaire4_marital}":"","{proprietaire4_ne_le}":"","{proprietaire4_ne_a}":"","{exploitant2_civilite}":"","{exploitant2_identite}":"","{exploitant2_qualite}":"","{exploitant2_adresse}":"","{exploitant2_ne_le}":"","{exploitant2_ne_a}":"","{exploitant2_droit}":"","{exploitant2_marital}":"","{exploitant3_civilite}":"","{exploitant3_identite}":"","{exploitant3_qualite}":"","{exploitant3_adresse}":"","{exploitant3_ne_le}":"","{exploitant3_ne_a}":"","{exploitant3_droit}":"","{exploitant3_marital}":"","submit":""}';
        $_POST = json_decode($post, 1);
        // echo '<pre>';print_r($_POST);die;
        if(isset($_POST['projet_technologie'])) {
        	if($_POST['projet_technologie'] == 'eolienne') {
                $fileName = 'PdBS Eolien.docx';
                $fullPath = $this->getUser()->getId() . '_' . $fileName;
            } else {
                $fileName = 'PdBS Solaire.docx';
                $fullPath = $this->getUser()->getId() . '_' . $fileName;
                $parcelleRow = '';
            }
            @unlink($fullPath);
            copy(__DIR__ . '/../' . $fileName, $fullPath);
	
			$parcelleRow = '<w:tr w:rsidR="000412FA" w:rsidRPr="00045C8A" w14:paraId="2DC1474E" w14:textId="77777777" w:rsidTr="005E1E4F"><w:trPr><w:trHeight w:val="292"/></w:trPr><w:tc><w:tcPr><w:tcW w:w="1841" w:type="dxa"/></w:tcPr><w:p w14:paraId="6BED3C66" w14:textId="3BF5952A" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_com}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1843" w:type="dxa"/><w:gridSpan w:val="2"/></w:tcPr><w:p w14:paraId="0732FA70" w14:textId="74B4E54E" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_section}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1841" w:type="dxa"/></w:tcPr><w:p w14:paraId="49BE4506" w14:textId="386C67B9" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_n}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1843" w:type="dxa"/></w:tcPr><w:p w14:paraId="236AC2B6" w14:textId="720D6377" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="006226EC"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_lieudit}</w:t></w:r></w:p></w:tc><w:tc><w:tcPr><w:tcW w:w="1878" w:type="dxa"/></w:tcPr><w:p w14:paraId="7D928BCD" w14:textId="5BEBD362" w:rsidR="000412FA" w:rsidRPr="00045C8A" w:rsidRDefault="000412FA" w:rsidP="006226EC"><w:pPr><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:sz w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="000412FA"><w:rPr><w:rFonts w:ascii="Times New Roman"/><w:color w:val="FF0000"/><w:sz w:val="20"/></w:rPr><w:t>{parcelle_surface}</w:t></w:r></w:p></w:tc></w:tr>';
			$personnesPhysiquesRow = '<w:p w14:paraId="1A9F6B84" w14:textId="5720D31D" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00B718FB" w:rsidP="00B718FB"><w:pPr><w:spacing w:before="1" w:line="219" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00B718FB"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_civilite}</w:t></w:r><w:r><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_identite}</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>Né(e)</w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>le</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_ne_le}</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:rFonts w:ascii="Times New Roman" w:hAnsi="Times New Roman"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00045C8A" w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t>à</w:t></w:r><w:r w:rsidR="00AF5338"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00AF5338" w:rsidRPr="00AF5338"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_ne_a}</w:t></w:r></w:p><w:p w14:paraId="43491EE4" w14:textId="77777777" w:rsidR="0097492F" w:rsidRDefault="00045C8A" w:rsidP="0097492F"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:spacing w:val="-7"/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-7"/><w:sz w:val="18"/></w:rPr><w:t>De nationalité</w:t></w:r></w:p><w:p w14:paraId="70EC600C" w14:textId="2A1D5B6D" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="0097492F"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-38"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Demeurant à</w:t></w:r><w:r w:rsidR="0097492F"><w:rPr><w:spacing w:val="-10"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="0097492F" w:rsidRPr="0097492F"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_adresse}</w:t></w:r></w:p><w:p w14:paraId="372D95EF" w14:textId="1329B2F8" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:line="219" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Qui</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>déclare</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:proofErr w:type="gramStart"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>être</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>:</w:t></w:r><w:proofErr w:type="gramEnd"/><w:r w:rsidR="0097492F"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="0097492F" w:rsidRPr="0097492F"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_marital}</w:t></w:r></w:p><w:p w14:paraId="753C5FF0" w14:textId="315553C8" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218" w:right="195"/><w:rPr><w:b/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Agissant</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-3"/><w:sz w:val="18"/></w:rPr><w:t>en</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>qualité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-4"/><w:sz w:val="18"/></w:rPr><w:t>de</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00900F35" w:rsidRPr="00900F35"><w:rPr><w:color w:val="FF0000"/><w:sz w:val="18"/></w:rPr><w:t>{proprietaire_droit}</w:t></w:r></w:p><w:p w14:paraId="3F868699" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:ind w:left="218"/><w:rPr><w:b/><w:sz w:val="18"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>Qualité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>particulière</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>de</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>l’intéressé(e)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>(rayer</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>la</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-6"/><w:sz w:val="18"/></w:rPr><w:t>mention</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>inutile</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-12"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>et</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-10"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>parapher</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>en</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>marge)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>:</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>PROMETTANT</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-14"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>OU</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>EXPLOITANT</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-13"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>OU</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-11"/><w:sz w:val="18"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:spacing w:val="-5"/><w:sz w:val="18"/></w:rPr><w:t>INTERVENANT</w:t></w:r></w:p><w:p w14:paraId="28397692" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="11"/><w:rPr><w:b/><w:sz w:val="15"/><w:szCs w:val="20"/></w:rPr></w:pPr></w:p>';
			$personnesPhysiques2Row = '<w:p w14:paraId="07A0F37E" w14:textId="21B8B8BB" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:line="243" w:lineRule="exact"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Je</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-3"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>soussigné</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="15"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_civilite}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_identite}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="44594A93" w14:textId="5BF4193A" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Né(e)</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="2"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>le</w:t></w:r><w:r w:rsidR="00512607" w:rsidRPr="00512607"><w:t xml:space="preserve"> </w:t></w:r><w:bookmarkStart w:id="0" w:name="_Hlk76307180"/><w:r w:rsidR="00512607" w:rsidRPr="00512607"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_ne_le}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="25"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>à</w:t><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00121F5D" w:rsidRPr="00121F5D"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_ne_a}</w:t></w:r><w:bookmarkEnd w:id="0"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="308ED261" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>De</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="10"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>nationalité</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="66"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t></w:t></w:r></w:p><w:p w14:paraId="72299912" w14:textId="337649DC" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00045C8A"><w:pPr><w:spacing w:before="1"/><w:ind w:left="218"/><w:rPr><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>Demeurant</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="12"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>à</w:t></w:r><w:proofErr w:type="gramStart"/><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="33"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:proofErr w:type="gramEnd"/><w:r w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r><w:r w:rsidR="00A7281E" w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/></w:rPr><w:t xml:space="preserve"> </w:t></w:r><w:r w:rsidR="00A7281E" w:rsidRPr="00A7281E"><w:rPr><w:color w:val="FF0000"/><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr><w:t>{proprietaire_adresse}</w:t></w:r><w:r w:rsidRPr="00045C8A"><w:rPr><w:spacing w:val="-8"/><w:sz w:val="20"/><w:szCs w:val="20"/></w:rPr></w:r></w:p>';
			$titleRow = '<w:p w14:paraId="51374436" w14:textId="77777777" w:rsidR="00045C8A" w:rsidRPr="00045C8A" w:rsidRDefault="00045C8A" w:rsidP="00252069"><w:pPr><w:ind w:firstLine="218"/></w:pPr><w:r w:rsidRPr="00045C8A"><w:rPr><w:b/><w:sz w:val="18"/><w:szCs w:val="20"/></w:rPr><w:t>{title}</w:t></w:r></w:p>';
			$replaceThis = [];
            $replaceBy = [];
            foreach($_POST as $key => $value) {
                if(preg_match('%\{.+?\}%', $key) && $value) {
                    if($key != '{publish_parcelles}') {
                        $replaceThis[] = $key;
                        $replaceBy[] = $value;
                    } else {
                        $parcelleRowCopy = $parcelleRow;
                        $parcelleRow = '';
                        $parcelles = json_decode($value, 1);
                        foreach($parcelles as $parcelle) {
                            $parcelleName = trim($parcelle[0]);
                            $parcelleSection = '';
                            $parcelleNumber = '';
                            if(preg_match('%^[a-zA-Z]+%', $parcelleName, $m)) {
                                $parcelleSection = $m[0];
                            }
                            if(preg_match('%\d+%', $parcelleName, $m)) {
                                $parcelleNumber = $m[0];
                            }
                            $parcelleRow .= str_replace(['{parcelle_section}', '{parcelle_n}', '{parcelle_com}', '{parcelle_lieudit}', '{parcelle_surface}'], [$parcelleSection, $parcelleNumber, $parcelle[1], $parcelle[2], $parcelle[3]], $parcelleRowCopy);
                        }
                    }
                }
            }
			$personnesPhysiquesRowCopy = $personnesPhysiquesRow;
			$personnesPhysiquesRow = str_replace('{title}', 'Propriétaires:', $titleRow);
			for ($i=0; $i <= 4; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{proprietaire' . $j . '_identite}']) && $_POST['{proprietaire' . $j . '_identite}'] && isset($_POST['{proprietaire' . $j . '_qualite}']) && $_POST['{proprietaire' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiquesRow .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRow .= str_replace('{title}', 'Exploitants:', $titleRow);
			for ($i=0; $i <= 3; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{exploitant' . $j . '_identite}']) && $_POST['{exploitant' . $j . '_identite}'] && isset($_POST['{exploitant' . $j . '_qualite}']) && $_POST['{exploitant' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiquesRow .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRowCopy = $personnesPhysiques2Row;
			$personnesPhysiques2Row = '';
			for ($i=0; $i <= 4; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{proprietaire' . $j . '_identite}']) && $_POST['{proprietaire' . $j . '_identite}'] && isset($_POST['{proprietaire' . $j . '_qualite}']) && $_POST['{proprietaire' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'proprietaire' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiques2Row .= $personnesPhysiquesRowCopy2;
				}
			}
			$personnesPhysiquesRowCopy = $personnesPhysiques2Row;
			$personnesPhysiques3Row = '';
			for ($i=0; $i <= 3; $i++) {
				$j = $i > 0 ? $i : '';
				if (isset($_POST['{exploitant' . $j . '_identite}']) && $_POST['{exploitant' . $j . '_identite}'] && isset($_POST['{exploitant' . $j . '_qualite}']) && $_POST['{exploitant' . $j . '_qualite}'] == 'Personne') {
					$personnesPhysiquesRowCopy2 = $personnesPhysiquesRowCopy;
					$postArray = ['{proprietaire_civilite}', '{proprietaire_identite}', '{proprietaire_ne_le}', '{proprietaire_ne_a}', '{proprietaire_adresse}', '{proprietaire_droit}', '{proprietaire_marital}', '{proprietaire_qualite}'];
					foreach ($postArray as $post) {
						if (isset($_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) && $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)]) {
							$personnesPhysiquesRowCopy2 = str_replace($post, $_POST[str_replace('proprietaire_', 'exploitant' . $j . '_', $post)], $personnesPhysiquesRowCopy2);
						}
					}
					$personnesPhysiques3Row .= $personnesPhysiquesRowCopy2;
				}
			}if (isset($_GET['test'])) exit($parcelleRow);

            $zip_val = new \ZipArchive;

            if($zip_val->open($fullPath) == true) {

                $key_file_name = 'word/document.xml';
                $message = $zip_val->getFromName($key_file_name);

                $timestamp = date('d-M-Y H:i:s');

                $message = str_replace('{parcelle_row}', $parcelleRow, $message);

                $message = str_replace('{personnes_physiques}', $personnesPhysiquesRow, $message);

                $message = str_replace('{personnes_physiques_2}', $personnesPhysiques2Row, $message);

                $message = str_replace('{personnes_physiques_3}', $personnesPhysiques3Row, $message);

                $message = str_ireplace($replaceThis, $replaceBy, $message);

                //Replace the content with the new content created above.
                $zip_val->addFromString($key_file_name, $message);
                $zip_val->close();
                header("Content-type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
                header("Content-Disposition:attachment;filename=$fileName");
                readfile($fullPath);
                @unlink($fullPath);
                die;
            }
        }
        exit('Done');
    }
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $this->publier();
        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllPaginator(false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllCount(false);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjets($this->getUser(), false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsCount($this->getUser(), false);
        }
        $totalPages = ceil($projetsTotal / $limit);

        $gridHelper = new GridHelper();
        $columnsType = isset($_GET['type']) && $_GET['type'] >= 1 ? trim($_GET['type']) : 1;

        $typesProjet = Projet::getTypeProjetList(1);

        $typeProjet = isset($_GET['typeProjet']) ? $_GET['typeProjet'] : '';
        $departement = isset($_GET['departement']) ? $_GET['departement'] : '';
        $origine = isset($_GET['origine']) ? $_GET['origine'] : '';
        $chefProjet = isset($_GET['chefProjet']) ? $_GET['chefProjet'] : '';
        $chargeFoncier = isset($_GET['chargeFoncier']) ? $_GET['chargeFoncier'] : '';
        $partenaire = isset($_GET['partenaire']) ? $_GET['partenaire'] : '0';

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'columnsType' => $columnsType,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
            'export_option' => new ExportOption(),
            'typeProjet' => $typeProjet,
            'departement' => $departement,
            'origine' => $origine,
            'chefProjet' => $chefProjet,
            'chargeFoncier' => $chargeFoncier,
            'partenaire' => $partenaire,
        ]);
    }
    /**
     * @Route("/fix-projets", name="fixprojets")
     */
    public function fixAction(Request $request)
    {

        /* $em = $this->getDoctrine()->getManager();

        $projets = $em->getRepository('AppBundle:Projet')->findAll();
        foreach($projets as $projet) {
            echo $projet->getId() . ': ' . $projet->calculeCompletude() . '%<br>';
            $em->persist($projet);
        }
        $em->flush(); */
        return new Response('done');
    }
    /**
     * @Route("/liste/{liste}", name="view_liste", requirements={"liste"="\d+"})
     */
    public function listeAction(Request $request, $liste)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllByListePaginator(false, $liste, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllByListeCount(false, $liste);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjetsByListe($this->getUser(), false, $liste, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsByListeCount($this->getUser(), $liste, false);
        }
        $totalPages = ceil($projetsTotal / $limit);
        $liste = $em->getRepository('AppBundle:Liste')->findOneBy(['id' => $liste]);
        $gridHelper = new GridHelper();
        $columnsType = isset($_GET['type']) && $_GET['type'] >= 1 ? trim($_GET['type']) : 1;

        $typesProjet = Projet::getTypeProjetList(1);

        return $this->render('default/portail.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'columnsType' => $columnsType,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
            'liste' => $liste,
            'export_option' => new ExportOption(),
        ]);
    }

    /**
     * @Route("/recherche", name="search_index")
     */
    public function searchAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 100;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllPaginator(false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findAllCount(false);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserProjets($this->getUser(), false, $offset, $limit);
            $projetsTotal = $em->getRepository('AppBundle:Projet')->findUserProjetsCount($this->getUser(), false);
        }
        $totalPages = ceil($projetsTotal / $limit);

        $gridHelper = new GridHelper();

        $regions = $em->getRepository('AppBundle:Region')->findAll();
        $departements = $em->getRepository('AppBundle:Departement')->findAll();

        $typesProjet = Projet::getTypeProjetList(1);
        $typesSite = Projet::getTypeSiteList();
        $phases = Etat::getPhaseList();
        $progressions = Etat::getEtatList();
        // $servitudes = Servitude::getServitudeList();
        // $fonciers = Foncier::getFoncierList();
        // $avisMairies = AvisMairie::getAvisMairieList();

        return $this->render('default/search.html.twig', [
            'projets' => $projets,
            'page' => $page,
            'totalPages' => $totalPages,
            'grid_helper' => $gridHelper,
            'regions' => $regions,
            'departements' => $departements,
            'typesProjet' => $typesProjet,
            'typesSite' => $typesSite,
            'phases' => $phases,
            'progressions' => $progressions,
            // 'servitudes' => $servitudes,
            // 'fonciers' => $fonciers,
            // 'avis_mairies' => $avisMairies,
        ]);
    }

    /**
     * @Route("/graphique", name="graphique")
     */
    public function graphiqueAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        $page = isset($_GET['page']) && $_GET['page'] >= 1 ? trim($_GET['page']) : 1;
        $limit = isset($_GET['limit']) && $_GET['limit'] >= 5 && $_GET['limit'] <= 200 ? trim($_GET['limit']) : 10000;
        $offset = ($page - 1) * $limit;
        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')->findAllForStatsPaginator(false, $offset, $limit);
        } else {
            $projets = $em->getRepository('AppBundle:Projet')->findUserForStatsProjets($this->getUser(), false, $offset, $limit);
        }

        $gridHelper = new GridHelper();

        $typesProjet = Projet::getTypeProjetList(1);

        return $this->render('default/graphique.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
            'typesProjet' => $typesProjet,
        ]);
    }

    /**
     * @Route("/finance", name="finance_index")
     */
    public function financeAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAll();
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAllUserProjets($this->getUser());
        }

        $gridHelper = new GridHelper();

        return $this->render('default/finance.html.twig', [
            'projets' => $projets,
            'grid_helper' => $gridHelper,
        ]);
    }
    
    /**
     * @Route("/proprietaires", name="proprietaires")
     */
    public function proprietairesAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();

        if ($this->isGranted('ROLE_VIEW_ALL')) {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAll();
            $messages = $em->getRepository('AppBundle:MessageProprietaire')
                        ->findAll();
        } else {
            $projets = $em->getRepository('AppBundle:Projet')
                        ->findAllUserProjets($this->getUser());
            $messages = $em->getRepository('AppBundle:MessageProprietaire')
                        ->findBy(['createdBy' => $this->getUser()]);
        }

        $gridHelper = new GridHelper();

        return $this->render('default/proprietaires.html.twig', [
            'projets' => $projets,
            'messages' => $messages,
            'grid_helper' => $gridHelper,
        ]);
    }
    
    /**
     * @Route("/proprietaire/envoyer", name="proprietaire_send")
     * @Method({"POST"})
     * @Security("has_role('ROLE_EDIT')")
     */
    public function proprietaireSendAction(Request $request)
    {
        $data = $request->request->all();
        $em = $this->getDoctrine()->getManager();
        $annuaireMailer = new AnnuaireMailer($this->getParameter('mailer_password'));
        foreach($data['proprietaire'] as $key => $id) {
            if($id > 0) {
                $id = $id * 1;
                $type = 'proprietaire';
            } else {
                $id = $id * -1;
                $type = 'exploitant';
            }
            $proprietaire = $em->getRepository('AppBundle:Proprietaire')->findOneBy(['id' => $id]);
            $message_to = $data['message_to'][$key];
            $message_to_array = explode(',', $message_to);
            foreach($message_to_array as $to) {
                if(trim($to)) {
                    $messageProprietaire = new MessageProprietaire();
                    $messageProprietaire->setProprietaire($proprietaire);
                    if($type != 'proprietaire') $messageProprietaire->setExploitant(true);
                    $messageProprietaire->setTo(trim($to));
                    $messageProprietaire->setObject($data['message_object']);
                    $messageProprietaire->setBody($data['message_body']);
                    $errors = [];
                    if ($annuaireMailer->handleMessageProprietaire($messageProprietaire, $errors)) {
                        $em->persist($messageProprietaire);
                        $em->flush();
                        $this->addFlash('success', 'Mail envoyé à '.trim($to).'.');
                    } else {
                        $this->addFlash('error', 'Erreur: Mail non envoyé à '.trim($to).'.');
                    }
                }
            }
        }
        // echo '<pre>';print_r($data);die;

        return $this->redirectToRoute('proprietaires');
    }

    /**
     * @Route("/proprietaire/message/{id}/supprimer", name="proprietaire_message_delete", options={ "expose": true })
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function proprietaireMessageDeleteAction(Request $request, MessageProprietaire $messageProprietaire)
    {
        $csrf = $request->request->get('csrf', null);

        if ($this->isCsrfTokenValid('token', $csrf)) {
            throw $this->createAccessDeniedException();
        }

        $em = $this->getDoctrine()->getManager();

        $response = new JsonResponse();
        $response->setData(['success' => 0]);
        $em = $this->getDoctrine()->getManager();
        $sujet = $messageProprietaire->getObject();
        $em->remove($messageProprietaire);
        $em->flush();
        $this->addFlash('success', 'Message « '.$sujet.' » a été supprimé.');

        return $response;
    }
}
