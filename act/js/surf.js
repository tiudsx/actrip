$j(document).ready(function() {
    //지역 카테고리 - 토글
    $j(".btnArea").toggle(function() {
        $j(".listArea").css("display", 'block');
    },
    function() {
        $j(".listArea").css("display", "none");
    });
    
});