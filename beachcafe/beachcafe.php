<?php
$conn = mysqli_connect('localhost', 'surfenjoy', 'dltmdcjf2@', 'surfenjoy');
$orderNum = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>해변카페</title>

    <style type="text/css">
        .table {
            display: table;
            border: 3px solid #3571B5;
            width: 100%;
            margin-left: 15px;
        }

        .row {
            display: table-row;
        }

        .cell {
            border: 1px solid #3571B5;
            display: table-cell;
            width: 50%;
            height: 130px;
            vertical-align: middle;
            text-align: center;
            margin-right: 5px;
        }

        .cell-tab {
            border: 1px solid #3571B5;
            display: table-cell;
            height: 50px;
            vertical-align: middle;
            text-align: center;
            margin-right: 5px;
        }

        .tab-select {
            background: #efff006b;
        }

        /*금액계산*/
        .pop-layer .pop-container {
            padding: 10px 10px;
        }

        .pop-layer {
            position: absolute;
            top: 62px;
            left: 40%;
            width: 250px;
            height: auto;
            background-color: #fff;
            border: 3px solid #3571B5;
            z-index: 10;
        }

        .pop-conts div {
            width: 100%;
            text-align: left;
        }

        .pop-conts div p {
            display: inline-block;
        }

        .p-title {
            width: 45%;
            text-align: left;
            margin: 2px 0 0 0;
        }

        .p-conts {
            width: 38%;
            text-align: right;
            margin: 0 0 0 0;
        }

        .p-del {
            width: 10%;
            text-align: center;
            margin: 0 0 0 0;
        }

        /*계산버튼*/
        .pop-cost input {
            width: 31%;
            height: 30px;
            font-size: 13px;
        }

        /*주문내역*/
        .pop-layer2 .pop-container {
            padding: 10px 10px;
        }

        .pop-layer2 {
            position: absolute;
            top: 62px;
            left: 70%;
            width: 230px;
            height: auto;
            background-color: #fff;
            border: 3px solid #3571B5;
            z-index: 10;
        }

        .p-title2 {
            width: 50%;
            text-align: left;
            margin: 2px 0 0 0;
        }

        .p-conts2 {
            height: 20px;
            border: 1px solid #3571B5;
            margin-bottom: 10px;
            padding: 5px 0 10px 5px;
        }

        .p-conts3 {
            width: 30%;
            text-align: right;
            margin: 0 0 0 0;
        }
    </style>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script type="text/javascript">
        var drink_A = [{
            type: "A",
            code: "A001",
            name: "레몬에이드",
            amount: 6000
        }, {
            type: "A",
            code: "A002",
            name: "자몽에이드",
            amount: 6000
        }, {
            type: "A",
            code: "A003",
            name: "후르츠에이드",
            amount: 6000
        }, {
            type: "A",
            code: "A004",
            name: "요거트스무디",
            amount: 6000
        }];
        var drink_B = [{
            type: "B",
            code: "B001",
            name: "죽도선라이즈",
            amount: 8000
        }, {
            type: "B",
            code: "B002",
            name: "케이프코터",
            amount: 8000
        }, {
            type: "B",
            code: "B003",
            name: "마드라스",
            amount: 8000
        }, {
            type: "B",
            code: "B004",
            name: "봄베이하이볼",
            amount: 8000
        }];
        var drink_C = [{
                type: "C",
                code: "C001",
                name: "코로나",
                amount: 8000
            }, {
                type: "C",
                code: "C002",
                name: "호가든",
                amount: 8000
            }
            ,{
                 type : "C"
                ,code : "C003"
                ,name : "하이네켄"
                ,amount : 8000
            }
            , {
                type: "C",
                code: "C004",
                name: "산미구엘",
                amount: 8000
            }

        ];
        var drink_D = [{
            type: "D",
            code: "D001",
            name: "레드",
            amount: 20000
        }, {
            type: "D",
            code: "D002",
            name: "화이트",
            amount: 20000
        }];

        $(function() {

            fnInit();

            //탭선택
            $('.cell-tab').on('click', function() {
                $(this).find("input[type='radio']").prop('checked', true);

                $(".cell-tab").removeClass('tab-select');
                $(this).addClass('tab-select');

                $('div[data-type="menu"]').hide();
                $('div[data-type="menu"][data-menu="' + $(this).find('input[type="radio"]').val() + '"]').show();
            });

            //메뉴선택
            $('div[data-type="menu"] .cell').on('click', function() {
                fnAddDrink($(this).data('name'), $(this).data('code'), $(this).data('amount'));
            });

            //기본탭선택(기본값)
            $(".cell-tab").eq(0).click();

            //주문내역 선택삭제
            $('.pop-layer').on('click', '.p-del', function() {

                if ($(this).parent().find('label[name="count"]').text() > 1) {
                    $(this).parent().find('label[name="count"]').text(($(this).parent().find('label[name="count"]').text() * 1) - 1);
                } else {
                    $(this).parent().remove();
                }

                fnSetAmount();
            });

            //판매대기 삭제
            $('.pop-layer2').on('click', '.p-del', function() {

                if ($(this).parent().find('label[name="count"]').text() > 1) {
                    $(this).parent().find('label[name="count"]').text(($(this).parent().find('label[name="count"]').text() * 1) - 1);
                } else {
                    $(this).parent().remove();
                }

                if ($('[name="costList"] p[data-ordernum="' + $(this).data('ordernum') + '"]').length <= 0) {
                    $('div[name="costList"][data-ordernum="' + $(this).data('ordernum') + '"]').remove();
                }

            });

            //판매완료
            $('#addOrder').on('click', 'p[name="ordernum"]', function() {
                fnEndOrder($(this).data("ordernum"));
            });

            //결제취소
            $('#addOrder').on('click', 'p[name="cancel"]', function() {
                fnCancelOrder($(this).data("ordernum"));
            });

        });

        function fnInit() {
            fnMakeCell("tdrink_A", drink_A);
            fnMakeCell("tdrink_B", drink_B);
            fnMakeCell("tdrink_C", drink_C);
            fnMakeCell("tdrink_D", drink_D);

            var selHtml = '';
            selHtml += '';

            for (let i = 1; i <= 24; i++) {
                selHtml += '<option value="'+i+'">'+i+'</option>';
            }

            $("#turn_num").append(selHtml);

        }

        //메뉴로우 생성
        function fnMakeRow(taget) {
            $('#' + taget).append('<div class="row"></div>');
        }

        //메뉴항목 생성
        function fnMakeCell(taget, data) {
            var rowIndex = 0;
            var celIndex = 0;
            var addHtml = '';

            $.each(data, function(index, value) {

                if (celIndex === 0) {
                    fnMakeRow(taget);
                } else if (celIndex % 2 === 0) {
                    fnMakeRow(taget);
                    rowIndex++;
                }

                addHtml = '';
                addHtml += '<div class="cell" data-code="' + value.code + '" data-name="' + value.name + '" data-amount="' + value.amount + '">';
                addHtml += '<p>' + value.name + '</p>';
                addHtml += '</div>';

                $('#' + taget + ' .row').eq(rowIndex).append(addHtml);

                celIndex++;
            });

        }

        //음료추가
        function fnAddDrink(name, code, amount) {

            if ($('#addDrink').find('input[name="code"][value="' + code + '"]').length >= 1) {
                var thisObj = $('#addDrink').find('input[name="code"][value="' + code + '"]').parent();
                thisObj.find('label[name="count"]').text((thisObj.find('label[name="count"]').text() * 1) + 1);
            } else {
                var addHtml = '';
                addHtml += '<div class="sel_drink" data-drinktype="' + code + '">';
                addHtml += '    <p class="p-title">' + name + '</p>';
                addHtml += '    <p class="p-conts">';
                addHtml += '        <label name="amount">' + amount + '</label>&nbsp;×&nbsp;<label name="count">1</label>&nbsp;';
                addHtml += '    </p>';
                addHtml += '    <p class="p-del" style="border:1px solid red" >X</p>';
                addHtml += '    <input type="hidden" name="code" value="' + code + '" />';
                addHtml += '</div>';

                $("#addDrink").append(addHtml);
            }

            fnSetAmount();

        }

        //총금액
        function fnSetAmount() {

            var totalAmount = 0;
            $('.sel_drink').each(function() {
                totalAmount = totalAmount + $(this).find('[name="amount"]').text() * $(this).find('[name="count"]').text();
            });

            $("#totalAmount").text(totalAmount);

        }

        //주문내역 초기화
        function fnReset() {
            $("#addDrink").empty();
            $("#totalAmount").text(0);
        }

        function fnSetOrder(type) {

            if ($('#addDrink div').length <= 0 ) {
                return;
            }
            else if ($("#turn_num").val() === "") {
                $("#turn_num").focus();
                return;
            }

            $.post("../beachcafe/beachcafe_getorder.php", function(data) {
                var turn_num = $("#turn_num").val();

                if (turn_num > 30) {
                    turn_num = 1;
                }

                if (data == "") {
                    data = 10001;
                    //turn_num
                }

                fnCreateOrder(data, turn_num, type);
                fnReset();

                //$("#turn_num").val(Number(turn_num)+ 1);
                $("#turn_num").val("");
            });

        }

        function fnCreateOrder(orderNum, turn_num, type) {

            var addHtml = '';

            addHtml += '<div name="costList" data-ordernum="' + orderNum + '" data-costtype="' + type + '">';
            addHtml += '<div><p name="ordernum" data-ordernum="' + orderNum + '" >' + orderNum + '-' + turn_num + '</p><p style="color:#fff">-----------</p><p name="cancel" data-ordernum="' + orderNum + '">취소(' + type + ')</p></div>';
            $('#addDrink div[class="sel_drink"]').each(function() {
                addHtml += '<div class="p-conts2">';
                addHtml += '<p class="p-title2">' + $(this).find('.p-title').text() + '</p>';
                addHtml += '<p class="p-conts3">×<label name="count">' + $(this).find('[name="count"]').text() + '</label></p>';
                addHtml += '<input type="hidden" name="code" value="' + $(this).find('input[name="code"]').val() + '" />';
                addHtml += '</div>';

                $.post("../beachcafe/beachcafe_save.php", {
                    orderNum: orderNum,
                    drinCode: $(this).find('input[name="code"]').val(),
                    drinkCount: $(this).find('[name="count"]').text(),
                    orderType: type,
                    turnNum: turn_num
                }, function(data) {
                    //alert(data);
                });

            });

            addHtml += '</div>';
            $("#addOrder").append(addHtml);

        }

        //주문완료
        function fnEndOrder(orderNum) {

            $.post("../beachcafe/beachcafe_update.php", {
                type: "end",
                orderNum: orderNum
            }, function(data) {
                $('div[name="costList"][data-ordernum="' + orderNum + '"]').remove();
            });

        }

        //결제취소
        function fnCancelOrder(orderNum) {

            $.post("../beachcafe/beachcafe_update.php", {
                type: "cancel",
                orderNum: orderNum
            }, function(data) {
                $('div[name="costList"][data-ordernum="' + orderNum + '"]').remove();
            });

        }
    </script>
