<?php
require_once('../../session.php');
require_once('../../controller/scheduleController.php');
require_once('../../utils.php');
require_once('../../conn.php');

date_default_timezone_set("America/Sao_Paulo");

$scheduleController = new ScheduleController($MySQLi);

$startDate;
$endDate;
$status;

$columns = [
    'status'               => ['name' => 'status',                'label'=> 'Status',          'value' => 'getStatus'            ],
    'operationScheduleTime'=> ['name' => 'operationScheduleTime', 'label'=> 'Agendamento',     'value' => 'getDataAgendamento'   ],
    'arrival'              => ['name' => 'arrival',               'label'=> 'Chegada',         'value' => 'getHoraChegada'       ],
    'operationStart'       => ['name' => 'operationStart',        'label'=> 'Início',          'value' => 'getInicioOperacao'    ],
    'operationDone'        => ['name' => 'operationDone',         'label'=> 'Fim',             'value' => 'getFimOperacao'       ],
    'operationExit'        => ['name' => 'operationExit',         'label'=> 'Saída',           'value' => 'getSaida'             ],
    'operationType'        => ['name' => 'operationType',         'label'=> 'Operação',        'value' => 'getOperacao'          ],
    'shippingCompany'      => ['name' => 'shippingCompany',       'label'=> 'Transportadora',  'value' => 'getTransportadora'    ],
    'city'                 => ['name' => 'city',                  'label'=> 'Cidade',          'value' => 'getCidade'            ],
    'documentDriver'       => ['name' => 'documentDriver',        'label'=> 'CPF',             'value' => 'getDocumentoMotorista'],
    'driverName'           => ['name' => 'driverName',            'label'=> 'Nome Motorista',  'value' => 'getNomeMotorista'     ],
    'licenceTruck'         => ['name' => 'licenceTruck',          'label'=> 'Placa Cavalo',    'value' => 'getPlacaCavalo'       ],
    'licenceTrailer2'      => ['name' => 'licenceTrailer2',       'label'=> 'Placa carreta',   'value' => 'getPlacaCarreta'      ],
    'licenceTrailer'       => ['name' => 'licenceTrailer',        'label'=> 'Placa Carreta 2', 'value' => 'getPlacaCarreta2'     ],
    'binSeparation'        => ['name' => 'binSeparation',         'label'=> 'Separação BIN',   'value' => 'getSeparacao'         ],
    'shipmentId'           => ['name' => 'shipmentId',            'label'=> 'Shipment ID',     'value' => 'getShipmentId'        ],
    'dock'                 => ['name' => 'dock',                  'label'=> 'Doca',            'value' => 'getDoca'              ],
    'truckType'            => ['name' => 'truckType',             'label'=> 'Tipo Veículo',    'value' => 'getTipoVeiculo'       ],
    'dos'                  => ['name' => 'dos',                   'label'=> 'DOs',             'value' => 'getDo_s'              ],
    'invoice'              => ['name' => 'invoice',               'label'=> 'NF',              'value' => 'getNf'                ],
    'grossWeight'          => ['name' => 'grossWeight',           'label'=> 'Peso Final',      'value' => 'getPeso'              ],
    'pallets'              => ['name' => 'pallets',               'label'=> 'Paletes',         'value' => 'getCargaQtde'         ],
    'material'             => ['name' => 'material',              'label'=> 'Material',        'value' => 'getDadosGerais'       ],
    'observation'          => ['name' => 'observation',           'label'=> 'Observação',      'value' => 'getObservacao'        ]
];


if((isset($_GET['startDate']) && $_GET['startDate'] != null) && (isset($_GET['endDate']) && $_GET['endDate'] != null)){

    $startDate = $_GET['startDate'];
    $endDate = $_GET['endDate'];
    $status = $_GET['status'];

    $schedules = $scheduleController->findByClientStatusStartDateAndEndDate($_SESSION['customerName'], $status, $startDate, $endDate);
}

$file .= '<table><thead><tr>';
           
    foreach ($columns as $key => $value) {
        $file .= '<th>'.utf8_decode($value["label"]).'</th>';
    }
            
$file .= '</tr></thead><tbody>';
    foreach ($schedules as $schedule) {
        $file .= '<tr>';
        
        foreach ($columns as $key => $value) {
            $file .= '<td>'.utf8_decode($schedule[$value['value']]).'</td>';
        }
        $file .= '</tr>';
    }

$file .= '</tbody></table>';

header("Expires: 0");
header("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
header("Pragma: no-cache");
header("Content-Type: application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=\"agendamentos.xls\"" );
header("Content-Description: PHP Generated Data" );

echo $file;
exit;

?>