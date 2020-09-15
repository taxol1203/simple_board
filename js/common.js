$(document).ready(function(){
    $(".dat_edit_bt").click(function(){
        // 댓글 수정 버튼 클릭시 동작.
        // 기존에는 css 중 display: none로 안보이게 해놨다. 
        var obj = $(this).closest(".dap_lo").find(".dat_edit");
        //closet()은 this(아마 dat_edit_bt 아닐까?)의 모든 부모 요소를 대상으로 dap_lo를 찾아서 선택자로 가져 올 수 있다.
        obj.dialog({
            modal:true,
            width:650,
            height:200,
            title:"댓글 수정"
        });
    });
    $(".dat_delete_bt").click(function(){
        //댓글 삭제 버튼 클릭시 동작
        var obj1 = $(this).closest(".dap_lo").find("dat_delete");
        obj1.dialog({
            modal: true,
            width:400,
            //height:200,
            title:"댓글 삭제 확인"
        });
    });
});

