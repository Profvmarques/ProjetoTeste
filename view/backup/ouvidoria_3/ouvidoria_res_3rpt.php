<?php
session_start();
ob_start();
?>
<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT"); // Always modified
header("Cache-Control: private, no-store, no-cache, must-revalidate"); // HTTP/1.1 
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); // HTTP/1.0
?>
<?php //include "phprptinc/ewrcfg2.php"; ?>
<?php //include "phprptinc/ewmysql.php"; ?>
<?php //include "phprptinc/ewrfn2.php"; ?>
<?php //include "phprptinc/ewrsecu2.php"; ?>
<?php

// Table level constants
define("EW_REPORT_TABLE_VAR", "ouvidoria_res_3", TRUE);
define("EW_REPORT_TABLE_GROUP_PER_PAGE", "grpperpage", TRUE);
define("EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE", "ouvidoria_res_3_grpperpage", FALSE);
define("EW_REPORT_TABLE_START_GROUP", "start", TRUE);
define("EW_REPORT_TABLE_SESSION_START_GROUP", "ouvidoria_res_3_start", TRUE);
define("EW_REPORT_TABLE_SESSION_SEARCH", "ouvidoria_res_3_search", TRUE);
define("EW_REPORT_TABLE_CHILD_USER_ID", "childuserid", TRUE);
define("EW_REPORT_TABLE_SESSION_CHILD_USER_ID", "ouvidoria_res_3_childuserid", TRUE);

// Table level SQL
$EW_REPORT_TABLE_SQL_FROM = "entidade left join ouvidoria on ouvidoria.id_entidade=entidade.id_entidade";
$EW_REPORT_TABLE_SQL_SELECT = "SELECT entidade.entidade,count(ouvidoria.id_entidade), concat(round(((count(ouvidoria.id_entidade)*100)/(select count(id_entidade) from ouvidoria)),2),' %') as total FROM " . $EW_REPORT_TABLE_SQL_FROM;
$EW_REPORT_TABLE_SQL_WHERE = "";
$EW_REPORT_TABLE_SQL_GROUPBY = "entidade.id_entidade";
$EW_REPORT_TABLE_SQL_HAVING = "";
$EW_REPORT_TABLE_SQL_ORDERBY = "";
$EW_REPORT_TABLE_SQL_USERID_FILTER = "";
$af_entidade = NULL; // Popup filter for entidade
$af_count28ouvidoria2Eid_entidade29 = NULL; // Popup filter for count(ouvidoria.id_entidade)
$af_total = NULL; // Popup filter for total
$_SESSION[EW_REPORT_TABLE_SESSION_GROUP_PER_PAGE] = -1;

?>
<?php

// Initialize common variables
// Paging variables

$nRecCount = 0; // Record count
$nStartGrp = 0; // Start group
$nStopGrp = 0; // Stop group
$nTotalGrps = 0; // Total groups
$nGrpCount = 0; // Group count
$nDisplayGrps = 3; // Groups per page
$nGrpRange = 10;

// Clear field for ext filter
$sClearExtFilter = "";

// Dropdown filters
// Extended filters
// Custom filters

$ewrpt_CustomFilters = array();
?>
<?php
?>
<?php

// Field variables
$x_entidade = NULL;
$x_count28ouvidoria2Eid_entidade29 = NULL;
$x_total = NULL;

// Detail variables
$o_entidade = NULL; $t_entidade = NULL; $ft_entidade = 200; $rf_entidade = NULL; $rt_entidade = NULL;
$o_count28ouvidoria2Eid_entidade29 = NULL; $t_count28ouvidoria2Eid_entidade29 = NULL; $ft_count28ouvidoria2Eid_entidade29 = 20; $rf_count28ouvidoria2Eid_entidade29 = NULL; $rt_count28ouvidoria2Eid_entidade29 = NULL;
$o_total = NULL; $t_total = NULL; $ft_total = 200; $rf_total = NULL; $rt_total = NULL;
?>
<?php

// Chart configuration parameters
$Chart1_cht_parms = array(); // Store all chart parameters

// Chart data
$Chart1_cht_index = NULL;
$Chart1_cht_id = NULL;
$Chart1_cht_smry = array();
$Chart1_cht_XFld = NULL;
$Chart1_cht_YFld = NULL;
$Chart1_cht_YFldBase = NULL;
$Chart1_cht_XFld = 'entidade';
$Chart1_cht_YFld = 'count(_processo'.$_SESSION['periodo'].'.id_entidade)';
$Chart1_cht_XDateFld = '';
$Chart1_cht_SFld = '';
$Chart1_cht_SFldAr = NULL;
?>
<?php
$Chart1_cht_trends = array(); // Store all chart trendlines
?>
<?php

