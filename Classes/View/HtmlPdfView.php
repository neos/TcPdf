<?php
namespace TYPO3\TcPdf\View;

/*                                                                        *
 * This script belongs to the FLOW3 package "TYPO3.TcPdf".                *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

/**
 * this view will sent a PDF rendering of a Fluid template. It will use the Fluid View to render a HTML representation
 * and use this HTML to create a PDF. Results will vary depending on your HTML, see also tcpdf documentation and examples.
 */
class HtmlPdfView extends \TYPO3\Fluid\View\TemplateView {

	/**
	 * @var array
	 */
	protected $settings = array();

	/**
	 * Injects the settings.
	 *
	 * @param array $settings
	 * @return void
	 */
	public function injectSettings(array $settings) {
		$this->settings = $settings['HtmlPdfView'];
	}

	/**
	 * Renders a Fluid template and tried to put it into a pdf
	 *
	 * @param string $actionName If set, the view of the specified action will be rendered instead. Default is the action specified in the Request object
	 * @return string PDF Raw Data
	 * @api
	 */
	public function render($actionName = NULL) {
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/pdf');

		$htmlFromFluid = parent::render($actionName);

		$pdf = new \TYPO3\TcPdf\Pdf($this->settings['pageFormat'], $this->settings['sizeUnit'], $this->settings['pageOrientation'], TRUE, 'UTF-8', TRUE);

		$pdf->SetFont($this->settings['font']['family'], $this->settings['font']['style'],  $this->settings['font']['size']);
		$pdf->AddPage();


		$pdf->writeHTML($htmlFromFluid, true, false, false, false, '');

		return $pdf->Output('', 'S');
	}
}

?>