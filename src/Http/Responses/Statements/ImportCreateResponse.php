<?php

/** --------------------------------------------------------------------------------
 * This classes renders the response for the [create] process for the foo
 * controller
 * @package    Grow CRM
 * @author     NextLoop
 *----------------------------------------------------------------------------------*/

namespace Ant\StatementAnalyzer\Http\Responses\Statements;
use Illuminate\Contracts\Support\Responsable;

class ImportCreateResponse implements Responsable {

    private $payload;

    public function __construct($payload = array()) {
        $this->payload = $payload;
    }

    /**
     * render the view for foo members
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request) {

        //set all data to arrays
        foreach ($this->payload as $key => $value) {
            $$key = $value;
        }

        //render the form
        $html = view('statement-analyzer::components/modals/import', compact('requirements', 'server_status', 'type'))->render();
        $jsondata['dom_html'][] = array(
            'selector' => '#commonModalBody',
            'action' => 'replace',
            'value' => $html);

        // POSTRUN FUNCTIONS------
        $jsondata['postrun_functions'][] = [
            'value' => 'NXImportingFileUpload',
        ];

        //ajax response
        return response()->json($jsondata);

    }

}
