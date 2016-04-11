<?php $nMenuItems = 0; ?>
<script type="text/javascript">
var EW_REPORT_IMAGES_FOLDER = "phprptimages";
</script>
<script type="text/javascript" src="phprptjs/menu.js"></script>
<table border="0" cellspacing="0" cellpadding="0"><tr><td>
<script type="text/javascript">
var oMenu_base = new Menu();
var oMenu_phpReport = oMenu_base.CreateMenu();
oMenu_phpReport.displayHtml = "Reports";
oMenu_base.AddItem(oMenu_phpReport);
var oMenu_1 = oMenu_base.CreateMenu();
oMenu_1.displayHtml = "ouvidoria res";
oMenu_1.href = "ouvidoria_resrpt.php";
oMenu_phpReport.AddItem(oMenu_1);
oMenu_phpReport.SetOrientation("v");
<?php $nMenuItems++; ?>
var oMenu_1_1 = oMenu_base.CreateLink();
oMenu_1_1.displayHtml = "RELATÓRIO DA OUVIDORIA";
oMenu_1_1.href = "ouvidoria_resrpt.php#cht_Chart1";
oMenu_1.AddItem(oMenu_1_1);
oMenu_base.SetOrientation("h");
oMenu_base.SetSize(150, 20);
<?php if ($nMenuItems > 0) { ?>
oMenu_base.Render();
<?php } ?>
</script>
</td>
</tr></table>