</head>

<body>

    <div style="width: 100%; text-align: center;">
        <h3>서프엔조이 해변카페</h3>
    </div>

    <!-- 음료정보 -->
    <div style="width: 100%;height: 100%;">
        <!-- 음료종류탭 -->
        <div class="table" style="width: 300px;margin-bottom: 15px;">
            <div class="row">
                <div class="cell-tab tab-select">
                    <p>에이드</p>
                    <input type="radio" name="tab" value="A" style="display: none;" />
                </div>
                <div class="cell-tab">
                    <p>칵테일</p>
                    <input type="radio" name="tab" value="B" style="display: none;" />
                </div>
            </div>
            <div class="row">
                <div class="cell-tab">
                    <p>맥 주</p>
                    <input type="radio" name="tab" value="C" style="display: none;" />
                </div>
                <div class="cell-tab">
                    <p>와 인</p>
                    <input type="radio" name="tab" value="D" style="display: none;" />
                </div>
            </div>
        </div>

        <!-- 에이드 -->
        <div id="tdrink_A" data-type="menu" data-menu="A" class="table" style="width: 300px;display: none;"></div>

        <!-- 칵테일 -->
        <div id="tdrink_B" data-type="menu" data-menu="B" class="table" style="width: 300px;display: none;"></div>

        <!-- 맥주 -->
        <div id="tdrink_C" data-type="menu" data-menu="C" class="table" style="width: 300px;display: none;"></div>

        <!-- 와인 -->
        <div id="tdrink_D" data-type="menu" data-menu="D" class="table" style="width: 300px;display: none;"></div>
    </div>

    <!-- 주문내역 -->
    <div class="pop-layer">
        <div class="pop-container">
            <div class="pop-conts">
                <p style="border-bottom: 2px solid #DDD;padding: 0 0 15px 0;">
                    <b>주문내역</b>
                    <select id="turn_num">
                        <option value="">선택</option>
                    </select>
                </p>

                <div id="addDrink" style="height: 200px;"></div>

                <div style="border-top: 2px solid #DDD;padding: 15px 0 15px 0;">
                    <p class="p-title">총금액</p>
                    <p class="p-conts">
                        <label id="totalAmount">0</label>원
                    </p>
                </div>

                <div class="pop-cost input">
                    <input type="button" onclick="fnReset()" value="초기화" />
                    <input type="button" onclick="fnSetOrder('M')" value="현금" />
                    <input type="button" onclick="fnSetOrder('C')" value="카드" />
                </div>

            </div>
        </div>
    </div>

    <!-- 판매대기 -->
    <div class="pop-layer2">
        <div class="pop-container">
            <div class="pop-conts">
                <p style="border-bottom: 2px solid #DDD;padding: 0 0 15px 0;">
                    <b>판매대기</b>
                </p>
                <div id="addOrder">

                    <?
                        $select_query = 'SELECT ORDER_NUM, ORDER_TYPE, TURN_NUM FROM CAFE_ORDER WHERE STATE IS NULL AND REG_DATE > CURDATE() GROUP BY ORDER_NUM, ORDER_TYPE, TURN_NUM';
	                    $resultSite = mysqli_query($conn, $select_query);
                    ?>

                    <?
                        while ($row = mysqli_fetch_assoc($resultSite)){
                            $select_query_sub = 'SELECT A.* ,B.DRINK_NAME FROM CAFE_ORDER A INNER JOIN CAFE_SALE_INFO B ON A.DRINK_CODE = B.DRINK_CODE WHERE A.STATE IS NULL AND A.REG_DATE > CURDATE() AND A.ORDER_NUM ='.$row['ORDER_NUM'];
	                        $resultSite_sub = mysqli_query($conn, $select_query_sub);
                    ?>

                    <div name="costList" data-ordernum="<?=$row['ORDER_NUM']?>" data-costtype="C">
                        <div>
                            <p name="ordernum" data-ordernum="<?=$row['ORDER_NUM']?>"><?=$row['ORDER_NUM']?>-<?=$row['TURN_NUM']?></p>
                            <p style="color:#fff">-----------</p>
                            <p name="cancel" data-ordernum="<?=$row['ORDER_NUM']?>">취소(<?=$row['ORDER_TYPE']?>)</p>
                        </div>

                        <?
                            while ($rowSub = mysqli_fetch_assoc($resultSite_sub)){
                        ?>
                            <div class="p-conts2">
                                <p class="p-title2"><?=$rowSub['DRINK_NAME']?></p>
                                <p class="p-conts3">×<label name="count"><?=$rowSub['DRINK_CNT']?></label></p><input type="hidden" name="code" value="<?=$rowSub['DRINK_CODE']?>">
                            </div>
                        <?
                            }
                        ?>

                    </div>

                    <?
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>

</body>

</html>