function checkAllSelected() {
    var question1 = document.querySelectorAll('.qst1');
    var question2 = document.querySelectorAll('.qst2');
    for (var i = 0; i < question1.length; i++) {
        if (!question1[i].checked && !question2[i].checked) {
            alert(`${i + 1}번째 문제를 아직 선택하지 않았습니다!!`);
            return false;
        }
    }
    return true;
}