			<div class="bd">
				<table>
					<tr>
						<td style="border:0px none;line-height:1.5;">
							<strong><font color="#ff0000">※ </font></strong>
							<span style="color: rgb(255, 0, 0);font-size:12px;"><strong>정류장 [지도]를 클릭하시면 네이버 지도 및 정류장 위치 사진을 볼 수 있습니다.</strong></span><br>
							<font color="#ff0000" style="font-size:12px;"><strong>&nbsp;&nbsp;&nbsp;교통상황으로 인해 셔틀버스가 지연 도착할 수 있으니 양해부탁드립니다.</strong></font><br><br>
							<strong>※ </strong><font style="font-size:12px;"><strong>사전 신청하지 않는 정류장은 정차 및 하차하지 않습니다.</strong></font><br><br>
						</td>
					</tr>
				</table>
			</div>


			<div class="bd max500 well" style="padding-top:7px;background-color: #f5f5f5;">
				<strong style="line-height:2;">
					★ 서울 &rarr; 양양<!--<br>
					※ 도착 : 설악 &gt;&nbsp;동호 &gt; 하조대 &gt; 기사문 &gt; 죽도 &gt; 남애3리-->
				</strong>
				<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;">
					<tbody>
						<tr>
							<td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;background:#1973e1;color:#fff;" value="1호차" onclick="fnBusPoint('Y', 1, this, '여의도');"></td>
							<td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="2호차" onclick="fnBusPoint('Y', 2, this, '당산역');"></td>
							<td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="3호차" onclick="fnBusPoint('Y', 3, this, '목동역');"></td>
							<td style="text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="4호차" onclick="fnBusPoint('Y', 4, this, '시청역');"></td>
						</tr>
					</tbody>
				</table>

				<strong style="line-height:2;">
					★ 양양 &rarr; 서울<!--<br>
					※ 도착 : 잠실역 > 종합운동장역 > 강남역 > 사당역 > 신용산역 > 시청역-->
				</strong>
				
				<table class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;">
					<tbody>
						<tr>
							<td style="width:25%;text-align:center;"><input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="서울행" onclick="fnBusPointJukdo('S', 1, this, '죽도해변');"></td>
							<td style="width:25%;text-align:center;"><!--input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="2호차" onclick="fnBusPoint('S', 2, this, '주문진해변2');"--></td>
							<td style="width:25%;text-align:center;"><!--input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="3호차" onclick="fnBusPoint('S', 3, this, '남애해변');"--></td>
							<td style="width:25%;text-align:center;"><!--input type="button" class="bd_btn" btnpoint="point" style="padding-top:4px;" value="4호차" onclick="fnBusPoint('S', 4, this, '남애해변');"--></td>
						</tr>
					</tbody>
				</table>
			</div>
			<div class="bd max500" style="padding:0px;" id="businit">	
				<table view="tbBusY" class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;display:;">
					<colgroup>
						<col style="width:108px;">
						<col style="width:*;">
						<col style="width:58px;">
					</colgroup>
					<tbody>
						<tr>
							<td colspan="3" height="28"><b>[양양행] <span id="pointnumY01">1</span>호차 셔틀버스</b></td>
						</tr>
						<tr>
							<th style="text-align:center;"><span id="pointnumY1">1</span>호차 정류장</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th>여의도</th>
							<td>여의도공원 횡단보도<br><font color="red">05시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 1, '여의도');"></td>
						</tr>
						<tr>
							<th>신도림</th>
							<td>홈플러스 신도림점 앞<br><font color="red">05시 50분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 1, '신도림');"></td>
						</tr>
						<tr>
							<th>구로디지털단지</th>
							<td>동대문엽기떡볶이 앞 버스정류장<br><font color="red">06시 05분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 1, '구로디지털단지');"></td>
						</tr>
						<tr>
							<th>봉천역</th>
							<td>봉천역 1번출구 앞<br><font color="red">06시 20분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 1, '봉천역');"></td>
						</tr>
						<tr>
							<th>사당역</th>
							<td>신한성약국 앞<br><font color="red">06시 30분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 1, '사당역');"></td>
						</tr>
						<tr>
							<th>강남역</th>
							<td>강남역 1번출구 버스정류장<br><font color="red">06시 45분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 1, '강남역');"></td>
						</tr>
						<tr>
							<th>종합운동장역</th>
							<td>종합운동장역 4번출구 방향 버스정류장<br><font color="red">07시 00분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 7, 1, '종합운동장역');"></td>
						</tr>
						<!--tr>
							<th>잠실역</th>
							<td>잠실역 롯데마트 입구<br><font color="red">06시 00분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, this);"></td>
						</tr-->
						<tr>
							<!--td colspan="3">도착 : 설악 &gt;&nbsp;동호 &gt; 하조대 &gt; 기사문 &gt; 죽도 &gt; 남애3리</td-->
							<td colspan="3">도착 : 하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</td>
						</tr>
					<tbody>
				</table>

				<table view="tbBusY" class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;display:none;">
					<colgroup>
						<col style="width:108px;">
						<col style="width:*;">
						<col style="width:58px;">
					</colgroup>
					<tbody>
						<tr>
							<td colspan="3" height="28"><b>[양양행] <span id="pointnumY02"></span>호차 셔틀버스</b></td>
						</tr>
						<tr>
							<th style="text-align:center;"><span id="pointnumY2"></span>호차 정류장</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th>당산역</th>
							<td>당산역 13출구 앞<br><font color="red">05시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 2, '당산역');"></td>
						</tr>
						<tr>
							<th>합정역</th>
							<td>합정역 3번출구 앞<br><font color="red">05시 45분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 2, '합정역');"></td>
						</tr>
						<tr>
							<th>신촌역</th>
							<td>신촌역 5번출구 앞<br><font color="red">05시 55분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 2, '신촌역');"></td>
						</tr>
						<tr>
							<th>충정로역</th>
							<td>충정로역 4번출구 앞<br><font color="red">06시 05분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 2, '충정로역');"></td>
						</tr>
						<tr>
							<th>종로3가역</th>
							<td>종로3가역 12번출구 새마을금고 앞<br><font color="red">06시 20분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 2, '종로3가역');"></td>
						</tr>
						<tr>
							<th>왕십리역</th>
							<td>왕십리역 11번출구 우리은행 앞<br><font color="red">06시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 2, '왕십리역');"></td>
						</tr>
						<tr>
							<th>건대입구역</th>
							<td>건대입구역 롯데백화점 스타시티점 입구<br><font color="red">07시 00분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 7, 2, '건대입구역');"></td>
						</tr>
						<tr>
							<!--td colspan="3">도착 : 설악 &gt;&nbsp;동호 &gt; 하조대 &gt; 기사문 &gt; 죽도 &gt; 남애3리</td-->
							<td colspan="3">도착 : 하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</td>
						</tr>
					<tbody>
				</table>

				<table view="tbBusY" class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;display:none;">
					<colgroup>
						<col style="width:108px;">
						<col style="width:*;">
						<col style="width:58px;">
					</colgroup>
					<tbody>
						<tr>
							<td colspan="3" height="28"><b>[양양행] <span id="pointnumY03"></span>호차 셔틀버스</b></td>
						</tr>
						<tr>
							<th style="text-align:center;"><span id="pointnumY3"></span>호차 정류장</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th>목동역</th>
							<td>목동역 5번출구 버스정류장<br><font color="red">05시 30분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 3, '목동역');"></td>
						</tr>
						<tr>
							<th>영등포역</th>
							<td>영등포역입구 택시승강장 뒤쪽<br><font color="red">05시 45분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 3, '영등포역');"></td>
						</tr>
						<tr>
							<th>흑석역</th>
							<td>흑석역 3번출구 CU편의점 앞<br><font color="red">06시 05분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 3, '흑석역');"></td>
						</tr>
						<tr>
							<th>신반포역</th>
							<td>신반포역 4번출구<br><font color="red">06시 15분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 3, '신반포역');"></td>
						</tr>
						<tr>
							<th>논현역</th>
							<td>논현역 1번출구 영동가구<br><font color="red">06시 25분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 3, '논현역');"></td>
						</tr>
						<tr>
							<th>강남구청역</th>
							<td>강남구청역 1번출구<br><font color="red">06시 35분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 3, '강남구청역');"></td>
						</tr>
						<tr>
							<th>종합운동장역</th>
							<td>종합운동장역 4번출구 방향 버스정류장<br><font color="red">07시 00분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 7, 1, '종합운동장역');"></td>
						</tr>
						<tr>
							<!--td colspan="3">도착 : 설악 &gt;&nbsp;동호 &gt; 하조대 &gt; 기사문 &gt; 죽도 &gt; 남애3리</td-->
							<td colspan="3">도착 : 하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</td>
						</tr>
					<tbody>
				</table>

				<table view="tbBusY" class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;display:none;">
					<colgroup>
						<col style="width:108px;">
						<col style="width:*;">
						<col style="width:58px;">
					</colgroup>
					<tbody>
						<tr>
							<td colspan="3" height="28"><b>[양양행] <span id="pointnumY04"></span>호차 셔틀버스</b></td>
						</tr>
						<tr>
							<th style="text-align:center;"><span id="pointnumY4"></span>호차 정류장</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th>시청역</th>
							<td>시청역 2번출구<br><font color="red">06시 00분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 1, 4, '시청역');"></td>
						</tr>
						<tr>
							<th>신용산역</th>
							<td>신용산역 4번출구<br><font color="red">06시 20분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 2, 4, '신용산역');"></td>
						</tr>
						<tr>
							<th>사당역</th>
							<td>사당역 10번출구 버거킹<br><font color="red">06시 45분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 3, 4, '사당역4');"></td>
						</tr>
						<tr>
							<th>강남역</th>
							<td>강남역 1번출구 버스정류장<br><font color="red">07시 10분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 4, 4, '강남역4');"></td>
						</tr>
						<tr>
							<th>종합운동장역</th>
							<td>종합운동장역 4번출구 방향 버스정류장<br><font color="red">07시 30분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 5, 4, '종합운동장역4');"></td>
						</tr>
						<tr>
							<th>잠실역</th>
							<td>잠실역 롯데마트 입구<br><font color="red">07시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('Y', 6, 4, '잠실역4');"></td>
						</tr>
						<tr>
							<!--td colspan="3">도착 : 설악 &gt;&nbsp;동호 &gt; 하조대 &gt; 기사문 &gt; 죽도 &gt; 남애3리</td-->
							<td colspan="3">도착 : 하조대 &gt; 기사문 &gt; 동산항 &gt; 죽도 &gt; 인구 &gt; 남애3리 &gt; 주문진</td>
						</tr>
					<tbody>
				</table>
			</div>

			<div class="bd" style="padding:0px;">
				<table view="tbBusS" class="et_vars exForm bd_tb " style="width:100%;margin-bottom:8px;display:none;">
					<colgroup>
						<col style="width:108px;">
						<col style="width:*;">
						<col style="width:58px;">
					</colgroup>
						<tr>
							<th style="text-align:center;">호차</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th style="text-align:center;">1호차<br>(오후 2:40)</th>
							<td>죽도오토캠핑장 입구<br><font color="red">14시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 4, 1, '죽도해변');"></td>
						</tr>
						
						<tr>
							<td colspan="3">도착 : 잠실역 > 종합운동장역 > 강남역 > 사당역 > <b>신용산역 > 시청역</b></td>
						</tr>
						<tr>
							<th style="text-align:center;">호차</th>
							<th style="text-align:center;">탑승장소 및 시간</th>
							<th style="text-align:center;">위치</th>
						</tr>
						<tr>
							<th style="text-align:center;">2호차<br>(오후 5:40)</th>
							<td>죽도오토캠핑장 입구<br><font color="red">17시 40분</font></td>
							<td><input type="button" class="bd_btn " style="padding-top:4px;" value="지도" onclick="fnBusMap('S', 4, 1, '죽도해변2');"></td>
						</tr>
						<tr>
							<td colspan="3">도착 : 잠실역 > 종합운동장역 > 강남역 > 사당역 > <b>당산역 > 합정역</b></td>
						</tr>

					<tbody>
				</table>

			</div>
<iframe scrolling="no" frameborder="0" id="ifrmBusMap" name="ifrmBusMap" style="width:100%;height:400px;display:none;" src="BusRes_SubTab3_Map.php"></iframe>
<span><img style="max-width:100%;display:none;padding-top:3px;" id="mapimg" alt="" src="http://skinnz.godohosting.com/surfenjoy/busimg/Y1_1.JPG"></span>