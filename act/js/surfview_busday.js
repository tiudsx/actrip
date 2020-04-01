var busPoint = {}
    busPoint.sPointY1 = [];
    busPoint.sPointY1.push({ "code": "N", "codename": "출발" });
    busPoint.sPointY1.push({ "code": "신도림", "codename": "신도림" });
    busPoint.sPointY1.push({ "code": "대림역", "codename": "대림역" });
    busPoint.sPointY1.push({ "code": "봉천역", "codename": "봉천역" });
    busPoint.sPointY1.push({ "code": "사당역", "codename": "사당역" });
    busPoint.sPointY1.push({ "code": "강남역", "codename": "강남역" });
    busPoint.sPointY1.push({ "code": "종합운동장역", "codename": "종합운동장역" });
    
    busPoint.sPointY3 = busPoint.sPointY1;
    busPoint.sPointY5 = busPoint.sPointY1;
    
    busPoint.sPointY2 = [];
    busPoint.sPointY2.push({ "code": "N", "codename": "출발" });
    busPoint.sPointY2.push({ "code": "당산역", "codename": "당산역" });
    busPoint.sPointY2.push({ "code": "합정역", "codename": "합정역" });
    busPoint.sPointY2.push({ "code": "종로3가역", "codename": "종로3가역" });
    busPoint.sPointY2.push({ "code": "왕십리역", "codename": "왕십리역" });
    busPoint.sPointY2.push({ "code": "건대입구역", "codename": "건대입구역" });
    busPoint.sPointY2.push({ "code": "종합운동장역", "codename": "종합운동장역" });
    
    busPoint.sPointY4 = busPoint.sPointY2;
    busPoint.sPointY6 = busPoint.sPointY2;

    busPoint.ePointY = [];
    busPoint.ePointY.push({ "code": "N", "codename": "도착" });
    busPoint.ePointY.push({ "code": "서피비치", "codename": "서피비치" });
    busPoint.ePointY.push({ "code": "기사문", "codename": "기사문" });
    busPoint.ePointY.push({ "code": "동산항", "codename": "동산항" });
    busPoint.ePointY.push({ "code": "죽도", "codename": "죽도" });
    busPoint.ePointY.push({ "code": "인구", "codename": "인구" });
    busPoint.ePointY.push({ "code": "남애3리", "codename": "남애3리" });
    busPoint.ePointY.push({ "code": "청시행비치", "codename": "청시행비치" });
    
    busPoint.sPointE1 = busPoint.sPointY1;
    busPoint.sPointE2 = busPoint.sPointY1;
    busPoint.sPointE3 = busPoint.sPointY1;

    busPoint.ePointE = [];
    busPoint.ePointE.push({ "code": "N", "codename": "도착" });
    busPoint.ePointE.push({ "code": "솔서프", "codename": "솔서프" });
    busPoint.ePointE.push({ "code": "대진항", "codename": "대진항" });
    busPoint.ePointE.push({ "code": "금진해변", "codename": "금진해변" });

    busPoint.sPointS21 = [];
    busPoint.sPointS21.push({ "code": "N", "codename": "출발" });
    busPoint.sPointS21.push({ "code": "청시행비치", "codename": "청시행비치" });
    busPoint.sPointS21.push({ "code": "남애3리", "codename": "남애3리" });
    busPoint.sPointS21.push({ "code": "인구", "codename": "인구" });
    busPoint.sPointS21.push({ "code": "죽도", "codename": "죽도" });
    busPoint.sPointS21.push({ "code": "동산항", "codename": "동산항" });
    busPoint.sPointS21.push({ "code": "기사문", "codename": "기사문" });
    busPoint.sPointS21.push({ "code": "서피비치", "codename": "서피비치" });
    
    busPoint.sPointS22 = busPoint.sPointS21;
    busPoint.sPointS23 = busPoint.sPointS21;
    busPoint.sPointS51 = busPoint.sPointS21;
    busPoint.sPointS52 = busPoint.sPointS21;
    busPoint.sPointS53 = busPoint.sPointS21;

    busPoint.ePointS = [];
    busPoint.ePointS.push({ "code": "N", "codename": "도착" });
    busPoint.ePointS.push({ "code": "잠실역", "codename": "잠실역" });
    busPoint.ePointS.push({ "code": "종합운동장역", "codename": "종합운동장역" });
    busPoint.ePointS.push({ "code": "강남역", "codename": "강남역" });
    busPoint.ePointS.push({ "code": "사당역", "codename": "사당역" });
    busPoint.ePointS.push({ "code": "당산역", "codename": "당산역" });
    busPoint.ePointS.push({ "code": "합정역", "codename": "합정역" });

    busPoint.ePointA = busPoint.ePointS;
    
    busPoint.sPointA21 = [];
    busPoint.sPointA21.push({ "code": "N", "codename": "출발" });
    busPoint.sPointA21.push({ "code": "솔서프", "codename": "솔서프" });
    busPoint.sPointA21.push({ "code": "대진항", "codename": "대진항" });
    busPoint.sPointA21.push({ "code": "금진해변", "codename": "금진해변" });

    busPoint.sPointA22 = busPoint.sPointA21;
    busPoint.sPointA51 = busPoint.sPointA21;
    busPoint.sPointA52 = busPoint.sPointA21;

var busPoint_1 = "신도림 &gt; 대림역 &gt; 봉천역 &gt; 사당역 &gt; 강남역 &gt; 종합운동장역";
var busPoint_2 = "당산역 &gt; 합정역 &gt; 종로3가역 &gt; 왕십리역 &gt; 건대입구역 &gt; 종합운동장역";
var busPoint_3 = "청시행비치 &gt; 남애3리 &gt; 인구 &gt; 죽도 &gt; 동산항 &gt; 기사문 &gt; 서피비치";
var busPoint_4 = "솔서프 &gt; 대진항 &gt; 금진해변";
var busPointList = {
    "Y1" : {li:busPoint_1},
    "Y2" : {li:busPoint_2},
    "Y3" : {li:busPoint_1},
    "Y4" : {li:busPoint_2},
    "Y5" : {li:busPoint_1},
    "Y6" : {li:busPoint_2},
    "E1" : {li:busPoint_1},
    "E2" : {li:busPoint_1},
    "E3" : {li:busPoint_1},
    "S21" : {li:busPoint_3},
    "S22" : {li:busPoint_3},
    "S23" : {li:busPoint_3},
    "S51" : {li:busPoint_3},
    "S52" : {li:busPoint_3},
    "S53" : {li:busPoint_3},
    "A21" : {li:busPoint_4},
    "A22" : {li:busPoint_4},
    "A51" : {li:busPoint_4},
    "A52" : {li:busPoint_4}
};