// Open connection to the database
$conn = ewrpt_Connect();

// Filter
$sFilter = "";

// Aggregate variables
// 1st dimension = no of groups (level 0 used for grand total)
// 2nd dimension = no of fields

$nDtls = 4;
$nGrps = 1;
$val = ewrpt_InitArray($nDtls, 0);
$cnt = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$smry = ewrpt_Init2DArray($nGrps, $nDtls, 0);
$mn = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$mx = ewrpt_Init2DArray($nGrps, $nDtls, NULL);
$grandsmry = ewrpt_InitArray($nDtls, 0);
$grandmn = ewrpt_InitArray($nDtls, NULL);
$grandmx = ewrpt_InitArray($nDtls, NULL);

// Set up if accumulation required
$col = array(FALSE, FALSE, FALSE, FALSE);

// Set up groups per page dynamically
SetUpDisplayGrps();

// Set up popup filter
SetupPopup();

// Extended filter
// No extended filter

$sExtendedFilter = $sFilter;

// No filter
$bFilterApplied = FALSE;

// Build SQL
//$sSql = ewrpt_BuildReportSql("", $EW_REPORT_TABLE_SQL_SELECT, $EW_REPORT_TABLE_SQL_WHERE, $EW_REPORT_TABLE_SQL_GROUPBY, $EW_REPORT_TABLE_SQL_HAVING, $EW_REPORT_TABLE_SQL_ORDERBY, "", $sExtendedFilter, @$sSort);
$sSql = "SELECT ouv_entidade.entidade,count(_processo".$_SESSION['periodo'].".id_entidade), 
		concat(round(((count(_processo".$_SESSION['periodo'].".id_entidade)*100)/(select count(id_entidade) 
			from _processo".$_SESSION['periodo']."
				where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
				and _processo".$_SESSION['periodo'].".ativo = 1)),2),' %') as total 
		FROM _ouvidoria".$_SESSION['periodo']."
			inner join _processo".$_SESSION['periodo']." on _processo".$_SESSION['periodo'].".id_ouvidoria = _ouvidoria".$_SESSION['periodo'].".id_ouvidoria
			inner join ouv_entidade on ouv_entidade.id_entidade = _processo".$_SESSION['periodo'].".id_entidade
				where _processo".$_SESSION['periodo'].".form = ".$_SESSION['entidade']."
				and _processo".$_SESSION['periodo'].".ativo = 1
					GROUP BY ouv_entidade.id_entidade";
// echo $sSql . "<br />"; // Uncomment to show SQL
// Load recordset

$rs = $conn->Execute($sSql);
$rscnt = ($rs) ? $rs->RecordCount() : 0;

// Detail distinct and selection values
InitReportData($rs);
if ($nDisplayGrps <= 0) // Display all groups
	$nDisplayGrps = $nTotalGrps;
$nStartGrp = 1;

// Set up start position if not export all
if (!(EW_REPORT_EXPORT_ALL && @$sExport <> ""))
	SetUpStartGroup();
?>
<?php include "phprptinc/header.php"; ?>
<script src="phprptjs/x/x_core.js" type="text/javascript"></script>
<script src="phprptjs/x/x_event.js" type="text/javascript"></script>
<script src="phprptjs/x/x_drag.js" type="text/javascript"></script>
<script src="phprptjs/popup.js" type="text/javascript"></script>
<script src="phprptjs/ewrptpop.js" type="text/javascript"></script>
<script src="FusionChartsFree/JSClass/FusionCharts.js" type="text/javascript"></script>
<script type="text/javascript">
var EW_REPORT_POPUP_ALL = "(All)";
var EW_REPORT_POPUP_OK = "  OK  ";
var EW_REPORT_POPUP_CANCEL = "Cancel";
var EW_REPORT_POPUP_FROM = "From";
var EW_REPORT_POPUP_TO = "To";
var EW_REPORT_POPUP_PLEASE_SELECT = "Please Select";
var EW_REPORT_POPUP_NO_VALUE = "No value selected!";

// popup fields
</script>
<!-- Table Container (Begin) -->
<table id="ewContainer" cellspacing="0" cellpadding="0" border="0">
<!-- Top Container (Begin) -->
<tr><td colspan="3" class="ewPadding"><div id="ewTop" class="phpreportmaker">
<!-- top slot -->
<a name="top"></a>
<center><font style=" font-size:12px; font-weight:bold;">Comportamento das demandas por entidade vinculada</font></center>
<br /><br />
</div></td></tr>
<!-- Top Container (End) -->
<tr>
	<!-- Left Container (Begin) -->
	<td valign="top"><div id="ewLeft" class="phpreportmaker">
	<!-- Left slot -->
	</div></td>
	<!-- Left Container (End) -->
	<!-- Center Container - Report (Begin) -->
	<td valign="top" class="ewPadding"><div id="ewCenter" class="phpreportmaker">
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<!-- Report Grid (Begin) -->
<center><table id="ewReport" class="ewTable">
<?php

