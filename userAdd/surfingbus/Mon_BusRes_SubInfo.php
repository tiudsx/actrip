<div class="bd_tl inner" style="width:100%;">
	<div class="bd centered" style="padding:0px;">

	<div class="max600">
	<form id="frmRes" action="<?=$folderUrl?>/Mon_BusRes_Save.php" method="post" style="display:;" target="ifrmResize" autocomplete="off">
		<span class="spanresinfo_temp">
			<span style="display:none;">
				<br>hidbusStop:<input type="text" id="hidbusStop" name="hidbusStop" value="A" />
				<br>hidSurfBusY<input type="text" id="hidSurfBusY" name="hidSurfBusY" value="" />
				<br>hidSurfBusS<input type="text" id="hidSurfBusS" name="hidSurfBusS" value="" />
				<br>arrSeatY<input type="text" id="arrSeatY" name="arrSeatY" value="" />
				<br>arrSeatS<input type="text" id="arrSeatS" name="arrSeatS" value="" />
				<input type="text" id="resparam" name="resparam" value="BusI" />
			</span>

			<div class="restab1">
				<div id="busTitle0" style="display:none;"><img src="https://surfenjoy.cdn3.cafe24.com/bus/bustitle0.jpg"></div>
				<div id="selBusY"></div>
				
				<div id="busTitle1" style="display:none;"><img src="https://surfenjoy.cdn3.cafe24.com/bus/bustitle1.jpg"></div>
				<div id="selBusS"></div>
			</div>
			<div class="restab2">
				<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;">
					<tbody>
						<tr>
							<th><em>*</em> 이름</th>
							<td><input type="text" id="userName" name="userName" value="<?=$user_name?>" class="itx" maxlength="15"></td>
						</tr>
						<tr style="display:none;">
							<th><em>*</em> 아이디</th>
							<td><input type="text" id="userId" name="userId" value="<?=$user_id?>" class="itx" maxlength="30" readonly></td>
						</tr>
						<tr>
							<th><em>*</em> 연락처</th>
							<td>
								<input type="number" name="userPhone1" id="userPhone1" value="<?=$userphone[0]?>" size="3" maxlength="3" class="tel itx" style="width:50px;" oninput="maxLengthCheck(this)"> - 
								<input type="number" name="userPhone2" id="userPhone2" value="<?=$userphone[1]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)"> - 
								<input type="number" name="userPhone3" id="userPhone3" value="<?=$userphone[2]?>" size="4" maxlength="4" class="tel itx" style="width:60px;" oninput="maxLengthCheck(this)">
							</td>
						</tr>
						<tr>
							<th scope="row"> 이메일</th>
							<td><input type="text" id="usermail" name="usermail" value="<?=$email_address?>" class="itx"></td>
						</tr>
						<!--tr>
							<th>이용서프샵</th>
							<td><input type="text" id="useShop" name="useShop" value="" class="itx" maxlength="30"></td>
						</tr-->
						<tr>
							<th>이용요금</th>
							<td><span id="totalPrice">0원</span></td>
						</tr>
						<tr>
							<th>특이사항</th>
							<td>
								<textarea name="etc" id="etc" rows="8" cols="42" style="margin: 0px; width: 97%; height: 100px;resize:none;"></textarea>
							</td>
						</tr>
					</tbody>
				</table>

				<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;display:none;">
					<colgroup>
						<col style="width:89px;">
						<col style="width:*;">
					</colgroup>
					<tbody>
						<tr>
							<th colspan="2">죽도해변 바베큐 예약</th>
						</tr>
						<!--tr>
							<th>참석여부</th>
							<td>
								<select id="SurfBBQYN" name="SurfBBQYN" class="select" onchange="fnBBQYN(this.value);">
									<option value="N">미참석</option>
									<option value="Y">참석</option>
								</select>
							</td>
						</tr-->
						<tr id="trBBQYN" style="display:;">
							<th>참석일</th>
							<td>
								<input type="text" id="SurfBBQ" name="SurfBBQ" readonly="readonly" value="" class="itx" cal="bbqdate" maxlength="7" style="width:80px;">
								<select id="SurfBBQMem" name="SurfBBQMem" class="select" onchange="fnPriceSum(this, 2);">
								<?for($r=0;$r<=20;$r++){?>
									<option value="<?=$r?>"><?=$r?>명</option>
								<?}?>
								</select>
							</td>
						</tr>
						<tr id="trBBQYN" style="display:;">
							<th>이용요금</th>
							<td><span id="totalPrice2">0원</span></td>
						</tr>
					<tbody>
				</table>

				<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:5px;">
					<colgroup>
						<col style="width:89px;">
						<col style="width:*;">
					</colgroup>
					<tbody>
						<tr>
							<th>총 결제금액</th>
							<td><span id="lastPrice">0원</span><span id="lastbusPrice" style="display:none;">0</span><span id="lastbbqPrice" style="display:none;">0</span></td>
						</tr>
					<tbody>
				</table>
					
			</div>
			<div style="padding:10px;display:; text-align:center;" id="divBtnRes">
				<div>
					<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:200px; height:44px;" value="셔틀버스 예약" onclick="fnBusSaveMon();" />
				</div>
			</div>
		</span>
	</form>
	</div>

	</div>
</div>
	<!--div class="wellBtn menu">
		<div class="resbottom">
			<button class="reson" id="reson1" onclick="fnResView(true, '.right_article2', 20);"><i></i><span>예약정보로 이동</span></button>
		</div>
	</div-->
