		<div id="BusBtn" style="text-align:center;display:none;">
			<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:50%; height:38px;" value="날짜 변경" onclick="fnBusReset();" />
		</div>

		<div id="BusArea" style="display:;">
			<table class="et_vars exForm bd_tb">
				<colgroup>
					<col style="width:90px;">
					<col style="width:100%;">
				</colgroup>
				<tbody>
					<tr>
						<th>출/도착지</th>
						<td>
							<select id="busStop" name="busStop" class="select" onchange="fnBusChange(this.value);">
								<option value="A">왕복 : 서울 <-> 양양</option>
								<option value="Y">편도 : 서울 -> 양양</option>
								<option value="S">편도 : 양양 -> 서울</option>
							</select>
						</td>
					</tr>
					<tr id="trY">
						<th>양양행</th>
						<td>
							<input type="text" id="SurfBusY" name="SurfBusY" readonly="readonly" value="" class="itx2" cal="sbusdate" maxlength="7">
						</td>
					</tr>
					<tr id="trS" style="display:;">
						<th>서울행</th>
						<td>
							<input type="text" id="SurfBusS" name="SurfBusS" readonly="readonly" value="" class="itx2" cal="ebusdate" maxlength="7">
						</td>
					</tr>
				<tbody>
			</table>
			<div style="text-align:center;padding-top:10px;display:none;">
				<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:50%; height:38px;" value="조회하기" onclick="fnBusSearch();" />
			</div>
		</div>
		<span id="AreaScroll"></span>
		<div id="sBusArea1" style="display:none;">
			<div class="gg_first" style="padding-top:10px;">[<span id="spanBusDateY"></span>] 서울 &gt; 양양 셔틀노선</div>
			<table class="et_vars exForm bd_tb">
				<colgroup>
					<col>
					<col style="width:100%;">
					<col>
				</colgroup>
				<tbody>
					<tr>
						<th style="text-align:center;">호차</th>
						<th style="text-align:center;">셔틀버스 노선</th>
						<th>좌석선택</th>
					</tr>
					<tr id="busY1" trId="BusY">
						<th style="text-align:center;">1호차</th>
						<td>여의도 &gt; 신도림 &gt; 구로디지털단지 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 1);"></td>
					</tr>
					<tr id="busY2" trId="BusY">
						<th style="text-align:center;">2호차</th>
						<td>당산역 &gt; 합정역 &gt; 신촌역 &gt; 충정로역 &gt; 종로3가역 &gt; 왕십리역 &gt; 건대입구역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 2);"></td>
					</tr>
					<tr id="busY3" trId="BusY">
						<th style="text-align:center;">3호차</th>
						<td>목동역 &gt; 영등포역 &gt; 흑석역 &gt; 신반포역 &gt; 논현역 &gt; 강남구청역 &gt; 종합운동장역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 3);"></td>
					</tr>
					<tr id="busY4" trId="BusY">
						<th style="text-align:center;">4호차</th>
						<td>시청역 &gt; 신용산 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역 &gt; 잠실역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 4);"></td>
					</tr>
					<tr id="busY5" trId="BusY">
						<th style="text-align:center;">5호차</th>
						<td>여의도 &gt; 신도림 &gt; 구로디지털단지 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 5);"></td>
					</tr>
					<tr id="busY6" trId="BusY">
						<th style="text-align:center;">6호차</th>
						<td>당산역 &gt; 합정역 &gt; 신촌역 &gt; 충정로역 &gt; 종로3가역 &gt; 왕십리역 &gt; 건대입구역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 6);"></td>
					</tr>
					<tr id="busY7" trId="BusY">
						<th style="text-align:center;">7호차</th>
						<td>목동역 &gt; 영등포역 &gt; 흑석역 &gt; 신반포역 &gt; 논현역 &gt; 강남구청역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 7);"></td>
					</tr>
					<tr id="busY8" trId="BusY">
						<th style="text-align:center;">8호차</th>
						<td>시청역 &gt; 신용산 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역 &gt; 잠실역</td>
						<td><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('Y', 8);"></td>
					</tr>
					<tr>
						<td colspan="3">도착 : 하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</td>
					</tr>
				<tbody>
			</table>
		</div>

		<div id="eBusArea1" style="display:none;">
			<div class="gg_first">[<span id="spanBusDateS"></span>] 양양 &gt; 서울 셔틀노선</div>
			<table class="et_vars exForm bd_tb" style="width:100%;" id="busS1" tbId="BusS">
				<colgroup>
					<col style="width:85px;">
					<col style="width:*;">
					<col style="width:85px;">
				</colgroup>
				<tbody>
					<tr>
						<th style="text-align:center;">호차</th>
						<th style="text-align:center;">셔틀버스 노선</th>
						<th style="text-align:center;">좌석선택</th>
					</tr>
					<tr>
						<th style="text-align:center;">1호차<br>(오후 2:15)</th>
						<td>주문진 (청시행비치)</td>
						<td style="text-align:center;"><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('S', 1);"></td>
					</tr>
					<tr>
						<td colspan="3">도착 : 잠실역 &gt; 종합운동장역 &gt; 강남역 &gt; 사당역 &gt; 신용산역 &gt; 시청역</td>
					</tr>
				<tbody>
			</table>
			<table class="et_vars exForm bd_tb" style="width:100%;margin-top:3px;" id="busS2" tbId="BusS">
				<colgroup>
					<col style="width:85px;">
					<col style="width:*;">
					<col style="width:85px;">
				</colgroup>
				<tbody>
					<tr>
						<th style="text-align:center;">2호차<br>(오후 5:15)</th>
						<td>주문진 (청시행비치)</td>
						<td style="text-align:center;"><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('S', 2);"></td>
					</tr>
					<tr>
						<td colspan="3">도착 : 잠실역 &gt; 종합운동장역 &gt; 강남역 &gt; 사당역 &gt; 당산역 &gt; 합정역</td>
					</tr>
				<tbody>
			</table>
			<table class="et_vars exForm bd_tb" style="width:100%;" id="busS3" tbId="BusS">
				<colgroup>
					<col style="width:85px;">
					<col style="width:*;">
					<col style="width:85px;">
				</colgroup>
				<tbody>
					<tr>
						<th style="text-align:center;">3호차<br><span>(오후 2:15)</span></th>
						<td>주문진 (청시행비치)</td>
						<td style="text-align:center;"><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('S', 3);"></td>
					</tr>
					<tr>
						<td colspan="3">도착 : 잠실역 &gt; 종합운동장역 &gt; 강남역 &gt; 사당역 &gt; 신용산역 &gt; 시청역</td>
					</tr>
				<tbody>
			</table>
			<table class="et_vars exForm bd_tb" style="width:100%;margin-top:4px;" id="busS4" tbId="BusS">
				<colgroup>
					<col style="width:85px;">
					<col style="width:*;">
					<col style="width:85px;">
				</colgroup>
				<tbody>
					<tr>
						<th style="text-align:center;">4호차<br>(오후 5:15)</th>
						<td>주문진 (청시행비치)</td>
						<td style="text-align:center;"><input type="button" class="bd_btn " style="padding-top:4px;" value="선택" onclick="fnBusSeatSol('S', 4);"></td>
					</tr>
					<tr>
						<td colspan="3">도착 : 잠실역 &gt; 종합운동장역 &gt; 강남역 &gt; 사당역 &gt; 당산역 &gt; 합정역</td>
					</tr>
				<tbody>
			</table>
		</div>

		<div style="text-align:center;padding-top:10px;display:none;">
			<input type="button" class="gg_btn gg_btn_grid large gg_btn_color" style="width:50%; height:38px;" value="좌석선택하기" onclick="fnBusSeatViewSol();" />
		</div>