// Set the last group to display if not export all
if (EW_REPORT_EXPORT_ALL && @$sExport <> "") {
	$nStopGrp = $nTotalGrps;
} else {
	$nStopGrp = $nStartGrp + $nDisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($nStopGrp) > intval($nTotalGrps))
	$nStopGrp = $nTotalGrps;
$nRecCount = 0;

// Init summary values
ResetLevelSummary(0);

// Get first row
if ($rscnt > 0) {
	GetRows(1);
	$nGrpCount = 1;
}

// Force show first header
$bShowFirstHeader = TRUE;
while (($rs && !$rs->EOF) || $bShowFirstHeader) {

	// Show header
	if ($bShowFirstHeader) {
?>
	<tr>
		<td valign="bottom" class="ewTableHeader">
		Fluxo das manifestações recebidas
		</td>
		<td valign="bottom" class="ewTableHeader">
		Quantidade
		</td>
		<td valign="bottom" class="ewTableHeader">
		Percentual
		</td>
	</tr>
<?php
		$bShowFirstHeader = FALSE;
	}
	if (intval($nGrpCount) >= intval($nStartGrp) && $nGrpCount <= $nStopGrp) {
		$nRecCount++;

		// Set row color
		$sItemRowClass = " class=\"ewTableRow\"";

		// Display alternate color for rows
		if ($nRecCount % 2 <> 1)
			$sItemRowClass = " class=\"ewTableAltRow\"";
?>
	<tr<?php echo $sItemRowClass; ?>>
		<td class="ewRptDtlField">
<?php echo $x_entidade ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_count28ouvidoria2Eid_entidade29 ?>
</td>
		<td class="ewRptDtlField">
<?php echo $x_total ?>
</td>
	</tr>
<?php

		// Accumulate page summary
		AccumulateSummary();
	}

	// Accumulate grand summary
	AccumulateGrandSummary();

	// Get next record
	GetRows(2);
	$nGrpCount++;
} // End while
?>
</table></center>
<br />
<div id="div_ouvidoria_res_3_Chart1"></div>
<?php

