<?php 
include __DIR__.'/../encrypt.php';

include 'menu_top.php';

include 'menu_top_button.php';

$viewType = 0;
$resNumber = $_REQUEST["resNumber"];

if($resNumber != ""){
	$display = "none";
?>
<script>
$j(document).ready(function(){
	fnResSel2();
});
</script>
<?}?>

<script>
var userid = '<?=$user_id?>';
</script>

<div class="bd_tl " style="width:100%;">
	<h1 class="ngeb clear"><i class="bg_color"></i>예약조회</h1>

	<div class="bd_tl inner " style="width:100%;">
		<div class="bd max600 centered" style="padding:0px;">

			<div class="bd" style="margin-top:13px;display:none;padding:0;" id="surfSelOk">
			</div>

			<div style="margin-top:13px;display:<?=$display?>;" id="surfSel">
				<div class="gg_first">예약번호로 조회</div>
				<table class="et_vars exForm bd_tb">
					<tbody>
						<tr>
							<th scope="row"><em>*</em> 예약번호</th>
							<td width="100%">
								<input type="text" id="resNumber" name="resNumber" value="<?=$resNumber?>" class="itx" autocomplete="off">
							</td>
						</tr>
					</tbody>
				</table>

				<div class="write_table" style="padding-top:15px; text-align:center;" id="divBtnRes">
					<div>
						<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:50%; height:40px;" value="예약조회" onclick="fnResSel2();" />
					</div>
				</div>
			</div>

			<?=fnReturnText(0, ''); //환불안내?>
		</div>
	</div>
</div>
<iframe id="ifrmResize" name="ifrmResize" style="width:800px;height:400px;display:none;"></iframe>