// Initialize chart data
$Chart1_cht_id = "ouvidoria_res_3_Chart1"; // Chart ID
ewrpt_AddChartParam($Chart1_cht_parms, "type", "2", FALSE); // Chart type
ewrpt_AddChartParam($Chart1_cht_parms, "bgcolor", "#FCFCFC", TRUE); // Background color
ewrpt_AddChartParam($Chart1_cht_parms, "caption", "Chart1", FALSE); // Chart caption
ewrpt_AddChartParam($Chart1_cht_parms, "xaxisname", "Fluxo das manifestações recebidas", TRUE); // X axis name
ewrpt_AddChartParam($Chart1_cht_parms, "yaxisname", "Quantidade", TRUE); // Y axis name
ewrpt_AddChartParam($Chart1_cht_parms, "shownames", "1", TRUE); // Show names
ewrpt_AddChartParam($Chart1_cht_parms, "showvalues", "1", TRUE); // Show values
ewrpt_AddChartParam($Chart1_cht_parms, "showhovercap", "0", TRUE); // Show hover
ewrpt_AddChartParam($Chart1_cht_parms, "alpha", "50", FALSE); // Chart alpha
ewrpt_AddChartParam($Chart1_cht_parms, "colorpalette", "#ad1e06|#e89430|#bda3f2|#0479cb|#20a4e8|#138404|#81c861|#eddc00|#a04200|#8d3eaf|#8d803e|#0080FF|#80FF00|#00FF00|#00FF80|#00FFFF", FALSE); // Chart color palette
?>
<?php
ewrpt_SetChartParam($Chart1_cht_parms, "canvasBgColor", "#EEEEEE", TRUE); // canvasBgColor
ewrpt_SetChartParam($Chart1_cht_parms, "canvasBorderColor", "#A9A9A9", TRUE); // canvasBorderColor
ewrpt_SetChartParam($Chart1_cht_parms, "showCanvasBg", "1", TRUE); // showCanvasBg
ewrpt_SetChartParam($Chart1_cht_parms, "showCanvasBase", "1", TRUE); // showCanvasBase
ewrpt_SetChartParam($Chart1_cht_parms, "showLimits", "1", TRUE); // showLimits
ewrpt_SetChartParam($Chart1_cht_parms, "animation", "1", TRUE); // animation
ewrpt_SetChartParam($Chart1_cht_parms, "rotateNames", "0", TRUE); // rotateNames
ewrpt_SetChartParam($Chart1_cht_parms, "yAxisMinValue", "0", TRUE); // yAxisMinValue
ewrpt_SetChartParam($Chart1_cht_parms, "yAxisMaxValue", "0", TRUE); // yAxisMaxValue
ewrpt_SetChartParam($Chart1_cht_parms, "showColumnShadow", "0", TRUE); // showColumnShadow
ewrpt_SetChartParam($Chart1_cht_parms, "showPercentageValues", "1", TRUE); // showPercentageValues
ewrpt_SetChartParam($Chart1_cht_parms, "showPercentageInLabel", "1", TRUE); // showPercentageInLabel
ewrpt_SetChartParam($Chart1_cht_parms, "showBarShadow", "0", TRUE); // showBarShadow
ewrpt_SetChartParam($Chart1_cht_parms, "showAnchors", "1", TRUE); // showAnchors
ewrpt_SetChartParam($Chart1_cht_parms, "showAreaBorder", "1", TRUE); // showAreaBorder
ewrpt_SetChartParam($Chart1_cht_parms, "showShadow", "1", TRUE); // showShadow
ewrpt_SetChartParam($Chart1_cht_parms, "formatNumber", "0", TRUE); // formatNumber
ewrpt_SetChartParam($Chart1_cht_parms, "formatNumberScale", "0", TRUE); // formatNumberScale
ewrpt_SetChartParam($Chart1_cht_parms, "decimalSeparator", ".", TRUE); // decimalSeparator
ewrpt_SetChartParam($Chart1_cht_parms, "thousandSeparator", ",", TRUE); // thousandSeparator
ewrpt_SetChartParam($Chart1_cht_parms, "decimalPrecision", "2", TRUE); // decimalPrecision
ewrpt_SetChartParam($Chart1_cht_parms, "divLineDecimalPrecision", "2", TRUE); // divLineDecimalPrecision
ewrpt_SetChartParam($Chart1_cht_parms, "limitsDecimalPrecision", "2", TRUE); // limitsDecimalPrecision
ewrpt_SetChartParam($Chart1_cht_parms, "zeroPlaneShowBorder", "1", TRUE); // zeroPlaneShowBorder
ewrpt_SetChartParam($Chart1_cht_parms, "divLineColor", "#DCDCDC", TRUE); // divLineColor
ewrpt_SetChartParam($Chart1_cht_parms, "showDivLineValue", "1", TRUE); // showDivLineValue
ewrpt_SetChartParam($Chart1_cht_parms, "showAlternateHGridColor", "0", TRUE); // showAlternateHGridColor
ewrpt_SetChartParam($Chart1_cht_parms, "showAlternateVGridColor", "0", TRUE); // showAlternateVGridColor
ewrpt_SetChartParam($Chart1_cht_parms, "hoverCapSepChar", ":", TRUE); // hoverCapSepChar

// Define trend lines
?>
<?php
ewrpt_SortChartData($Chart1_cht_smry, 0);
echo ewrpt_ShowChartFCF(2, $Chart1_cht_id, $Chart1_cht_parms, $Chart1_cht_trends, $Chart1_cht_smry, 550, 440, "");
?>
<br /><br />
	</div><br /></td></tr>
<!-- Bottom Container (End) -->
</table>
<!-- Table Container (End) -->
<?php
$conn->Close();
?>
<?php include "phprptinc/footer.php"; ?>
<?php



// Get row values
function GetRows($opt) {
	global $rs, $val;
	if (!$rs)
		return;
	if ($opt == 1) { // Get first row
		$rs->MoveFirst();
	} else { // Get next row
		$rs->MoveNext();
	}
	while (!$rs->EOF) {
		if (ValidRow($rs)) {
			$GLOBALS['x_entidade'] = $rs->fields('entidade');
			$GLOBALS['x_count28ouvidoria2Eid_entidade29'] = $rs->fields('count(_processo'.$_SESSION['periodo'].'.id_entidade)');
			$GLOBALS['x_total'] = $rs->fields('total');
			$val[1] = $GLOBALS['x_entidade'];
			$val[2] = $GLOBALS['x_count28ouvidoria2Eid_entidade29'];
			$val[3] = $GLOBALS['x_total'];
			break;
		} else {
			$rs->MoveNext();
		}
	}
	if ($rs->EOF) {
		$GLOBALS['x_entidade'] = "";
		$GLOBALS['x_count28ouvidoria2Eid_entidade29'] = "";
		$GLOBALS['x_total'] = "";
	}
}

?>
